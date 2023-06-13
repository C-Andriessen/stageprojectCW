@extends('layouts.app')

@section('content')
@include('includes.modals.category.create')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-admin-menu :page="'categorie'" />

        </div>
        <div class="col-10 col-md-9">
            @if (session('status'))
            <x-alert />
            @endif
            <div class="row mb-4">
                <div class="col-md-4">
                    <h1><a href="{{route('admin.category.index')}}" class="text-decoration-none text-dark">Categorieën</a></h1>
                </div>

                <div class="col-md-4">
                    <form action="{{ route('admin.category.search') }}">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Zoek een categorie" aria-describedby="button-addon2" name="search" value="{{ request()->search ?? '' }}">
                            <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>

                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
                        Categorie toevoegen
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{$category->name}}</td>
                                <td>
                                    <button type="button" class="btn btn-link text-decoration-none text-dark p-0" data-bs-toggle="modal" data-bs-target="#edit{{ $category->id }}Modal">
                                        Bewerken
                                    </button>
                                    @include('includes.modals.category.edit')
                                </td>
                                <td>
                                    <form action="{{ route('admin.category.destroy', $category) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Weet je zeker dat je &#8220;{{ $category->name }}&#8221; wilt verwijderen?')" class="btn btn-link text-dark text-decoration-none p-0">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection