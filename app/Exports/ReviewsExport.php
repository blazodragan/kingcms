<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Queries\Filters\FuzzyFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Review;

class ReviewsExport implements FromCollection,WithHeadings
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
        return QueryBuilder::for(Review::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id','title','active','user_id','published_at'
                )),
            ])
            ->defaultSort('id')
            ->allowedSorts('id','title','active','user_id','published_at')
            ->select(['id','title','active','user_id','published_at'])
            ->get();
    }

    public function headings(): array
    {
        return [
            "Id",
            "Title",
            "Slug",
            "Perex",
            "Content",
            "Text",
            "Active",
            "Meta Title",
            "Meta Description",
            "Meta Url Canolical",
            "Href Lang",
            "No Index",
            "No Follow",
            "Og Title",
            "Og Description",
            "Og Type",
            "Og Url",
            "User Id",
            "Published At",
        ];
    }
}
