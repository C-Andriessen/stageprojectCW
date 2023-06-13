@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-admin-menu :page="'bedrijven'" />
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">{{ __('Bedrijf toevoegen') }}</h1>
            <div class="card mb-5">

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.companies.store') }}">
                        @csrf
                        <div class="mb-3">
                            <x-errored-label for="name" :value="__('Naam')" :field="'name'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="name" autofocus value="{{ old('name')}}">
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="email" :value="__('E-mail')" :field="'email'" />
                            <input type="email" class="form-control" id="exampleFormControlInput1" name="email" value="{{ old('email')}}">
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="address" :value="__('Adres')" :field="'address'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="address" value="{{ old('address') }}">
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="city" :value="__('Stad')" :field="'city'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="city" value="{{ old('city') }}">
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="zip_code" :value="__('Postcode')" :field="'zip_code'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="zip_code" value="{{ old('zip_code') }}">
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="phone_number" :value="__('Telefoon nummer')" :field="'phone_number'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="phone_number" value="{{ old('phone_number') }}">
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.companies.index') }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                            <button class="btn btn-success mb-3">Opslaan</button>
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