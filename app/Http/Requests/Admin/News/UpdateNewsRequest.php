<?php

namespace App\Http\Requests\Admin\News;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:2|max:255',
            'text' => 'required',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'meta_title' => 'nullable|min:2',
            'meta_description' => 'nullable|min:2',
            'meta_keywords' => 'nullable|min:2',
            'status' => 'required|in:active,inactive',
        ];
    }
}
