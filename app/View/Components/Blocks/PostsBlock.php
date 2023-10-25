<?php
namespace App\View\Components\Blocks;

use Illuminate\View\Component;
use App\Models\Post;

class PostsBlock extends Component
{
    public $pageItems;

    public function __construct($count = 5, $term = null, $order = 'desc', $orderby = 'created_at')
    {
        // Query the news model
        $query = Post::query();

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
        return view('components.post-block', ['pageItems' => $this->pageItems]);
    }
}