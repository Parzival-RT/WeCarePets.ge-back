<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
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
            'surname_ka' => 'required|string|max:255',
            'surname_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ];
    }
    public function messages(): array
    {
        return [
            // სახელი
            'name_ka.required' => 'სახელის ქართულად შევსება აუცილებელია.',
            'name_ka.max' => 'სახელი არ უნდა აღემატებოდეს 255 სიმბოლოს.',

            // გვარი
            'surname_ka.required' => 'გვარის ქართულად შევსება აუცილებელია.',
            'surname_ka.max' => 'გვარი არ უნდა აღემატებოდეს 255 სიმბოლოს.',

            // სურათი (nullable-ია, ამიტომ მხოლოდ ფორმატსა და ზომას ვამოწმებთ)
            'image.image' => 'ატვირთული ფაილი უნდა იყოს სურათი.',
            'image.max' => 'სურათის ზომა არ უნდა აღემატებოდეს 2MB-ს.',

            // სტატუსი
            'status.required' => 'სტატუსის მითითება აუცილებელია.',
            'status.in' => 'არჩეული სტატუსი არასწორია (ნებადართულია: active, inactive).',
        ];
    }
}
