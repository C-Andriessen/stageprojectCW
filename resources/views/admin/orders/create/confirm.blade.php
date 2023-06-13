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
                    <p>Klantgegevens</p>
                </div>
                <div class="col-md-4">
                    <p>Producten toevoegen</p>
                </div>
                <div class="col-md-4">
                    <p class="text-success">Bevestigen</p>
                </div>
            </div>
            <div class="progress mb-3" style="height: 12px">
                <div class="progress-bar bg-success" role="progressbar" aria-label="Success example" style="width: 85%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <div class="card p-3">
                <div class="mb-4">
                    <h4>Klant gegevens</h4>
                    <p class="mb-1"><b>Naam: </b> {{ $customer['name'] }}</p>
                    <p class="mb-1"><b>Email: </b> {{ $customer['email'] }}</p>
                    <p class="mb-1"><b>Adres:</b> {{ $customer['address'] }}</p>
                    <p class="mb-1"><b>Stad: </b> {{ $customer['city'] }}</p>
                    <p class="mb-1"><b>Postcode: </b> {{ $customer['zip_code'] }}</p>
                </div>
                <table class="table">
                    <thead>
                        <th>Naam</th>
                        <th>Aantal</th>
                        <th>Per stuk</th>
                        <th>Kortingsprijs</th>
                        <th>Prijs exclusief</th>
                        <th>BTW</th>
                        <th>Prijs inclusief</th>
                    </thead>
                    <tbody>
                        @foreach ($sessionProducts as $sessionProduct)
                        <tr>

                            <td>{{ $sessionProduct['product']->name }}</td>
                            <td>{{ $sessionProduct['quantity'] }}</td>
                            <td>&euro; {{ number_format($sessionProduct['product']->price_excl, 2, ',', '.') }}</td>
                            <td>&euro; {{ $sessionProduct['discountPrice'] ? number_format($sessionProduct['discountPrice'], 2, ',', '.') : '-' }}</td>
                            <td>&euro; {{ $sessionProduct['discountPrice'] ? number_format(($sessionProduct["product"]->price_excl - $sessionProduct['discountPrice']) * $sessionProduct['quantity'], 2, ',', '.') : number_format($sessionProduct['product']->price_excl * $sessionProduct['quantity'], 2, ',', '.') }}</td>
                            <td>{{ $sessionProduct['product']->vat }}%</td>
                            <td>&euro; 
                                {{
                                    $sessionProduct['discountPrice'] ?
                                    number_format(($sessionProduct["product"]->price_excl - $sessionProduct["discountPrice"]) * $sessionProduct["quantity"] * ($sessionProduct["product"]->vat / 100) + ($sessionProduct["product"]->price_excl - $sessionProduct["discountPrice"]) * $sessionProduct["quantity"] , 2, ',', '.') :
                                    number_format(($sessionProduct['product']->price_excl * ($sessionProduct['product']->vat / 100) + $sessionProduct['product']->price_excl) * $sessionProduct['quantity'], 2, ',', '.')
                                }}
                            </td>
                        </tr>
                        @php
                            $vat += $sessionProduct['discountPrice'] ?  ($sessionProduct['discountPrice'] * $sessionProduct['quantity'] * ($sessionProduct['product']->vat / 100)) : ($sessionProduct['product']->price_excl * $sessionProduct['quantity'] * ($sessionProduct['product']->vat / 100));
                            $subtotal += $sessionProduct['discountPrice'] ? $sessionProduct['discountPrice'] * $sessionProduct['quantity'] : ($sessionProduct['product']->price_excl * $sessionProduct['quantity']);
                            $total = $subtotal + $vat;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="ms-auto mb-3">
                    <p><b>Prijs exclusief BTW:</b> &euro; {{ number_format($subtotal, 2, ',', '.') }}</p>
                    <p><b>BTW:</b> &euro; {{ number_format($vat, 2, ',', '.') }}</p>
                    <p><b>Totaal prijs:</b> &euro; {{ number_format($total, 2, ',', '.') }}</p>
                </div>
                <form action="{{ route('admin.orders.store.order') }}" method="post">
                    @csrf
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-6">
                            <x-errored-label for="type" :value="__('Type')" :field="'type'" />
                            <select name="type" class="form-select">
                                    <option value="0">Factuur</option>
                                    <option value="1">Offerte</option>
                                    <option value="2">Bestelling</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="flexCheckDefault">
                              Mail versturen?
                            </label>
                            <input class="form-check" type="checkbox" value="true" id="flexCheckDefault" name="send">
                        </div>
                    </div>
                    <div class="float-end">
                        <a href="{{ route('admin.orders.create.products') }}" class="btn btn-link text-dark">Stap terug</a>
                        <button type="submit" class="btn btn-success" onclick="$(this).addClass('disabled')">Order aanmaken</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
    $(".select2").select2({
        dropdownParent: $('#modalProducts'),
        theme: 'bootstrap-5'
    });
});
</script>
@endsection