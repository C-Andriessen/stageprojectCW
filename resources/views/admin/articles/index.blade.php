@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-admin-menu :page="'artikelen'" />

        </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <div>
                    <h1><a href="{{route('admin.article.index')}}" class="text-decoration-none text-dark">Artikelen</a></h1>
                </div>

                <form action="{{ route('admin.article.search') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Zoek artikel" aria-describedby="button-addon2" name="search" value="{{ request()->search ?? '' }}">
                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>

                <div>
                    <a href="{{ route('admin.article.create') }}" class="btn btn-success">Nieuw artikel</a>
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
                                <th>Auteur</th>
                                <th>Start datum</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                            <tr>
                                <td>{{$article->title}}</td>
                                <td>{{$article->creating_user->name}}</td>
                                <td>{{ date('d-m-Y' , strtotime($article->start_date)) }}</td>
                                <td>
                                    <a href="{{ route('admin.article.edit', $article) }}" class="text-dark text-decoration-none btn btn-link p-0">Bewerk</a>
                                </td>
                                <td>
                                    <a onclick="return confirm('Weet je zeker dat je &#8220;{{ $article->title }}&#8221; wilt verwijderen?')" href="{{ route('admin.article.delete', $article) }}" class="text-dark text-decoration-none btn btn-link p-0">Verwijder</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $articles->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection