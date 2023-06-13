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
                    <h1><a href="{{route('admin.projects.index')}}" class="text-decoration-none text-dark">Projecten</a></h1>
                </div>

                <form action="{{ route('admin.projects.search') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Zoek project" aria-describedby="button-addon2" name="search" value="{{ request()->search ?? '' }}">
                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>

                <div>
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-success">Nieuw project</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Titel</th>
                                <th>introduction</th>
                                <th>Start datum</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr>
                                <td>{{$project->title}}</td>
                                <td>{{ Str::limit($project->introduction, 30) }}</td>
                                <td>{{ date('d-m-Y' , strtotime($project->start_date)) }}</td>
                                <td>
                                    <a href="{{ route('admin.projects.edit.info', $project) }}" class="btn btn-link text-dark text-decoration-none p-0">Bewerk</a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Weet je zeker dat je &#8220;{{ $project->title }}&#8221; wilt verwijderen?')" class="btn btn-link text-dark text-decoration-none p-0">Verwijder</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection