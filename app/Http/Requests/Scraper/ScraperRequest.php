<?php

namespace App\Http\Requests\Scraper;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ScraperRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $catKey = 'category';
        $subCatkey = 'sub_category';

        return [
            // "$catKey.container" => ['sometimes', 'array'],

            // "$catKey.pattern" => ["required_with:$catKey.container", 'string'],
            // "$catKey.type" => ["required_with:$catKey.type", 'string'],
            // "$catKey.should_match" => ["sometimes", "boolean"],

            // "$catKey.items" => ['required', 'array'],
            // "$catKey.items.pattern" => ['required', 'string'],
            // "$catKey.items.type" => ['required', 'string']
        ];
    }
}
