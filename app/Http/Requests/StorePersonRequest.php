<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
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
            'image' => 'required|image|max:2048',
            'status' => 'nullable|in:active,inactive',
        ];
    }
    public function messages(): array
    {
        return [
            // სახელი
            'name_ka.required' => 'სახელის ქართულად მითითება აუცილებელია.',
            'name_ka.string' => 'სახელი უნდა იყოს ტექსტური ფორმატის.',
            'name_ka.max' => 'სახელი არ უნდა აღემატებოდეს 255 სიმბოლოს.',

            // გვარი
            'surname_ka.required' => 'გვარის ქართულად მითითება აუცილებელია.',
            'surname_ka.string' => 'გვარი უნდა იყოს ტექსტური ფორმატის.',
            'surname_ka.max' => 'გვარი არ უნდა აღემატებოდეს 255 სიმბოლოს.',

            // ფოტო
            'image.required' => 'ფოტოს ატვირთვა აუცილებელია.',
            'image.image' => 'ატვირთული ფაილი უნდა იყოს სურათი.',
            'image.max' => 'სურათის ზომა არ უნდა აღემატებოდეს 2MB-ს.',

            // სტატუსი
            'status.in' => 'არჩეული სტატუსი არასწორია.',
        ];
    }
}
