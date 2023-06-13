@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-user-menu :page="'artikelen'" />

        </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <div>
                    <h1><a href="{{route('user.articles.index')}}" class="text-decoration-none text-dark">Artikelen</a></h1>
                </div>

                <form action="{{ route('user.articles.index') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Zoek artikel" aria-describedby="button-addon2" name="search" value="{{ request()->search ?? '' }}">
                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>

                <div>
                    <a href="{{ route('user.articles.create') }}" class="btn btn-success">Nieuw artikel</a>
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
                                <th class="d-none d-md-block">Start datum</th>
                                <th>Bewerk</th>
                                <th>Verwijder</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                                <td>{{$article->title}}</td>
                                <td class="d-none d-md-block">{{ date('d-m-Y' , strtotime($article->start_date)) }}</td>
                                <td>
                                    <a href="{{ route('user.articles.edit', $article) }}" class="text-dark text-decoration-none">Bewerk</a>
                                </td>
                                <td>
                                    <a onclick="return confirm('Weet je zeker dat je &#8220;{{ $article->title }}&#8221; wilt verwijderen?')" href="{{ route('user.articles.delete', $article) }}" class="text-dark text-decoration-none">Verwijder</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection