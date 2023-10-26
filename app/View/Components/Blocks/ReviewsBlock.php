<?php
namespace App\View\Components\Blocks;

use Illuminate\View\Component;
use App\Models\Review;
use App\Enums\Status;
class ReviewsBlock extends Component
{
    public $pageItems;

    public function __construct($count = 5, $term = null, $order = 'desc', $orderby = 'created_at')
    {
        // Query the news model
        $query = Review::query();

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
        $this->pageItems = $query->take($count)->get();


    }

    public function render()
    {
        return view('components.review-block', ['pageItems' => $this->pageItems]);
    }
}