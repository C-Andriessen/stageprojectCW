@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-admin-menu :page="'rollen'" />
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">{{ __('Rol bewerken') }}</h1>
            <div class="card mb-5">

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.role.update', $role) }}">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <x-errored-label for="name" :value="__('Naam')" :field="'name'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="name" autofocus value="{{ old('name') ?? $role->name }}">
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.role.roles') }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                            <button class="btn btn-success mb-3">Rol bewerken</button>
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