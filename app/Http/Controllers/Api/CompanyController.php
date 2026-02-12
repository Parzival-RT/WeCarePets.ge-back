<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyDetailResource;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanyController extends Controller
{
    /**
     * GET /api/companies/founders - Founders Club (max 30)
     */
    public function founders(): AnonymousResourceCollection
    {
        $companies = Company::active()->foundersClub()->limit(30)->get();
        return CompanyResource::collection($companies);
    }

    /**
     * GET /api/companies/heroes - Heroes Companies (paginated)
     */
    public function heroes(Request $request): AnonymousResourceCollection
    {
        $companies = Company::active()->heroesCompanies()->paginate(10);
        return CompanyResource::collection($companies);
    }

    /**
     * GET /api/companies/{id} - კომპანიის დეტალი (თუ detail_page_enabled)
     */
    public function show(Company $company): CompanyDetailResource
    {
        if (!$company->detail_page_enabled) {
            abort(404);
        }
        $company->load('stories');
        return new CompanyDetailResource($company);
    }
}
