<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\IndexCategoryRequest;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\EditCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\Category\DestroyCategoryRequest;
use App\Http\Requests\Category\BulkDestroyCategoryRequest;
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

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexCategoryRequest $request): Response | JsonResponse
    {
        $categoriesQuery = QueryBuilder::for(Category::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id','alias','slug','title','description'
                )),
            ])
            ->defaultSort('id')
            ->allowedSorts('id','alias','slug','title','description');

        if ($request->wantsJson() && $request->get('bulk_select_all')) {
            return response()->json($categoriesQuery->select(['id'])->pluck('id'));
        }

        $categories = $categoriesQuery
            ->select('id','alias','slug','title','description')
            ->paginate($request->get('per_page'))->withQueryString();

        Session::put('categories_url', $request->fullUrl());

        return Inertia::render('Category/Index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateCategoryRequest $request): Response
    {
        return Inertia::render('Category/Create', [
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $category = Category::create($request->validated());

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Category successfully saved'),
            'durration' => 2000,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditCategoryRequest $request, Category $category): Response
    {
        $category->load('media');

        return Inertia::render('Category/Edit', [
            'category' => $category,
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        if (session('categories_url')) {
            return redirect(session('categories_url'))->with('toast', [
                'type' => 'success',
                'message' => __('Category successfully update'),
                'durration' => 2000,
            ]);
        }

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Category successfully update'),
            'durration' => 2000,
        ]);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->delete();

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Category successfully deleted'),
            'durration' => 2000,
        ]);
    }

    /**
     * Bulk destroy resource.
     */
    public function bulkDestroy(BulkDestroyCategoryRequest $request): RedirectResponse
    {
        // Mass delete of resource
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    Category::whereIn('id', $bulkChunk)->delete();
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
            'message' => __('Category successfully deleted'),
            'durration' => 2000,
        ]);
    }

    /**
     * Export
     */
    public function export(IndexCategoryRequest $request): BinaryFileResponse
    {
        return Excel::download(new CategoriesExport($request->all()), 'Categories-'.now()->format("dmYHi").'.xlsx');
    }
}
