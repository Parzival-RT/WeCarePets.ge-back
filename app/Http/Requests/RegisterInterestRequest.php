<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterInterestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'package' => 'required|in:supporter,friend,partner,cofounder',
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'კომპანიის სახელი სავალდებულოა.',
            'company_name.string'   => 'კომპანიის სახელი უნდა იყოს ტექსტი.',
            'company_name.max'      => 'კომპანიის სახელი არ უნდა აღემატებოდეს 255 სიმბოლოს.',

            'contact_person.required' => 'საკონტაქტო პირის სახელი სავალდებულოა.',
            'contact_person.string'   => 'საკონტაქტო პირის სახელი უნდა იყოს ტექსტი.',
            'contact_person.max'      => 'საკონტაქტო პირის სახელი არ უნდა აღემატებოდეს 255 სიმბოლოს.',

            'phone.required' => 'ტელეფონის ნომერი სავალდებულოა.',
            'phone.string'   => 'ტელეფონის ნომერი უნდა იყოს ტექსტი.',
            'phone.max'      => 'ტელეფონის ნომერი არ უნდა აღემატებოდეს 20 სიმბოლოს.',

            'package.required' => 'პაკეტის არჩევა სავალდებულოა.',
            'package.in'       => 'არჩეული პაკეტი არასწორია. დასაშვები მნიშვნელობებია: supporter, friend, partner, cofounder.',
        ];
    }
}
