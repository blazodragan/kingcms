<?php
namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\News\IndexNewsRequest;
use App\Http\Requests\News\CreateNewsRequest;
use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Requests\News\EditNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Http\Requests\News\DestroyNewsRequest;
use App\Http\Requests\News\BulkDestroyNewsRequest;
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
use App\Exports\NewsExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexNewsRequest $request): Response | JsonResponse
    {
        $newsQuery = QueryBuilder::for(News::class)
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
            return response()->json($newsQuery->select(['id'])->pluck('id'));
        }

        $news = $newsQuery
            ->with('user', 'categories')
            ->select('id','title','user_id','published_at','status')
            ->paginate($request->get('per_page'))->withQueryString();

        Session::put('news_url', $request->fullUrl());

        return Inertia::render('News/Index', [
            'news' => $news,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateNewsRequest $request): Response
    {
        return Inertia::render('News/Create', [
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $news = News::create($request->validated());

        
        if ($request->input('categories_ids')) {
            $news->categories()->sync($request->input('categories_ids'));
        }
        return redirect()->route('news.index')->with('toast', [
            'type' => 'success',
            'message' => __('News have been successfully added'),
            'durration' => 2000,]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditNewsRequest $request, News $news): Response
    {
        $news->load('media');

        $news->load('categories');
        
        return Inertia::render('News/Edit', [
            'news' => $news,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news): RedirectResponse
    {
        $news->update($request->validated());

        if ($request->input('categories_ids')) {
            $news->categories()->sync($request->input('categories_ids'));
        }

        return redirect()->route('news.index')->with('toast', [
            'type' => 'success',
            'message' => __('News have been successfully update'),
            'durration' => 2000,]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyNewsRequest $request, News $news): RedirectResponse
    {
        dd($news);
        $news->categories()->detach();
        
        $news->delete();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('News have been successfully deleted'),
            'durration' => 2000,]);
    }

    /**
     * Bulk destroy resource.
     */
    public function bulkDestroy(BulkDestroyNewsRequest $request): RedirectResponse
    {
        // Mass delete of resource
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    News::whereIn('id', $bulkChunk)->delete();
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
            'message' => __('News have been successfully deleted'),
            'durration' => 2000,]);
    }

    /**
     * Export
     */
    public function export(IndexNewsRequest $request): BinaryFileResponse
    {
        return Excel::download(new NewsExport($request->all()), 'News-'.now()->format("dmYHi").'.xlsx');
    }
}
