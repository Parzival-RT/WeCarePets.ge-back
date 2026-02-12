<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'status' => 'nullable|in:pending,active,inactive',
            'group' => 'nullable|in:founders_club,heroes_companies',
            'detail_page_enabled' => 'nullable|boolean',
            'description_ka' => 'nullable|string',
            'description_en' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            // სახელები და კონტაქტი
            'name_ka.required' => 'ქართული დასახელების მითითება აუცილებელია.',
            'contact_person.required' => 'საკონტაქტო პირის მითითება აუცილებელია.',
            'phone.required' => 'ტელეფონის ნომრის მითითება აუცილებელია.',

            // პაკეტი და სტატუსები (Enum/In validation)
            'package.required' => 'გთხოვთ, აირჩიოთ პაკეტი.',
            'package.in' => 'არჩეული პაკეტი არასწორია.',
            'status.in' => 'სტატუსის მნიშვნელობა არასწორია.',
            'group.in' => 'ჯგუფის მნიშვნელობა არასწორია.',

            // ლოგო და ბულიანი
            'logo.image' => 'ლოგო უნდა იყოს სურათის ფორმატში.',
            'logo.max' => 'ლოგოს ზომა არ უნდა აღემატებოდეს 2MB-ს.',
            'detail_page_enabled.boolean' => 'დეტალური გვერდის ველი უნდა იყოს კი ან არა.',

            // ზოგადი სიმბოლოების შეზღუდვა
            'max' => 'სიმბოლოების რაოდენობა არ უნდა აღემატებოდეს :max-ს.',
        ];
    }
}
