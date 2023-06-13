@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-admin-menu :page="'projecten'" />

        </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <div>
                    <h1><a href="{{route('admin.projects.company.index', $project)}}" class="text-decoration-none text-dark">Bedrijfsgegevens</a></h1>
                </div>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link text-dark" aria-current="page" href="{{ route('admin.projects.edit.info', $project ) }}">Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('admin.projects.users.index', $project) }}">Gebruikers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" aria-current="page" href="{{ route('admin.projects.tasks.open', $project) }}">Taken</a>
                </li>
                @if($project->company_id)
                <li class="nav-item">
                    <a class="nav-link active text-dark" aria-current="page" href="{{route('admin.projects.company.index', $project)}}">Bedrijfsgegevens</a>
                </li>
                @endif
            </ul>
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Bedrijfs details:</h5>
                            <p class="mb-0"><b>Naam:</b> {{ $project->company->name }}</p>
                            <p class="mb-0"><b>E-mail:</b> {{ $project->company->email }}</p>
                            <p class="mb-0"><b>Telefoonnummer:</b> {{ $project->company->phone_number }}</p>
                            <p class="mb-0"><b>Adres:</b> {{ $project->company->address }}</p>
                            <p><b>Postcode:</b> {{ $project->company->zip_code }}</p>
                        </div>
                        @if ($project->employee)
                        <div class="col-md-6">
                            <h5>Standaard contactpersoon:</h5>
                            <p class="mb-0"><b>Naam:</b> {{ $project->employee->name }}</p>
                            <p class="mb-0"><b>E-mail:</b> {{ $project->employee->email }}</p>
                            <p><b>Telefoonnummer:</b> {{ $project->employee->phone_number }}</p>
                        </div>
                        @endif
                    </div>
                    <h2>Medewerkers:</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Email</th>
                                <th>Telefoonnummer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->company->employees as $employee)
                            <tr>
                                <td>{{$employee->name}}</td>
                                <td class="">{{ $employee->email }}</td>
                                <td>{{ $employee->phone_number }}</td>
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
@endsection

<script src="{{ asset('/js/test.js') }}"></script>