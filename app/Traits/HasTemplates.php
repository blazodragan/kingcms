<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait HasTemplates 
{
    public function getTemplateNames() {
        if (!property_exists($this, 'templatePath')) {
            throw new \Exception('You must define a templatePath property in your model using the HasTemplates trait.');
        }

        $path = resource_path('views/' . $this->templatePath);

        $files = File::glob($path . '/*.blade.php');

        $templates = array_map(function($file) {
            return basename($file, '.blade.php');
        }, $files);

        return $templates;
    }

}
