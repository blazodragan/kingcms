<?php
namespace App\View\Components\Blocks;

use Illuminate\View\Component;
use App\Models\News;
use App\Enums\Status;
class TopNewsBlock extends Component
{
    public $newsItems;

    public function __construct($count = 5,  $category = null, $term = null, $order = 'desc', $orderby = 'created_at')
    {
        // Query the news model
        $query = News::query();

            // If a category slug is specified, filter by category
        if ($category) {
            $query->whereHas('categories', function($query) use ($category) {
                $query->where('alias', $category); 
            });
        }

        // If a search term is specified, filter by term
        if ($term) {
            $query->where('title', 'LIKE', '%' . $term . '%');
        }
        // Filter reviews that are published
        $query->where('status', Status::PUBLISHED);

        // Filter reviews that have a published_at date of today or earlier
        $query->whereDate('published_at', '<=', now());

        // Order the results
        $query->orderBy($orderby, $order);

        // Limit the results
        $this->newsItems = $query->take($count)->get();


    }

    public function render()
    {
        return view('components.news-block', ['newsItems' => $this->newsItems]);
    }
}