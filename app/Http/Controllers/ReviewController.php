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
use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexReviewRequest $request): Response | JsonResponse
    {
        $reviewsQuery = QueryBuilder::for(Review::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id','title','active','user_id','published_at','category'
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
            ->select('id','title','active','user_id','published_at','status')
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
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
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
                    'question' => json_encode($faqData['question']),
                    'answer' => json_encode($faqData['answer']),
                ]);
                $review->faqs()->save($faq);
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
        $review->load('media');

        $review->load('categories');

        $review->load('faqs');
        return Inertia::render('Review/Edit', [
            'review' => $review,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
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

        $checkIfChaningDate = $request->get('faqs');

        // Collect FAQ IDs from the request
        $receivedFaqIds = collect($request->get('faqs'))
            ->pluck('id')
            ->filter()
            ->all();
                

        // Update or create the FAQs
        if (!empty($receivedFaqIds) or !empty($checkIfChaningDate)) {
            // Delete FAQs not present in the received list
            $review->faqs()
            ->whereNotIn('id', $receivedFaqIds)
            ->delete();

            foreach ($request->get('faqs') as $faqData) {

                if (isset($faqData['id']) && $review->faqs->contains('id', $faqData['id'])) {
                    // Update existing FAQ
                    $faq = $review->faqs()->find($faqData['id']);

                    $faq->update(['question' => json_encode($faqData['question']), 'answer' => json_encode($faqData['answer'])]);
                } else {
                    // Create a new FAQ
                    $faq = new FAQ([
                        'question' => json_encode($faqData['question']),
                        'answer' => json_encode($faqData['answer']),
                    ]);
                    $review->faqs()->save($faq);
                }
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
        
        $review->delete();

        return redirect()->back()->with(['message' => ___('craftable-pro', 'Operation successful')]);
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

        // Individual delete of resource items
        //        DB::transaction(function () use ($request) {
        //            collect($request->validated()['ids'])->each(function ($id) {
        //                Review::find($id)->delete();
        //            });
        //        });

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Operation successful'),
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
}
