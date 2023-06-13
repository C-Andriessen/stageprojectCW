@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-user-menu :page="'projecten'" />
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">{{ __('Taak bekijken') }}</h1>
            <div class="card mb-5">

                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif
                    <div class="mb-3">
                        <h4>Titel</h4>
                        <p>{{ $task->title }}</p>
                    </div>
                    <div class="mb-3">
                        <h4>Omschrijving</h4>
                        {!! $task->description !!}
                    </div>
                    <div class="mb-5">
                        <div class="row mb-3 mt-5">
                            <div class="col">
                                <h4>Start datum</h4>
                                <p>{{ date('d-m-Y' , strtotime($task->start_date)) }}</p>
                            </div>
                            <div class="col">
                                <h4>Deadline</h4>
                                <p>{{ date('d-m-Y' , strtotime($task->end_date)) }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('user.tasks.open') }}" class=" btn btn-link text-dark text-decoration-none">Terug</a>
                            @if(!$task->completed)
                            <form method="post" action="{{ route('user.tasks.approve', $task) }}">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-success mb-3">Afronden</button>
                            </form>
                            @else
                            <form method="post" action="{{ route('user.tasks.unapprove', $task) }}">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-success mb-3">Niet afgerond</button>
                            </form>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/js/editor.js') }}" defer></script>
@endsection