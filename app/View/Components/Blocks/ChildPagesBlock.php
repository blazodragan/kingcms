<?php
namespace App\View\Components\Blocks;

use Illuminate\View\Component;
use App\Models\Page;

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