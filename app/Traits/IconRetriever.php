<?php
// app/Traits/IconRetriever.php
namespace App\Traits;

use Illuminate\Support\Facades\File;

trait IconRetriever
{
    public function getAllIconNames()
    {
        $icons = File::files(public_path('images/icons'));
        $iconNames = [];
        foreach ($icons as $icon) {
            $iconNames[] = asset('images/icons/' . $icon->getFilename());
            
        }
        return $iconNames;
    }
}