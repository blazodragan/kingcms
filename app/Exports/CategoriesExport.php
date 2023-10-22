<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Queries\Filters\FuzzyFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Category;

class CategoriesExport implements FromCollection,WithHeadings
{
    protected mixed $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        return QueryBuilder::for(Category::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id','alias','slug','title','description','type'
                )),
            ])
            ->defaultSort('id')
            ->allowedSorts('id','alias','slug','title','description','type')
            ->select(['id','alias','slug','title','description','type'])
            ->get();
    }

    public function headings(): array
    {
        return [
            "Id",
            "Alias",
            "Slug",
            "Title",
            "Description",
            "Type",
        ];
    }
}
