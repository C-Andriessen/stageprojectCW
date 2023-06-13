@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-3 d-flex flex-column">
            <x-user-menu :page="'artikelen'" />
            @if($article->image)
            <img src="/images/{{ $article->image }}" class="img-thumbnail mt-3" alt="...">
            <form action="{{ route('user.articles.delete.image', $article) }}" method="POST">
                @csrf
                @method('put')
                <button type="submit" class="btn btn-danger mt-2 w-100">Verwijder afbeelding</button>
            </form>
            @endif
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">Artikel bewerken</h1>
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif
                    <form method="POST" action="{{ route('user.articles.update', $article) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <x-errored-label for="title" :value="__('Titel')" :field="'title'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="title" autofocus value="{{ old('title') ?? $article->title }}">
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="introduction" :value="__('Introductie')" :field="'introduction'" />
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="introduction">{{ old('introduction') ?? $article->introduction }}</textarea>
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="article" :value="__('Inhoud')" :field="'content'" />
                            <div class="medium-editor">
                                <textarea class="form-control" id="editor" rows="7" name="content">{{ old('content') ?? $article->content }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="formFile" :value="__('Afbeelding')" :field="'image'" />
                            <input class="form-control" type="file" id="input" name="image">
                        </div>
                        <div class="d-flex mb-2" id="preview">
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <x-errored-label for="start_date" :value="__('Start datum')" :field="'start_date'" />
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') ?? $article->start_date }}">
                            </div>
                            <div class="col">
                                <x-errored-label for="end_date" :value="__('Eind datum')" :field="'end_date'" />
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') ?? $article->end_date }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('user.articles.index') }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                            <button class="btn btn-success mb-3">Artikel bijwerken</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/js/editor.js') }}" defer></script>
</div>
@endsection