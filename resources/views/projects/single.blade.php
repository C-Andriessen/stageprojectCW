@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-9">
            <a href="/" class="text-dark text-decoration-none single-back"><i class="fa-sharp fa-solid fa-arrow-left"></i> Terug</a>
            <img src="/images/projects/{{ $project->image ?? 'template.jpg' }}" class="img-fluid img-single mb-2 mt-3" alt="...">
            <div class="d-flex justify-content-between flex-column flex-md-row mb-5">
                <p>Gepubliceerd op: {{ date('d-m-Y' , strtotime($project->start_date)) }}</p>
            </div>
            <h2 class="mb-3">{{ $project->title }}</h2>
            <p class="fw-bold mb-3">{{ $project->introduction }}</p>
            {!! $project->description !!}

        </div>
        <div class="col-3">
            <nav class="nav flex-column">
                <h3 class="px-3 mb-3">Nieuwste artikelen</h3>
                @foreach($projectLinks as $projectLink)
                <a class="nav-link" href="{{ route('projects.show', $projectLink) }}">{{$projectLink->title}}</a>
                @endforeach
            </nav>
        </div>
    </div>
</div>
@endsection