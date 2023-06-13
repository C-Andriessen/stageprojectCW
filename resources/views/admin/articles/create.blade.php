@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-admin-menu :page="'artikelen'" />
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">{{ __('Artikel toevoegen') }}</h1>
            <div class="card mb-5">

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.article.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <x-errored-label for="title" :value="__('Titel')" :field="'title'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="title" autofocus value="{{ old('title') ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="introduction" :value="__('Introductie')" :field="'introduction'" />
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="introduction">{{ old('introduction') ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="article" :value="__('Inhoud')" :field="'content'" />
                            <div class="medium-editor">
                                <textarea class="form-control large" id="editor" rows="7" name="content">{{ old('content') ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="image" :value="__('Afbeelding')" :field="'image'" />
                            <input class="form-control" type="file" id="input" name="image">
                        </div>
                        <div class="d-flex mb-2" id="preview">
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <x-errored-label for="start_date" :value="__('Start datum')" :field="'start_date'" />
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') ?? '' }}">
                            </div>
                            <div class="col">
                                <x-errored-label for="end_date" :value="__('Eind datum')" :field="'end_date'" />
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') ?? '' }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.article.index') }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                            <button class="btn btn-success mb-3">Artikel opslaan</button>
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