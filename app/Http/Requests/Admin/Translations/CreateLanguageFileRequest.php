<?php

namespace App\Http\Requests\Admin\Translations;

use Illuminate\Foundation\Http\FormRequest;

class CreateLanguageFileRequest extends FormRequest
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
            'localeFile' => 'required|file|mimes:json',
        ];
    }
}
