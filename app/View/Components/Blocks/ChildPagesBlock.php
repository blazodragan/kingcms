<?php
namespace App\View\Components\Blocks;

use Illuminate\View\Component;
use App\Models\Page;
use App\Enums\Status;

class ChildPagesBlock extends Component
{
    public $pageItems;

    public function __construct($count = 5,  $parent_id = null, $term = null, $order = 'desc', $orderby = 'created_at')
    {
        // Query the news model
        $query = Page::query();

        // Eager load the parent page for each page
        $query->with('parent');

      // If a parent_id is specified, filter by it
        if ($parent_id) {
            $query->where('parent_id', $parent_id);
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
        $this->pageItems = $query->take($count)->get();


    }

    public function render()
    {
        return view('components.page-block', ['pageItems' => $this->pageItems]);
    }
}