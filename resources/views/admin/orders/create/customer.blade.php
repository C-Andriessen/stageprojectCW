@extends('layouts.app')

@section('content')
@php
$subtotal = 0;
$vat = 0;
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-admin-menu :page="'bestellingen'" />

        </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row align-items-center">
                <div>
                    <h1>Bestelling maken</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p class="text-success">Klantgegevens</p>
                </div>
                <div class="col-md-4">
                    <p>Producten toevoegen</p>
                </div>
                <div class="col-md-4">
                    <p>Bevestigen</p>
                </div>
            </div>
            <div class="progress mb-3" style="height: 12px">
                <div class="progress-bar bg-success" role="progressbar" aria-label="Success example" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              @if (session('status'))
              <x-alert />
              @endif
              <div class="card p-3">
                <form action="{{ route('admin.orders.store.customer') }}" method="post">
                    @csrf
                    <section class="customer">
                        <h2>Klantgegevens</h2>
                        <div class="mb-3">
                            <x-errored-label for="email" :value="__('Email')" :field="'email'" />
                            <input type="email" class="form-control" id="email" name="email" value="{{ $customer['email'] ?? old('email') }}">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <x-errored-label for="name" :value="__('Naam')" :field="'name'" />
                                <input type="text" class="form-control" id="name" name="name" value="{{ $customer['name'] ?? old('name') }}">
                            </div>
                            <div class="col-md-6">
                                <x-errored-label for="address" :value="__('Adres')" :field="'address'" />
                                <input type="text" class="form-control" id="address" name="address" value="{{ $customer['address'] ?? old('address') }}">
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-6">
                                <x-errored-label for="zip_code" :value="__('Postcode')" :field="'zip_code'" />
                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $customer['zip_code'] ?? old('zip_code') }}">
                            </div>
                            <div class="col-md-6">
                                <x-errored-label for="city" :value="__('Stad')" :field="'city'" />
                                <input type="text" class="form-control" id="city" name="city" value="{{ $customer['city'] ?? old('city') }}">
                            </div>
                          </div>
                          <div class="float-end">
                              <a href="{{ route('admin.orders.index') }}" class=" btn btn-link text-dark">Annuleren</a>
                              <button type="submit" class="btn btn-success">Verder</button>
                          </div>
                    </section>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection