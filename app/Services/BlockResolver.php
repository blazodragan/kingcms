<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Block;

class BlockResolver
{
    public function resolve($blockName, $parameters = [])
    {

        $block = Block::where('name', $blockName)->first();
        
        if (!$block) {
            return ''; // handle block not found
        }

        // If it's an HTML block, return its content directly
        if ($block->type === 'html') {
            return $block->content;
        }

        // Otherwise, assume it's a Blade component and try to resolve
        $className = Str::studly($blockName);
        
        $fullyQualifiedClassName = "\App\View\Components\Blocks\\{$className}";
        
        if (class_exists($fullyQualifiedClassName)) {
            
            // Instantiate the component and call its render method
            $componentInstance = app($fullyQualifiedClassName, $parameters);
            
            return $componentInstance->render();
        }

        return '';  // Return empty string if block doesn't exist
    }
}