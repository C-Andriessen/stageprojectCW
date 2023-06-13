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
                    <h1><a href="{{route('admin.projects.tasks.open', $project)}}" class="text-decoration-none text-dark">Taken</a></h1>
                </div>

                <form action="{{ route('admin.projects.tasks.open.search', $project) }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Zoek taak" aria-describedby="button-addon2" name="search" value="{{ request()->search }}">
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
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.projects.tasks.open', $project) }}">Open</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" aria-current="page" href="{{ route('admin.projects.tasks.completed', $project) }}">Afgerond</a>
                        </li>
                    </ul>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Taak</th>
                                <th>Start datum</th>
                                <th>Deadline</th>
                                <th>Bewerk</th>
                                <th>Verwijder</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                            <tr>
                                <td>{{$task->title}}</td>
                                <td>{{ date('d-m-Y' , strtotime($task->start_date)) }}</td>
                                <td>{{ date('d-m-Y' , strtotime($task->end_date)) }}</td>
                                <td>
                                    <a href="{{ route('admin.projects.tasks.edit', [$project, $task]) }}" class="btn btn-link text-dark text-decoration-none">Bewerk</a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.projects.tasks.destroy', [$project, $task]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Weet je zeker dat je &#8220;{{ $task->title }}&#8221; wilt verwijderen van het project?')" class="btn btn-link text-dark text-decoration-none">Verwijder</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection