<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;

class EmployeeController extends Controller
{
    public function getEmployees(Company $company)
    {
        $this->authorize('isAdmin', User::class);
        $employees = Employee::where('company_id', $company->id)->get();
        return response()->json($employees);
    }


    public function store(StoreEmployeeRequest $request, Company $company)
    {
        $employee = new Employee;
        $employee->name = $request->employee_name;
        $employee->email = $request->employee_email;
        $employee->phone_number = $request->employee_phone;
        $employee->company_id = $company->id;
        $employee->save();
        return redirect(route('admin.companies.edit', compact('company')))->with('status', __('Medewerker toegevoegd'))->with('tab', 'employee');
    }

    public function update(UpdateEmployeeRequest $request, Company $company, Employee $employee)
    {
        $employee->name = $request->employee_name;
        $employee->email = $request->employee_email;
        $employee->phone_number = $request->employee_phone;
        $employee->save();
        return redirect(route('admin.companies.edit', compact('company')))->with('status', __('Medewerker bijgewerkt'))->with('tab', 'employee');
    }

    public function destroy(Company $company, Employee $employee)
    {
        $this->authorize('isAdmin', User::class);
        $employee->delete();
        return redirect(route('admin.companies.edit', compact('company')))->with('status', __('Medewerker verwijderd'))->with('tab', 'employee');
    }
}
