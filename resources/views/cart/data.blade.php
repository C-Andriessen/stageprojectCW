@extends('layouts.app')

@section('content')
@php
$subtotal = 0;
$vat = 0;
foreach($items as $item) {
    $vat += $item["product"]->discount_price ? ($item["product"]->discount_price) * $item["quantity"] * ($item["product"]->vat / 100) : ($item["product"]->price_excl) * $item["quantity"] * ($item["product"]->vat / 100) ;
    $subtotal += $item["product"]->discount_price ? $item["product"]->discount_price * $item["quantity"] : $item["product"]->price_excl * $item["quantity"];
}
$total = $subtotal + $vat;
@endphp
<div class="container mt-5">
    <h1 class="mb-5">Gegevens</h1>
    <div class="row">
        <div class="col-md-9">
            <div class="card p-3">
                @if (session('status'))
                <x-alert />
                @endif
                <form action="{{ route('cart.store.data') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <x-errored-label for="name" :value="__('Naam')" :field="'name'" />
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="name" autofocus value="{{ request()->session()->get('customer')['name'] ?? old('name') }}">
                    </div>
                    <div class="mb-3">
                        <x-errored-label for="email" :value="__('Email')" :field="'email'" />
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="email" autofocus value="{{ request()->session()->get('customer')['email'] ?? old('email') }}">
                    </div>
                    <div class="mb-3">
                        <x-errored-label for="address" :value="__('Adres')" :field="'address'" />
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="address" autofocus value="{{ request()->session()->get('customer')['address'] ?? old('address') }}">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <x-errored-label for="city" :value="__('Stad')" :field="'city'" />
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="city" autofocus value="{{ request()->session()->get('customer')['city'] ?? old('city') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <x-errored-label for="zip_code" :value="__('Postcode')" :field="'zip_code'" />
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="zip_code" autofocus value="{{ request()->session()->get('customer')['zip_code'] ?? old('zip_code') }}">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center float-end">
                        <a href="{{ route('cart.index') }}" class="text-dark me-3">Winkelwagen bijwerken</a>
                        <button type="submit" class="btn btn-success float-end d-flex align-items-center">Volgende stap</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Samenvatting
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td>Prijs excl. BTW</td>
                            <td>&euro; {{ number_format($subtotal, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>BTW</td>
                            <td>&euro; {{ number_format($vat, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Totaal incl. BTW</td>
                            <td>&euro; {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection