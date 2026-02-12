<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanyController extends Controller
{
    /**
     * GET - ყველა კომპანია (filters: status, group)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Company::with('stories');

        $query->when($request->name, function ($q) use ($request) {
            $q->where('name->ka', 'like', '%' . $request->name . '%')
                ->orWhere('name->en', 'like', '%' . $request->name . '%');
        });
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->group) {
            $query->where('group', $request->group);
        }

        return CompanyResource::collection($query->latest()->paginate(15));
    }

    /**
     * GET - ერთი კომპანია
     */
    public function show(Company $company): CompanyResource
    {
        return new CompanyResource($company);
    }

    /**
     * POST - ახალი კომპანიის დამატება
     */
    public function store(StoreCompanyRequest $request): CompanyResource
    {
        $data = [
            'name' => [
                'ka' => $request->name_ka,
                'en' => $request->name_en ?? $request->name_ka,
            ],
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'package' => $request->package,
            'status' => $request->status ?? 'pending',
            'group' => $request->group,
            'detail_page_enabled' => $request->detail_page_enabled ?? false,
            'description' => [
                'ka' => $request->description_ka,
                'en' => $request->description_en,
            ],
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }

        $company = Company::create($data);

        return new CompanyResource($company);
    }

    /**
     * PUT - კომპანიის განახლება
     */
    public function update(UpdateCompanyRequest $request, Company $company): CompanyResource
    {
        $data = [
            'name' => [
                'ka' => $request->name_ka,
                'en' => $request->name_en ?? $request->name_ka,
            ],
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'package' => $request->package,
            'status' => $request->status,
            'group' => $request->group,
            'detail_page_enabled' => $request->detail_page_enabled,
            'description' => [
                'ka' => $request->description_ka,
                'en' => $request->description_en,
            ],
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }

        $company->update($data);
        return new CompanyResource($company);
    }

    /**
     * DELETE - კომპანიის წაშლა
     */
    public function destroy(Company $company): JsonResponse
    {
        $company->stories()->detach();
        $company->delete();
        return response()->json(null, 204);
    }

    /**
     * PATCH - სტატუსის შეცვლა
     */
    public function updateStatus(Request $request, Company $company): CompanyResource
    {
        $request->validate(['status' => 'required|in:pending,active,inactive']);
        $company->update(['status' => $request->status]);
        return new CompanyResource($company);
    }

    /**
     * PATCH - ჯგუფის შეცვლა
     */
    public function updateGroup(Request $request, Company $company): CompanyResource
    {
        $request->validate(['group' => 'nullable|in:founders_club,heroes_companies']);
        $company->update(['group' => $request->group]);
        return new CompanyResource($company);
    }

    /**
     * PATCH - დეტალური გვერდის toggle
     */
    public function toggleDetailPage(Company $company): CompanyResource
    {
        $company->update(['detail_page_enabled' => !$company->detail_page_enabled]);
        return new CompanyResource($company);
    }
}
