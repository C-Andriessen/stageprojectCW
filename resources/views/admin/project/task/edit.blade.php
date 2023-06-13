@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-admin-menu :page="'projecten'" />
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <h1 class="mb-4">{{ __('Taak bewerken') }}</h1>
                <x-project-option-dropdown :project="$project" />
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link text-dark" aria-current="page" href="{{ route('admin.projects.edit.info', $project ) }}">Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('admin.projects.users.index', $project) }}">Gebruikers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-dark" aria-current="page" href="{{ route('admin.projects.tasks.open', $project) }}">Taken</a>
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
                    <form method="POST" action="{{ route('admin.projects.tasks.update',  [$project, $task]) }}">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <x-errored-label for="title" :value="__('Titel')" :field="'title'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="title" autofocus value="{{ old('title') ?? $task->title }}">
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="description" :value="__('Omschrijving')" :field="'description'" />
                            <div class="medium-editor">
                                <textarea class="form-control large" id="editor" rows="7" name="description">{{ old('description') ?? $task->description }}</textarea>
                            </div>
                        </div>
                        <x-errored-label for="user" :value="__('Gebruiker')" :field="'user'" />
                        <select class="select2 form-select" name="user">
                            <option {{ old('user') ? '' : 'selected' }} value="{{ NULL }}">Selecteer een gebruiker</option>
                            @foreach($users as $user)
                            <option {{ $task->user->id  == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <div class="row mb-3 mt-3">
                            <div class="col">
                                <x-errored-label for="start_date" :value="__('Start datum')" :field="'start_date'" />
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') ?? $task->start_date }}">
                            </div>
                            <div class="col">
                                <x-errored-label for="end_date" :value="__('Deadline')" :field="'end_date'" />
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') ?? $task->end_date }}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.projects.tasks.open', $task->project) }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                            <button class="btn btn-success mb-3">Opslaan</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{ asset('/js/editor.js') }}" defer></script>
<script src="{{asset('/js/select2.js') }}"></script>
@endsection