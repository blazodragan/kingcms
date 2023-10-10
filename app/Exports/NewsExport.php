<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Queries\Filters\FuzzyFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\News;

class NewsExport implements FromCollection,WithHeadings
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
        return QueryBuilder::for(News::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id','title','user_id','published_at'
                )),
            ])
            ->defaultSort('id')
            ->allowedSorts('id','title','user_id','published_at')
            ->select(['id','title','user_id','published_at'])
            ->get();
    }

    public function headings(): array
    {
        return [
            trans("craftable-pro.Id"),
            trans("craftable-pro.Title"),
            trans("craftable-pro.Slug"),
            trans("craftable-pro.Perex"),
            trans("craftable-pro.Content"),
            trans("craftable-pro.Reference Link"),
            trans("craftable-pro.Meta Title"),
            trans("craftable-pro.Meta Description"),
            trans("craftable-pro.Meta Url Canolical"),
            trans("craftable-pro.Href Lang"),
            trans("craftable-pro.No Index"),
            trans("craftable-pro.No Follow"),
            trans("craftable-pro.Og Title"),
            trans("craftable-pro.Og Description"),
            trans("craftable-pro.Og Type"),
            trans("craftable-pro.Og Url"),
            trans("craftable-pro.User Id"),
            trans("craftable-pro.Published At"),
        ];
    }
}
