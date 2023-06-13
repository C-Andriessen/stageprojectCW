@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-admin-menu :page="'rollen'" />

        </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <div>
                    <h1><a href="{{route('admin.role.index')}}" class="text-decoration-none text-dark">Rollen</a></h1>
                </div>

                <form action="{{ route('admin.role.search') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Zoek rol" aria-describedby="button-addon2" name="search" value="{{ request()->search ?? '' }}">
                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
                <div>
                    <a href="{{ route('admin.role.create') }}" class="btn btn-success">Nieuwe rol</a>
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
                                <th>Naam</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td class="align-middle">{{$role->name}}</td>
                                <td class="align-middle"><a href="{{ route('admin.role.edit', $role) }}" class="text-decoration-none text-dark btn btn-link p-0">Bewerk</a></td>
                                <td>
                                    <form action="{{ route('admin.role.delete', $role) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Weet je zeker dat je de gebruiker &#8220;{{ $role->name }}&#8221; wilt verwijderen?')" class="btn btn-link text-decoration-none text-dark p-0">Verwijder</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection