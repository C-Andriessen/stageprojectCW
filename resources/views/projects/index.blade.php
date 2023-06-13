@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-5">Projecten</h1>
    <div class="row">
        @foreach($projects as $project)
        <div class="col-12">
            <div class="card mb-3 card-project">
                <div class="row g-0">
                    <div class="col-md-3">
                        <img src="/images/projects/{{ $project->image ?? 'template.jpeg' }}" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body ms-4">
                            <h5 class="card-title">{{ $project->title }}</h5>
                            <p class="card-text">{{ $project->introduction }}</p>
                            <p class="card-text"><small class="text-muted">Start datum: {{ date('d-m-Y' , strtotime($project->start_date)) }}</small></p>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-primary stretched-link">Bekijk project</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{$projects->links()}}
    </div>
</div>


@endsection