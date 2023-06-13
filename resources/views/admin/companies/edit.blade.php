@extends('layouts.app')

@section('content')
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="true" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Gebruiker toevoegen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.companies.employees.store', $company) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <x-errored-label for="employee_name" :value="__('Naam')" :field="'employee_name'" />
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="employee_name" autofocus value="{{ old('employee_name') }}">
                    </div>
                    <div class="mb-3">
                        <x-errored-label for="employee_phone" :value="__('Telefoonnummer')" :field="'employee_phone'" />
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="employee_phone" autofocus value="{{ old('employee_phone') }}">
                    </div>
                    <div class="mb-3">
                        <x-errored-label for="email" :value="__('E-mail')" :field="'employee_email'" />
                        <input type="email" class="form-control" id="exampleFormControlInput1" name="employee_email" value="{{ old('employee_email')}}">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-link text-dark text-decoration-none" data-bs-dismiss="modal">Annuleren</button>
                        <button type="submit" class="btn btn-success">Toevoegen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-admin-menu :page="'bedrijven'" />
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <h1 class="mb-4">{{ __('Bedrijf bewerken') }}</h1>
                <x-company-option />
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @if(session('tab') === 'employee')
                    <button class="nav-link text-dark" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="false">Informatie</button>
                    <button class="nav-link active text-dark" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-employee" type="button" role="tab" aria-controls="nav-employee" aria-selected="true">Personeel</button>
                    @else
                    <button class="nav-link active text-dark" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="true">Informatie</button>
                    <button class="nav-link text-dark" id="nav-info-tab" data-bs-toggle="tab" data-bs-target="#nav-employee" type="button" role="tab" aria-controls="nav-employee" aria-selected="false">Personeel</button>
                    @endif
                </div>
            </nav>
            <div class="card mb-5">
                <div class="tab-content" id="nav-tabContent">
                    @if(session('tab') == 'employee')
                    <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab" tabindex="0">
                        @else
                        <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-tab" tabindex="0">
                            @endif

                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.companies.update', $company) }}">
                                    @csrf
                                    @method('put')
                                    <div class="mb-3">
                                        <x-errored-label for="name" :value="__('Naam')" :field="'name'" />
                                        <input type="text" class="form-control" id="exampleFormControlInput1" name="name" autofocus value="{{ old('name', $company->name) }}">
                                    </div>
                                    <div class="mb-3">
                                        <x-errored-label for="email" :value="__('E-mail')" :field="'email'" />
                                        <input type="email" class="form-control" id="exampleFormControlInput1" name="email" value="{{ old('email', $company->email) }}">
                                    </div>
                                    <div class="mb-3">
                                        <x-errored-label for="address" :value="__('Adres')" :field="'address'" />
                                        <input type="text" class="form-control" id="exampleFormControlInput1" name="address" value="{{ old('address', $company->address )}}">
                                    </div>
                                    <div class="mb-3">
                                        <x-errored-label for="city" :value="__('Stad')" :field="'city'" />
                                        <input type="text" class="form-control" id="exampleFormControlInput1" name="city" value="{{ old('city', $company->city) }}">
                                    </div>
                                    <div class="mb-3">
                                        <x-errored-label for="zip_code" :value="__('Postcode')" :field="'zip_code'" />
                                        <input type="text" class="form-control" id="exampleFormControlInput1" name="zip_code" value="{{ old('zip_code', $company->zip_code) }}">
                                    </div>
                                    <div class="mb-3">
                                        <x-errored-label for="phone_number" :value="__('Telefoon nummer')" :field="'phone_number'" />
                                        <input type="text" class="form-control" id="exampleFormControlInput1" name="phone_number" value="{{ old('phone_number', $company->phone_number) }}">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.companies.index') }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                                        <button class="btn btn-success mb-3">Bijwerken</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if(session('tab') == 'employee')
                        <div class="tab-pane fade show active" id="nav-employee" role="tabpanel" aria-labelledby="nav-employee-tab" tabindex="0">
                            @else
                            <div class="tab-pane fade" id="nav-employee" role="tabpanel" aria-labelledby="nav-employee-tab" tabindex="0">
                                @endif

                                @if(session('status'))
                                <x-alert />
                                @endif

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Naam</th>
                                            <th>Email</th>
                                            <th>Telefoonnummer</th>
                                            <th>Bewerk</th>
                                            <th>Verwijder</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $employee)
                                        <div class="modal fade" id="edit{{ $employee->id }}" data-bs-backdrop="true" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h2 class="modal-title fs-5" id="staticBackdropLabel">Gebruiker bewerken</h2>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('admin.companies.employees.update', [$company, $employee]) }}" method="POST">
                                                            @csrf
                                                            @method('put')
                                                            <div class="mb-3">
                                                                <x-errored-label for="employee_name" :value="__('Naam')" :field="'employee_name'" />
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" name="employee_name" autofocus value="{{ old('employee_name') ?? $employee->name }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <x-errored-label for="employee_phone" :value="__('Telefoonnummer')" :field="'employee_phone'" />
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" name="employee_phone" autofocus value="{{ old('employee_phone') ?? $employee->phone_number }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <x-errored-label for="email" :value="__('E-mail')" :field="'employee_email'" />
                                                                <input type="email" class="form-control" id="exampleFormControlInput1" name="employee_email" value="{{ old('employee_email') ?? $employee->email}}">
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="button" class="btn btn-link text-dark text-decoration-none" data-bs-dismiss="modal">Annuleren</button>
                                                                <button type="submit" class="btn btn-success">Bewerken</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <tr>
                                            <td>{{$employee->name}}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>{{ $employee->phone_number }}</td>
                                            <td>
                                                <button type="button" class="btn btn-link text-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#edit{{ $employee->id }}">
                                                    Bewerk
                                                </button>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.companies.employees.destroy', [$company, $employee]) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" onclick="return confirm('Weet je zeker dat je &#8220;{{ $employee->name }}&#8221; wilt verwijderen?')" class="btn btn-link text-dark text-decoration-none">Verwijder</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/editor.js') }}" defer></script>
    @endsection