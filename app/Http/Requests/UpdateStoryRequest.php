<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_ka' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
            'video_url' => 'required|url',
            'description_ka' => 'nullable|string',
            'description_en' => 'nullable|string',
            'company_ids' => 'nullable|array',
            'company_ids.*' => 'exists:companies,id',
            'person_ids' => 'nullable|array',
            'person_ids.*' => 'exists:people,id',
            'category' => 'required|in:helped,healed',
            'amount_spent' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ];
    }
    public function messages(): array
    {
        return [
            'video_url.required' => 'ვიდეოს ბმულის მითითება აუცილებელია.',
            'video_url.url' => 'გთხოვთ, მიუთითოთ ვალიდური URL მისამართი.',

            // დამატებითი ველები სრული სურათისთვის
            'name_ka.required' => 'ქართული დასახელების შევსება სავალდებულოა.',
            'cover_image.image' => 'ატვირთული ფაილი უნდა იყოს სურათი.',
            'cover_image.max' => 'სურათის ზომა არ უნდა აღემატებოდეს 2MB-ს.',
            'company_ids.*.exists' => 'არჩეული კომპანია ბაზაში არ არსებობს.',
        ];
    }
}
