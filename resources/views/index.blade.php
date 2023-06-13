@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-5">Nieuws</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($articles as $article)
        <div class="col">
            <div class="card h-100">
                <img src="images/{{ $article->image ?? 'template.jpg' }}" class="card-img-top" alt="Photo">
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text">{{ Str::limit($article->introduction, 140) }}</p>
                    <a href="{{ route('article.show', $article) }}" class="btn btn-primary stretched-link">Bekijk artikel</a>
                </div>
                <div class="card-footer">
                    <p class="card-text">Publicatie datum: {{ date('d-m-Y' , strtotime($article->start_date)) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{$articles->links()}}
    </div>
</div>


@endsection