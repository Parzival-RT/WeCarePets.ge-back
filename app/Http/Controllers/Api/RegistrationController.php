<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterInterestRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    /**
     * POST /api/register-interest - რეგისტრაციის ფორმა
     */
    public function store(RegisterInterestRequest $request): JsonResponse
    {

        $data = [
            'name' => ['ka' => $request->company_name, 'en' => $request->company_name],
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'package' => $request->package,
            'status' => 'pending',
            'group' => null,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }

        Company::create($data);

        return response()->json([
            'success' => true,
            'message' => 'განაცხადი მიღებულია'
        ], 201);
    }
}
