@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-user-menu :page="'taken'" />

        </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <div>
                    <h1><a href="{{route('user.tasks.open')}}" class="text-decoration-none text-dark">Taken</a></h1>
                </div>

                <form action="{{ route('user.tasks.completed.search') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Zoek taak" aria-describedby="button-addon2" name="search" value="{{ request()->search ?? '' }}">
                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('user.tasks.open') }}">Open</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('user.tasks.completed') }}">Afgerond</a>
                </li>
            </ul>
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Taak</th>
                                <th>Project</th>
                                <th>Deadline</th>
                                <th>Niet klaar?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                            <tr>
                                <td><a href="{{ route('user.tasks.show', $task) }}">{{$task->title}}</a></td>
                                <td>{{ $task->project->title }}</td>
                                <td>{{ date('d-m-Y' , strtotime($task->end_date)) }}</td>
                                <td>
                                    <form action="{{ route('user.tasks.unapprove', $task) }}" method="post">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="btn btn-link text-dark text-decoration-none p-0">Open zetten</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                        {{ $tasks->links() }}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection