<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoryRequest extends FormRequest
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
            'cover_image' => 'required|image|max:2048',
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
            'name_ka.required' => 'სახელის ქართულად შევსება აუცილებელია.',
            'cover_image.required' => 'გარეკანის ფოტოს ატვირთვა აუცილებელია.',
            'cover_image.image' => 'ფაილი უნდა იყოს სურათის ფორმატში.',
            'cover_image.max' => 'სურათის ზომა არ უნდა აღემატებოდეს 2MB-ს.',
            'video_url.required' => 'ვიდეოს ლინკის მითითება აუცილებელია.',
            'video_url.url' => 'ვიდეოს მისამართი არასწორია.',
            'company_ids.*.exists' => 'არჩეული კომპანია ვერ მოიძებნა.',
            'person_ids.*.exists' => 'არჩეული პირი ვერ მოიძებნა.',
        ];
    }
}
