<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Employee;

class CompanyController extends Controller
{
    public function index()
    {
        $this->authorize('isAdmin', User::class);
        $companies = Company::orderBy('created_at', 'DESC')->paginate(15);
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.companies.create');
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = new Company;
        $company->name = $request->name;
        $company->email = $request->email;
        $company->address = $request->address;
        $company->zip_code = $request->zip_code;
        $company->city = $request->city;
        $company->phone_number = $request->phone_number;
        $company->save();
        return redirect(route('admin.companies.index'))->with('status', __('Bedrijf is toegevoegd'));
    }

    public function edit(Company $company)
    {
        $this->authorize('isAdmin', User::class);
        $employees = Employee::where('company_id', $company->id)->orderBy('name')->paginate(15);
        return view('admin.companies.edit', compact('company', 'employees'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->name = $request->name;
        $company->email = $request->email;
        $company->address = $request->address;
        $company->zip_code = $request->zip_code;
        $company->city = $request->city;
        $company->phone_number = $request->phone_number;
        $company->save();
        return redirect(route('admin.companies.index'))->with('status', __('Bedrijf is bijgewerkt'));
    }

    public function destroy(Company $company)
    {
        $this->authorize('isAdmin', User::class);
        $company->delete();
        return redirect(route('admin.companies.index'))->with('status', __('Bedrijf is verwijderd'));
    }
}
