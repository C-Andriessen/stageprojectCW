@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-admin-menu :page="'gebruikers'" />

        </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <div>
                    <h1><a href="{{route('admin.users.index')}}" class="text-decoration-none text-dark">Gebruikers</a></h1>
                </div>

                <form action="{{ route('admin.users.search') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Zoek gebruiker" aria-describedby="button-addon2" name="search" value="{{ request()->search ?? '' }}">
                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
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
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Aantal artikelen</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td class="">{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ count($user->created_articles) }}</td>
                                <td><a href="{{ route('admin.users.edit', $user) }}" class="text-decoration-none btn btn-link text-dark p-0">Bewerk</a></td>
                                <td>
                                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="mb-0">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Weet je zeker dat je de gebruiker &#8220;{{ $user->name }}&#8221; wilt verwijderen?')" class="btn btn-link text-decoration-none text-dark p-0">Verwijder</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $users->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('/js/test.js') }}"></script>