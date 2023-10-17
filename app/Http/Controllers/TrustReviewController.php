<?php
namespace App\Http\Controllers;

use App\Models\TrustReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrustReview\IndexTrustReviewRequest;
use App\Http\Requests\TrustReview\CreateTrustReviewRequest;
use App\Http\Requests\TrustReview\StoreTrustReviewRequest;
use App\Http\Requests\TrustReview\EditTrustReviewRequest;
use App\Http\Requests\TrustReview\UpdateTrustReviewRequest;
use App\Http\Requests\TrustReview\DestroyTrustReviewRequest;
use App\Http\Requests\TrustReview\BulkDestroyTrustReviewRequest;
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
use App\Exports\CategoriesExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TrustReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexTrustReviewRequest $request): Response | JsonResponse
    {
        $trustReviewsQuery = QueryBuilder::for(TrustReview::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id','title','description','rating'
                )),
            ])
            ->defaultSort('id')
            ->allowedSorts('id','title','description','rating');

        if ($request->wantsJson() && $request->get('bulk_select_all')) {
            return response()->json($trustReviewsQuery->select(['id'])->pluck('id'));
        }

        $trustReviews = $trustReviewsQuery
            ->select('id','title','description','rating')
            ->paginate($request->get('per_page'))->withQueryString();

        Session::put('trustReviews_url', $request->fullUrl());

        return Inertia::render('TrustReview/Index', [
            'trustReviews' => $trustReviews,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateTrustReviewRequest $request): Response
    {
        return Inertia::render('TrustReview/Create', [
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrustReviewRequest $request): RedirectResponse
    {
        $trustReview = TrustReview::create($request->validated());

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Category successfully saved'),
            'durration' => 2000,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditTrustReviewRequest $request, TrustReview $trustReview): Response
    {
        return Inertia::render('TrustReview/Edit', [
            'trustReview' => $trustReview,
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrustReviewRequest $request, TrustReview $trustReview): RedirectResponse
    {
        $trustReview->update($request->validated());

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('trustReview successfully update'),
            'durration' => 2000,
        ]);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyTrustReviewRequest $request, TrustReview $trustReview): RedirectResponse
    {
        $trustReview->delete();

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('trustReview successfully deleted'),
            'durration' => 2000,
        ]);
    }

    /**
     * Bulk destroy resource.
     */
    public function bulkDestroy(BulkDestroyTrustReviewRequest $request): RedirectResponse
    {
        // Mass delete of resource
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    TrustReview::whereIn('id', $bulkChunk)->delete();
                });
        });

        // Individual delete of resource items
        //        DB::transaction(function () use ($request) {
        //            collect($request->validated()['ids'])->each(function ($id) {
        //                Category::find($id)->delete();
        //            });
        //        });

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('TrustReview successfully deleted'),
            'durration' => 2000,
        ]);
    }

    /**
     * Export
     */
    public function export(IndexTrustReviewRequest $request): BinaryFileResponse
    {
        return Excel::download(new CategoriesExport($request->all()), 'TrustReview-'.now()->format("dmYHi").'.xlsx');
    }
}
