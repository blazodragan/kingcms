<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\IndexPagesRequest;
use App\Http\Requests\Pages\CreatePagesRequest;
use App\Http\Requests\Pages\StorePagesRequest;
use App\Http\Requests\Pages\EditPagesRequest;
use App\Http\Requests\Pages\UpdatePagesRequest;
use App\Http\Requests\Pages\DestroyPagesRequest;
use App\Http\Requests\Pages\BulkDestroyPagesRequest;
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
use App\Exports\PagesExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Enums\Status;
use App\Enums\Templates;
use Illuminate\Database\Eloquent\Builder;
use App\Models\FAQ;
use App\Models\Tip;
use App\Services\BlockResolver;
use App\Traits\IconRetriever;
use Illuminate\Support\Str;
use App\Traits\HasTemplates;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    use IconRetriever;
    use HasTemplates;

    // template folder 
    protected $templatePath = 'pages';

    public function showParent($parentSlug)
    {

        $locale = app()->getLocale();

        $page = Page::where('slug->' . $locale, $parentSlug)->firstOrFail();
        
        // If the page has a parent_id, it's a child and shouldn't be accessible without its parent slug
        if ($page->parent_id) {
            abort(404);
        }

        $page->load('media');
        $page->load('faqs');
        $page->load('tips');
    
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
        return view('pages.show', compact('page', 'processedContent'));

        
    }

    public function showChild($parentSlug, $childSlug)
    {      
        $locale = app()->getLocale();

        $parentPage = Page::where('slug->' . $locale, $parentSlug)->firstOrFail();
               
        $page = Page::where('slug->' . $locale, $childSlug)->where('parent_id', $parentPage->id)->firstOrFail();
        
        $page->load('media');
        $page->load('faqs');
        $page->load('tips');
        $page->load('user');
    
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
        return view('pages.show', compact('page', 'processedContent'));


        
    }

    public function show($slug)
    {
        $page = Page::where('slug->' . app()->getLocale(), $slug)->firstOrFail();

        // If the page doesn't exist, show a 404 page
        if (!$page) {
            abort(404);
        }
        
        $page->load('media');
        $page->load('faqs');
        $page->load('tips');


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
        return view('pages.show', compact('page', 'processedContent'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(IndexPagesRequest $request): Response | JsonResponse
    {
      
        $PagesQuery = QueryBuilder::for(Page::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id',
                    'title',
                )),
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::callback('published_at', fn (Builder $query, $value) => $query->whereDate('published_at', $value)),
            ])
            ->defaultSort('id')
            ->allowedSorts('id', 'title', 'user_id', 'published_at', 'status');

        if ($request->wantsJson() && $request->get('bulk_select_all')) {
            return response()->json($PagesQuery->select(['id'])->pluck('id'));
        }

        $pages = $PagesQuery
            ->with('user','parent')
            ->select('id', 'title', 'user_id', 'published_at', 'status', 'slug', 'parent_id')
            ->paginate($request->get('per_page'))->withQueryString();

        Session::put('pages_url', $request->fullUrl());

        return Inertia::render('Pages/Index', [
            'pages' => $pages,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreatePagesRequest $request): Response
    {
        return Inertia::render('Pages/Create', [
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'tempaltesOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Templates::cases()),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
            'iconOptions' => $this->getAllIconNames(),
            'parentPages' => Page::where('is_parent', true)->get()->map(fn ($model) => ['value' => $model->id, 'label' => $model->title]),
            'templates' => $this->getTemplateNames(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePagesRequest $request): RedirectResponse
    {

        $pages = Page::create($request->validated());
        // Associate the FAQs
        if (isset($request['faqs'])) {
            foreach ($request->input('faqs') as $faqData) {
                $faq = new FAQ([
                    'question' => $faqData['question'],
                    'answer' => $faqData['answer'],
                ]);
                $pages->faqs()->save($faq);
            }
        }
        // Associate the Tips
        if (isset($request['tips'])) {
            foreach ($request->input('tips') as $tipData) {
                $tip = new Tip([
                    'title' => $tipData['title'],
                    'body' => $tipData['body'],
                    'icon' => $tipData['icon'],
                    'type' => $tipData['type'],
                ]);
                $pages->tips()->save($tip);
            }
        }
        return redirect()->route('pages.index')->with('toast', [
            'type' => 'success',
            'message' => __('Pages have been successfully added'),
            'durration' => 2000,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditPagesRequest $request, Page $page): Response
    {

        $page->load('media','faqs','tips','parent');


        return Inertia::render('Pages/Edit', [
            'pages' => $page,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
            'tempaltesOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Templates::cases()),
            'iconOptions' => $this->getAllIconNames(),
            'parentPages' => Page::where('is_parent', true)->get()->map(fn ($model) => ['value' => $model->id, 'label' => $model->title]),
            'templates' => $this->getTemplateNames(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePagesRequest $request, Page $pages): RedirectResponse
    {
        $pages->update($request->validated());

        // Eager load faqs and tips relationships
        $pages->load('media','faqs','tips');

        $faqsData = $request->get('faqs', []);
        $tipsData = $request->get('tips', []);

        $receivedFaqIds = collect($faqsData)->pluck('id')->filter()->all();
        $receivedTipIds = collect($tipsData)->pluck('id')->filter()->all();

        // Check if faqs key is present in the request
        if ($request->has('faqs')) {
            // Delete FAQs not present in the received list
            $pages->faqs()->whereNotIn('id', $receivedFaqIds)->delete();

            foreach ($faqsData as $faqData) {
                $this->updateOrCreateFAQ($pages, $faqData);
            }
        }

        // Check if tips key is present in the request
        if ($request->has('tips')) {
            // Delete Tips not present in the received list
            $pages->tips()->whereNotIn('id', $receivedTipIds)->delete();

            foreach ($tipsData as $tipData) {
                $this->updateOrCreateTip($pages, $tipData);
            }
        }

        return redirect()->route('pages.index')->with('toast', [
            'type' => 'success',
            'message' => __('Pages have been successfully update'),
            'durration' => 2000,
        ]);
    }

            /**
     * Update the specified resource in storage.
     */
    public function date(Request $request, Page $pages): RedirectResponse
    {
            // Validate the 'published_at' attribute
            $validatedData = $request->validate([
                'published_at' => 'nullable',
            ]);
    
            // Update the 'published_at' attribute
            $pages->published_at = $validatedData['published_at'];
    
            // Save the changes; this will also update the 'updated_at' timestamp
            $pages->save();
    
            return redirect()->route('pages.index')->with('toast', [
                'type' => 'success',
                'message' => __('Date have been successfully update'),
                'durration' => 2000,]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyPagesRequest $request, Page $pages): RedirectResponse
    {
        $pages->faqs()->delete();
        
        $pages->tips()->delete();

        $pages->delete();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('Pages have been successfully deleted'),
            'durration' => 2000,
        ]);
    }

    /**
     * Bulk destroy resource.
     */
    public function bulkDestroy(BulkDestroyPagesRequest $request): RedirectResponse
    {
        // Mass delete of resource
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    Page::whereIn('id', $bulkChunk)->delete();
                });
        });

        // Individual delete of resource items
        //        DB::transaction(function () use ($request) {
        //            collect($request->validated()['ids'])->each(function ($id) {
        //                Pages::find($id)->delete();
        //            });
        //        });

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('Pages have been successfully deleted'),
            'durration' => 2000,
        ]);
    }

    /**
     * Export
     */
    public function export(IndexPagesRequest $request): BinaryFileResponse
    {
        return Excel::download(new PagesExport($request->all()), 'Page-' . now()->format("dmYHi") . '.xlsx');
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

    protected function updateOrCreateTip($pages, $tipData)
    {
        if (isset($tipData['id']) && $pages->tips->contains('id', $tipData['id'])) {
            // Update existing Tip
            $tip = $pages->tips()->find($tipData['id']);
            $tip->update([
                'title' => $tipData['title'] ?? null,
                'body' => $tipData['body'] ?? null,
                'icon' => $tipData['icon'] ?? null,
                'type' => $tipData['type'] ?? null,
            ]);
        } else {
            // Create a new Tip
            $tip = new Tip([
                'title' => $tipData['title'] ?? null,
                'body' => $tipData['body'] ?? null,
                'icon' => $tipData['icon'] ?? null,
                'type' => $tipData['type'] ?? null,
            ]);
            $pages->tips()->save($tip);
        }
    }
    public function clone(Page $page): RedirectResponse
    {
        $newpage = $page->replicate(); // Replicate creates a new unsaved instance from the current model
        
        $date = now()->format('Y-m-d');
        $newpage->title = "{$page->title} clone {$date}";
        $newpage->status = Status::DRAFT;
        $baseSlug = Str::slug("{$page->title} clone {$date}");
        $newpage->slug = $this->uniqueSlug($baseSlug);

        $newpage->save();

        // Cloning associated FAQs
        foreach ($page->faqs as $faq) {
            $newFaq = $faq->replicate();
            $newFaq->faqable_id = $newpage->id;
            $newFaq->save();
        }

        // Cloning associated Tips
        foreach ($page->tips as $tip) {
            $newTip = $tip->replicate();
            $newTip->tipable_id = $newpage->id;
            $newTip->save();
        }

        
        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Page cloned'),
            'durration' => 2000,
        ]);
    }
    protected function uniqueSlug($baseSlug)
    {
        $slug = $baseSlug;
        $count = 2; // Start the count for adding suffixes

        while (Page::withTrashed()->where('slug->' . app()->getLocale(), $slug)->exists()) {
            $slug = "{$baseSlug}-" . ($count++);
        }

        return $slug;
    }
}
