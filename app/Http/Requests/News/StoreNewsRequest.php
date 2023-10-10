<?php
namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreNewsRequest extends FormRequest
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
            'reference_link' => ['nullable','string'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'meta_url_canolical' => ['nullable'],
            'href_lang' => ['nullable'],
            'no_index' => ['required','boolean'],
            'no_follow' => ['required','boolean'],
            'og_title' => ['nullable'],
            'og_description' => ['nullable'],
            'og_type' => ['nullable'],
            'og_url' => ['nullable'],
            'status' => ['nullable'],
            'user_id' => ['required','exists:users,id'],
            'published_at' => ['nullable'],
            'categories_ids' => ['nullable','array'],
        ];
    }
}
