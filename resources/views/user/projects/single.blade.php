@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-user-menu :page="'projecten'" />
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">{{ __('Project bekijken') }}</h1>
            <div class="card mb-5">

                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif
                    <div class="mb-3">
                        <h4>Titel</h4>
                        <p>{{ $project->title }}</p>
                    </div>
                    <div class="mb-3">
                        <h4>Introductie</h4>
                        <p>{{ $project->introduction }}</p>
                    </div>
                    <div class="mb-3">
                        <h4>Beschrijving</h4>
                        {!! $project->description !!}
                    </div>
                    <div class="mb-5">
                        @if($project->image)
                        <h4>Image</h4>
                        <img src="/images/projects/{{ $project->image }}" alt="" class="img-show-single">
                        @endif
                        <div class="row mb-3 mt-5">
                            <div class="col">
                                <h4>Start datum</h4>
                                <p>{{ date('d-m-Y' , strtotime($project->start_date)) }}</p>
                            </div>
                            <div class="col">
                                <h4>Eind datum</h4>
                                <p>{{ date('d-m-Y' , strtotime($project->end_date)) }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('user.projects.index') }}" class=" btn btn-link text-dark text-decoration-none">Terug</a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/js/editor.js') }}" defer></script>
@endsection