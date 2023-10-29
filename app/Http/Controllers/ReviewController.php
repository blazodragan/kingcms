<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\IndexReviewRequest;
use App\Http\Requests\Review\CreateReviewRequest;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\EditReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Requests\Review\DestroyReviewRequest;
use App\Http\Requests\Review\BulkDestroyReviewRequest;
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
use App\Exports\ReviewsExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\FAQ;
use App\Models\Tip;
use App\Traits\IconRetriever;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasTemplates;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    use IconRetriever;
    use HasTemplates;

    // template folder 
    protected $templatePath = 'review';

    public function show(Review $review)
    {

        // If the page doesn't exist, show a 404 page
        if (!$review) {
            abort(404);
        }
        $review->load('media');
        $review->load('faqs');
        $review->load('tips');


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
        }, $review->content);

        if ($review->template) {

            $templateName = $this->templatePath . '.' . $review->template;

            return view($templateName, compact('review', 'processedContent'));
        } 
        
        // Render the page (e.g., using a view)
        return view('review.show', compact('review', 'processedContent'));

    }
    /**
     * Display a listing of the resource.
     */
    public function index(IndexReviewRequest $request): Response | JsonResponse
    {
        $reviewsQuery = QueryBuilder::for(Review::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id','title'
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
            ->allowedSorts('id','title','active','user_id','published_at');

        if ($request->wantsJson() && $request->get('bulk_select_all')) {
            return response()->json($reviewsQuery->select(['id'])->pluck('id'));
        }

        $reviews = $reviewsQuery
            ->with('user', 'categories')
            ->select('id','title','active','user_id','published_at','status','slug')
            ->paginate($request->get('per_page'))->withQueryString();

        Session::put('reviews_url', $request->fullUrl());

        return Inertia::render('Review/Index', [
            'reviews' => $reviews,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateReviewRequest $request): Response
    {
    
        return Inertia::render('Review/Create', [
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::where('type', 'location')->get()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
            'iconOptions' => $this->getAllIconNames(),
            'templates' => $this->getTemplateNames(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request): RedirectResponse
    {
    
        $review = Review::create($request->validated());
        // Associate the FAQs
        if (isset($request['faqs'])) {
            foreach ($request->input('faqs') as $faqData) {
                $faq = new FAQ([
                    'question' => $faqData['question'],
                    'answer' => $faqData['answer'],
                ]);
                $review->faqs()->save($faq);
            }
        }
        // Associate the Tips
        if (isset($request['tips'])) {
            foreach ($request->input('tips') as $tipData) {
                $tip = new Tip([
                    'title' => $tipData['title'] ?? null,
                    'body'  => $tipData['body']  ?? null,
                    'icon'  => $tipData['icon']  ?? null,
                    'type'  => $tipData['type']  ?? null,
                ]);
                $review->tips()->save($tip);
            }
        }

        if ($request->input('categories_ids')) {
            $review->categories()->sync($request->input('categories_ids'));
        }

        return redirect()->route('reviews.index')->with('toast', [
            'type' => 'success',
            'message' => __('Review have been successfully added'),
            'durration' => 2000,]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditReviewRequest $request, Review $review): Response
    {
        $review->load('media','categories','faqs','tips'); 

        return Inertia::render('Review/Edit', [
            'review' => $review,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
            'iconOptions' => $this->getAllIconNames(),
            'templates' => $this->getTemplateNames(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review): RedirectResponse
    {
     
        $review->update($request->validated());
 
        
        if ($request->input('categories_ids')) {
            $review->categories()->sync($request->input('categories_ids'));
        }

        // Eager load faqs and tips relationships
        $review->load('faqs', 'tips');

        $faqsData = $request->get('faqs', []);
        $tipsData = $request->get('tips', []);

        $receivedFaqIds = collect($faqsData)->pluck('id')->filter()->all();
        $receivedTipIds = collect($tipsData)->pluck('id')->filter()->all();

        // Check if faqs key is present in the request
        if ($request->has('faqs')) {
            // Delete FAQs not present in the received list
            $review->faqs()->whereNotIn('id', $receivedFaqIds)->delete();

            foreach ($faqsData as $faqData) {
                $this->updateOrCreateFAQ($review, $faqData);
            }
        }

        // Check if tips key is present in the request
        if ($request->has('tips')) {
            // Delete Tips not present in the received list
            $review->tips()->whereNotIn('id', $receivedTipIds)->delete();

            foreach ($tipsData as $tipData) {
                $this->updateOrCreateTip($review, $tipData);
            }
        }

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Review have been successfully updated'),
            'durration' => 2000,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyReviewRequest $request, Review $review): RedirectResponse
    {
        
        $review->categories()->detach();

        $review->faqs()->delete();

        $review->tips()->delete();
        
        $review->delete();

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Review have been successfully deleted'),
            'durration' => 2000,
        ]);
    }

    /**
     * Bulk destroy resource.
     */
    public function bulkDestroy(BulkDestroyReviewRequest $request): RedirectResponse
    {
        // Mass delete of resource
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    // First, delete the related FAQs for the chunk of reviews
                    DB::table('faqs')->whereIn('faqable_id', $bulkChunk)->where('faqable_type', 'App\Models\Review')->delete();
                    // Then, delete the reviews themselves
                    Review::whereIn('id', $bulkChunk)->delete();
                });
        });

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Operation successful'),
            'durration' => 2000,
        ]);
    }

    /**
     * Clone the specified resource from storage.
     */
    public function clone(Review $review): RedirectResponse
    {
        $newReview = $review->replicate(); // Replicate creates a new unsaved instance from the current model
        
        $date = now()->format('Y-m-d');
        $newReview->title = "{$review->title} clone {$date}";
        $newReview->status = Status::DRAFT;
        $baseSlug = Str::slug("{$review->title} clone {$date}");
        $newReview->slug = $this->uniqueSlug($baseSlug);

        $newReview->save();

        // Cloning associated FAQs
        foreach ($review->faqs as $faq) {
            $newFaq = $faq->replicate();
            $newFaq->faqable_id = $newReview->id;
            $newFaq->save();
        }

        // Cloning associated Tips
        foreach ($review->tips as $tip) {
            $newTip = $tip->replicate();
            $newTip->tipable_id = $newReview->id;
            $newTip->save();
        }

        $categoryIds = $review->categories->pluck('id')->toArray();
        $newReview->categories()->sync($categoryIds);

        
        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Review cloned'),
            'durration' => 2000,
        ]);
    }

    /**
     * Export
     */
    public function export(IndexReviewRequest $request): BinaryFileResponse
    {
        return Excel::download(new ReviewsExport($request->all()), 'Reviews-'.now()->format("dmYHi").'.xlsx');
    }

    protected function updateOrCreateFAQ($review, $faqData)
    {
        if (isset($faqData['id']) && $review->faqs->contains('id', $faqData['id'])) {
            // Update existing FAQ
            $faq = $review->faqs()->find($faqData['id']);
            $faq->update(['question' => $faqData['question'], 'answer' => $faqData['answer']]);
        } else {
            // Create a new FAQ
            $faq = new FAQ(['question' => $faqData['question'], 'answer' => $faqData['answer']]);
            $review->faqs()->save($faq);
        }
    }

    protected function updateOrCreateTip($review, $tipData)
    {
        if (isset($tipData['id']) && $review->tips->contains('id', $tipData['id'])) {
            // Update existing Tip
            $tip = $review->tips()->find($tipData['id']);
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
            $review->tips()->save($tip);
        }
    }

    protected function uniqueSlug($baseSlug)
    {
        $slug = $baseSlug;
        $count = 2; // Start the count for adding suffixes

        while (Review::withTrashed()->where('slug->' . app()->getLocale(), $slug)->exists()) {
            $slug = "{$baseSlug}-" . ($count++);
        }

        return $slug;
    }


}
