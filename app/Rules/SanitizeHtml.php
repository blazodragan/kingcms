<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use HTMLPurifier;
use HTMLPurifier_Config;

class SanitizeHtml implements Rule
{
    protected $allowed_tags = '<a><p><div><span><img><h1><h2><h3><h4><h5><h6><br><ul><ol><li><table><tr><td>';

    public function passes($attribute, $value)
    {
         // If the value is empty or null, skip validation
    if (empty($value)) {
        return true;
    }

        // Define allowed tags and attributes
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'a,p,div,span,h1,h2,h3,h4,h5,h6,br,ul,ol,li,table,tr,td,img');
        $config->set('HTML.AllowedAttributes', 'img.src,img.alt,img.width,img.height,div.class');
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        
        $purifier = new HTMLPurifier($config);
        $clean = $purifier->purify($value);

        return $clean === $value;
    }

    public function message()
    {
        return 'The :attribute contains prohibited HTML tags. allowed tags are a,p,div,span,h1,h2,h3,h4,h5,h6,br,ul,ol,li,table,tr,td,img';
    }
}