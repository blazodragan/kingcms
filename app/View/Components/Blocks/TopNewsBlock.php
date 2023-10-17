<?php
namespace App\View\Components\Blocks;

use Illuminate\View\Component;
use App\Models\News;

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