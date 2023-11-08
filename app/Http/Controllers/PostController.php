<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\IndexPostRequest;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\EditPostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Requests\Post\DestroyPostRequest;
use App\Http\Requests\Post\BulkDestroyPostRequest;
use App\Queries\Filters\FuzzyFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PostExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use App\Models\FAQ;
use Illuminate\Support\Str;
use App\Traits\HasTemplates;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use HasTemplates;

    // template folder 
    protected $templatePath = 'posts';

    public function show($slug)
    {
        $locale = app()->getLocale();
        $page = Post::where('slug->' . $locale, $slug)->firstOrFail();


        // If the page doesn't exist, show a 404 page
        if (!$page) {
            abort(404);
        }
        $page->load('media');
        $page->load('faqs');


        $processedContent = preg_replace_callback('/@block\(\s*\'([^\']+)\'\s*(?:,\s*(\[[^\]]+\]))?\s*\)/', function ($matches) {
            $blockName = $matches[1];
            $paramsStr = isset($matches[2]) ? $matches[2] : '';

            if ($paramsStr) {
                // Convert Laravel array syntax to JSON string
                $paramsStr = html_entity_decode($paramsStr);
                $jsonStr = str_replace(['[', ']', '=>', "'"], ['{', '}', ':', '"'], $paramsStr);
                // Decode the JSON string to an array
                $parameters = json_decode($jsonStr, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // If there's an error in decoding the JSON, just return the string as is
                    return $matches[0];
                }
            } else {
                $parameters = [];
            }

            // Use the block resolver to fetch the block content
            return app(\App\Services\BlockResolver::class)->resolve($blockName, $parameters);
        }, $page->content);

        if ($page->template) {

            $templateName = $this->templatePath . '.' . $page->template;

            return view($templateName, compact('page', 'processedContent'));
        } 
        
        // Render the page (e.g., using a view)
        return view('posts.show', compact('page', 'processedContent'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(IndexPostRequest $request): Response | JsonResponse
    {
        $postQuery = QueryBuilder::for(Post::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'title','status'
                )),
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::callback('published_at', fn (Builder $query, $value) => $query->whereDate('published_at', $value)),
                AllowedFilter::callback('category', function (Builder $query, $value) {
                    return $query->whereHas('categories', function (Builder $query) use ($value) {
                        $query->whereIn('categories.id', $value);
                    });
                }),
            ])
            ->defaultSort('id')
            ->allowedSorts('id','title','user_id','published_at','status');

        if ($request->wantsJson() && $request->get('bulk_select_all')) {
            return response()->json($postQuery->select(['id'])->pluck('id'));
        }

        $post = $postQuery
            ->with('user', 'categories')
            ->select('id','title','user_id','published_at','status', 'slug')
            ->paginate($request->get('per_page'))->withQueryString();

        Session::put('post_url', $request->fullUrl());

        return Inertia::render('Post/Index', [
            'posts' => $post,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreatePostRequest $request): Response
    {
        return Inertia::render('Post/Create', [
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
            'templates' => $this->getTemplateNames(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = Post::create($request->validated());
        // Associate the FAQs
        if (isset($request['faqs'])) {
            foreach ($request->input('faqs') as $faqData) {
                $faq = new FAQ([
                    'question' => $faqData['question'],
                    'answer' => $faqData['answer'],
                ]);
                $post->faqs()->save($faq);
            }
        }
        
        if ($request->input('categories_ids')) {
            $post->categories()->sync($request->input('categories_ids'));
        }
        return redirect()->route('posts.index')->with('toast', [
            'type' => 'success',
            'message' => __('Post has been successfully added'),
            'durration' => 2000,]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditPostRequest $request, Post $post): Response
    {
        $post->load('media','faqs','categories');

        return Inertia::render('Post/Edit', [
            'post' => $post,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
            'templates' => $this->getTemplateNames(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->validated());

        $post->load('media','faqs','categories');

        $faqsData = $request->get('faqs', []);
        $receivedFaqIds = collect($faqsData)->pluck('id')->filter()->all();

        // Check if faqs key is present in the request
        if ($request->has('faqs')) {
            // Delete FAQs not present in the received list
            $post->faqs()->whereNotIn('id', $receivedFaqIds)->delete();

            foreach ($faqsData as $faqData) {
                $this->updateOrCreateFAQ($post, $faqData);
            }
        }

        if ($request->input('categories_ids')) {
            $post->categories()->sync($request->input('categories_ids'));
        }

        return redirect()->route('posts.index')->with('toast', [
            'type' => 'success',
            'message' => __('Post have been successfully update'),
            'durration' => 2000,]);
        
    }

        /**
     * Update the specified resource in storage.
     */
    public function date(Request $request, Post $post): RedirectResponse
    {
            // Validate the 'published_at' attribute
            $validatedData = $request->validate([
                'published_at' => 'nullable',
            ]);
    
            // Update the 'published_at' attribute
            $post->published_at = $validatedData['published_at'];
    
            // Save the changes; this will also update the 'updated_at' timestamp
            $post->save();
    
            return redirect()->route('posts.index')->with('toast', [
                'type' => 'success',
                'message' => __('Date have been successfully update'),
                'durration' => 2000,]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyPostRequest $request, Post $post): RedirectResponse
    {
        $post->categories()->detach();
        
        $post->delete();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('Post have been successfully deleted'),
            'durration' => 2000,]);
    }

    /**
     * Bulk destroy resource.
     */
    public function bulkDestroy(BulkDestroyPostRequest $request): RedirectResponse
    {
        // Mass delete of resource
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    Post::whereIn('id', $bulkChunk)->delete();
                });
        });

        // Individual delete of resource items
        //        DB::transaction(function () use ($request) {
        //            collect($request->validated()['ids'])->each(function ($id) {
        //                News::find($id)->delete();
        //            });
        //        });

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('Posts have been successfully deleted'),
            'durration' => 2000,]);
    }

    public function clone(Post $post): RedirectResponse
    {
        $newPost = $post->replicate(); // Replicate creates a new unsaved instance from the current model
        
        $date = now()->format('Y-m-d');
        $newPost->title = "{$post->title} clone {$date}";
        $newPost->status = Status::DRAFT;
        $baseSlug = Str::slug("{$post->title} clone {$date}");
        $newPost->slug = $this->uniqueSlug($baseSlug);

        $newPost->save();

        // Cloning associated FAQs
        foreach ($post->faqs as $faq) {
            $newFaq = $faq->replicate();
            $newFaq->faqable_id = $newPost->id;
            $newFaq->save();
        }

        // // Cloning associated Tips
        // foreach ($post->tips as $tip) {
        //     $newTip = $tip->replicate();
        //     $newTip->tipable_id = $newPost->id;
        //     $newTip->save();
        // }

        $categoryIds = $post->categories->pluck('id')->toArray();
        $newPost->categories()->sync($categoryIds);

        
        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Post cloned'),
            'durration' => 2000,
        ]);
    }

    /**
     * Export
     */
    public function export(IndexPostRequest $request): BinaryFileResponse
    {
        return Excel::download(new PostExport($request->all()), 'Post-'.now()->format("dmYHi").'.xlsx');
    }

    protected function updateOrCreateFAQ($pages, $faqData)
    {
        if (isset($faqData['id']) && $pages->faqs->contains('id', $faqData['id'])) {
            // Update existing FAQ
            $faq = $pages->faqs()->find($faqData['id']);
            $faq->update(['question' => $faqData['question'], 'answer' => $faqData['answer']]);
        } else {
            // Create a new FAQ
            $faq = new FAQ(['question' => $faqData['question'], 'answer' => $faqData['answer']]);
            $pages->faqs()->save($faq);
        }
    }
    protected function uniqueSlug($baseSlug)
    {
        $slug = $baseSlug;
        $count = 2; // Start the count for adding suffixes

        while (Post::withTrashed()->where('slug->' . app()->getLocale(), $slug)->exists()) {
            $slug = "{$baseSlug}-" . ($count++);
        }

        return $slug;
    }
}
