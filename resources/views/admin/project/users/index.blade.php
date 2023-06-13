@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-admin-menu :page="'projecten'" />

        </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between mb-4 flex-column flex-md-row">
                <div>
                    <h1><a href="{{route('admin.projects.index')}}" class="text-decoration-none text-dark">Gebruikers</a></h1>
                </div>

                <form action="{{ route('admin.projects.users.search', $project) }}">
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" placeholder="Zoek gebruiker" aria-describedby="button-addon2" name="search" value="{{ request()->search ?? '' }}">
                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>

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
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Gebruiker</th>
                                <th>Rol</th>
                                <th>Bewerk</th>
                                <th>Verwijder</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projectUsers as $projectUser)
                            <tr>
                                <td>{{$projectUser->user->name}}</td>
                                <td>{{$projectUser->role->name}}</td>
                                <td>
                                    <a href="{{ route('admin.projects.users.edit', $projectUser) }}" class="btn btn-link text-dark text-decoration-none">Bewerk</a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.projects.users.destroy', $projectUser) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Weet je zeker dat je &#8220;{{ $projectUser->user->name }}&#8221; wilt verwijderen van het project?')" class="btn btn-link text-dark text-decoration-none">Verwijder</button>
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
@endsection