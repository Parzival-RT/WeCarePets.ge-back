<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'package' => 'required|in:supporter,friend,partner,cofounder',
            'status' => 'required|in:pending,active,inactive',
            'group' => 'nullable|in:founders_club,heroes_companies',
            'detail_page_enabled' => 'required|boolean',
            'description_ka' => 'nullable|string',
            'description_en' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            // დასახელება და კონტაქტი
            'name_ka.required' => 'სახელის ქართულად მითითება აუცილებელია.',
            'contact_person.required' => 'საკონტაქტო პირის ველი სავალდებულოა.',
            'phone.required' => 'ტელეფონის ნომრის მითითება აუცილებელია.',
            'phone.max' => 'ტელეფონის ნომერი არ უნდა აღემატებოდეს 20 სიმბოლოს.',

            // პაკეტი, სტატუსი, ჯგუფი (Enum-ის ტიპის ვალიდაცია)
            'package.required' => 'გთხოვთ, აირჩიოთ პაკეტი.',
            'package.in' => 'არჩეული პაკეტი არასწორია.',
            'status.required' => 'სტატუსის მითითება აუცილებელია.',
            'status.in' => 'არჩეული სტატუსი არავალიდურია.',
            'group.in' => 'არჩეული ჯგუფი არავალიდურია.',

            // დეტალური გვერდი (Boolean)
            'detail_page_enabled.required' => 'გთხოვთ, მიუთითოთ ჩართულია თუ არა დეტალური გვერდი.',
            'detail_page_enabled.boolean' => 'მნიშვნელობა უნდა იყოს "კი" ან "არა".',

            // ლოგო
            'logo.image' => 'ატვირთული ფაილი უნდა იყოს სურათი.',
            'logo.max' => 'სურათის ზომა არ უნდა აღემატებოდეს 2 MB-ს.',

            // ზოგადი ტექსტური ველები
            'string' => 'ველი უნდა იყოს ტექსტური ფორმატის.',
            'max' => 'სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს :max-ს.',
        ];
    }
}
