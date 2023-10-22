<?php
namespace App\Http\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StorePagesRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return Gate::allows("sanctum.news.create");
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            'title' => ['required'],
            'slug' => ['required'],
            'perex' => ['required'],
            'content' => ['required'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'meta_url_canolical' => ['nullable'],
            'template' => ['nullable'],
            'is_index' => ['required','boolean'],
            'no_index' => ['required','boolean'],
            'no_follow' => ['required','boolean'],
            'og_title' => ['nullable'],
            'og_description' => ['nullable'],
            'og_type' => ['nullable'],
            'og_url' => ['nullable'],
            'status' => ['nullable'],
            'user_id' => ['required','exists:users,id'],
            'published_at' => ['nullable'],
            'faqs.*.question' => ['nullable'],
            'faqs.*.answer' => ['nullable'],
            'tips.*.title' => ['nullable'],
            'tips.*.body' => ['nullable'],
            'tips.*.icon' => ['nullable'],
            'tips.*.type' => ['nullable'],
        ];
    }
}
