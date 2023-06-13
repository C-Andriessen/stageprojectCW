@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-9">
            <a href="/" class="text-dark text-decoration-none single-back"><i class="fa-sharp fa-solid fa-arrow-left"></i> Terug</a>
            <img src="/images/{{ $article->image ?? 'template.jpg' }}" class="img-fluid img-single mb-2 mt-3" alt="...">
            <div class="d-flex justify-content-between flex-column flex-md-row mb-5">
                <p>Gepubliceerd op: {{ date('d-m-Y' , strtotime($article->start_date)) }}</p>
                <p>Auteur: {{ $article->creating_user->name }}</p>
            </div>
            <h2 class="mb-3">{{ $article->title }}</h2>
            <p class="fw-bold mb-3">{{ $article->introduction }}</p>
            {!! $article->content !!}

        </div>
        <div class="col-3">
            <nav class="nav flex-column">
                <h3 class="px-3 mb-3">Nieuwste artikelen</h3>
                @foreach($articleLinks as $articleLink)
                <a class="nav-link" href="{{ route('article.show', $articleLink) }}">{{$articleLink->title}}</a>
                @endforeach
            </nav>
        </div>
    </div>
</div>
@endsection