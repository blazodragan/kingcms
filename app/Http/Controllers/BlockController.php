<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Requests\Block\IndexBlockRequest;
use App\Http\Requests\Block\CreateBlockRequest;
use App\Http\Requests\Block\StoreBlockRequest;
use App\Http\Requests\Block\EditBlockRequest;
use App\Http\Requests\Block\UpdateBlockRequest;
use App\Http\Requests\Block\DestroyBlockRequest;
use App\Http\Requests\Block\BulkDestroyBlockRequest;
use App\Queries\Filters\FuzzyFilter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Enums\Types;
use App\Enums\Status;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class BlockController extends Controller
{

    


    public function index(IndexBlockRequest $request): Response | JsonResponse
    {
        $blocksQuery = QueryBuilder::for(Block::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'name','type','content'
                )),
            ])
            ->defaultSort('id')
            ->allowedSorts('id','name','type','content');

        if ($request->wantsJson() && $request->get('bulk_select_all')) {
            return response()->json($blocksQuery->select(['id'])->pluck('id'));
        }

        $blocks = $blocksQuery
            ->select('id','name','type','content')
            ->paginate($request->get('per_page'))->withQueryString();

        Session::put('blocks_url', $request->fullUrl());

        return Inertia::render('Block/Index', [
            'blocks' => $blocks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(CreateBlockRequest $request): Response
    {
        return Inertia::render('Block/Create', [
            'typeOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Types::cases()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlockRequest $request): RedirectResponse
    {
        $block = Block::create($request->validated());

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Block successfully saved'),
            'durration' => 2000,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditBlockRequest $request, Block $block): Response
    {

        return Inertia::render('Block/Edit', [
            'block' => $block,
            'typeOptions' => array_map(fn ($case) => ['value' => $case, 'label' => $case], Types::cases()),
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlockRequest $request, Block $block): RedirectResponse
    {
            // If validation passes, the code below will execute. Otherwise, the user will be redirected back with errors.
        $data = $request->validated();

        // Update the block with the validated (and sanitized) data
        $block->update($data);
        

   
        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Block successfully update'),
            'durration' => 2000,
        ]);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyBlockRequest $request, Block $block): RedirectResponse
    {
        $block->delete();

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Block successfully deleted'),
            'durration' => 2000,
        ]);
    }

    /**
     * Bulk destroy resource.
     */
    public function bulkDestroy(BulkDestroyBlockRequest $request): RedirectResponse
    {
        // Mass delete of resource
        DB::transaction(function () use ($request) {
            collect($request->validated()['ids'])
                ->chunk(1000)
                ->each(function ($bulkChunk) {
                    Block::whereIn('id', $bulkChunk)->delete();
                });
        });

        // Individual delete of resource items
        //        DB::transaction(function () use ($request) {
        //            collect($request->validated()['ids'])->each(function ($id) {
        //                Block::find($id)->delete();
        //            });
        //        });

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Block successfully deleted'),
            'durration' => 2000,
        ]);
    }

}
