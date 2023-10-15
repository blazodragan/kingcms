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

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexPagesRequest $request): Response | JsonResponse
    {
        $PagesQuery = QueryBuilder::for(Page::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id','title','user_id','published_at','status'
                )),
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::callback('published_at', fn (Builder $query, $value) => $query->whereDate('published_at', $value)),
            ])
            ->defaultSort('id')
            ->allowedSorts('id','title','user_id','published_at','status');

        if ($request->wantsJson() && $request->get('bulk_select_all')) {
            return response()->json($PagesQuery->select(['id'])->pluck('id'));
        }

        $pages = $PagesQuery
            ->with('user')
            ->select('id','title','user_id','published_at','status')
            ->paginate($request->get('per_page'))->withQueryString();

        Session::put('pages_url', $request->fullUrl());

        return Inertia::render('Pages/Index', [
            'pages' => $pages,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'categoriesOptions' => Category::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->alias]),
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePagesRequest $request): RedirectResponse
    {
        $pages = Page::create($request->validated());

        return redirect()->route('pages.index')->with('toast', [
            'type' => 'success',
            'message' => __('Pages have been successfully added'),
            'durration' => 2000,]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditPagesRequest $request, Page $page): Response
    {

        $page->load('media');

        return Inertia::render('Pages/Edit', [
            'pages' => $page,
            'userOptions' => User::all()->map(fn ($model) => ['value' => $model->id, 'label' => $model->name]),
            'statusOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Status::cases()),
            'tempaltesOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Templates::cases()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePagesRequest $request, Page $pages): RedirectResponse
    {
        $pages->update($request->validated());

        return redirect()->route('pages.index')->with('toast', [
            'type' => 'success',
            'message' => __('Pages have been successfully update'),
            'durration' => 2000,]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyPagesRequest $request, Page $page): RedirectResponse
    {
        
        $page->delete();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => __('Pages have been successfully deleted'),
            'durration' => 2000,]);
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
            'durration' => 2000,]);
    }

    /**
     * Export
     */
    public function export(IndexPagesRequest $request): BinaryFileResponse
    {
        return Excel::download(new PagesExport($request->all()), 'Page-'.now()->format("dmYHi").'.xlsx');
    }
}
