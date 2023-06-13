@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-admin-menu :page="'projecten'" />
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <h1 class="mb-4">{{ __('Gebruiker toevoegen') }}</h1>
                <x-project-option-dropdown :project="$project" />
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link text-dark" aria-current="page" href="{{ route('admin.projects.edit.info', $project ) }}">Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-dark" href="{{ route('admin.projects.users.index', $project) }}">Gebruikers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" aria-current="page" href="{{ route('admin.projects.tasks.open', $project) }}">Taken</a>
                </li>
                @if($project->company_id)
                <li class="nav-item">
                    <a class="nav-link text-dark" aria-current="page" href="{{route('admin.projects.company.index', $project)}}">Bedrijfsgegevens</a>
                </li>
                @endif
            </ul>
            <div class="card mb-5">

                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif
                    <form method="POST" action="{{ route('admin.projects.users.store', $project) }}" enctype="multipart/form-data">
                        @csrf
                        <x-errored-label for="user" :value="__('Gebruikers')" :field="'user'" />
                        <select class="form-select mb-3" name="user">
                            <option {{ old('user') ? '' : 'selected' }} value="{{ NULL }}">Selecteer een gebruiker</option>
                            @foreach($users as $user)
                            <option {{ old('user') == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <x-errored-label for="role" :value="__('Rol')" :field="'role'" />
                        <select class="form-select mb-3" name="role">
                            <option {{ old('role') ? '' : 'selected' }} value="{{ NULL }}">Selecteer een rol</option>
                            @foreach($roles as $role)
                            <option {{ old('role') == $role->id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.projects.users.index', $project) }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                            <button class="btn btn-success mb-3">Gebruiker toevoegen</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{ asset('/js/editor.js') }}" defer></script>
@endsection