@extends('layouts.app')

@section('content')
@php
session()->flash('order', session()->get('order'));
@endphp
<div class="container mt-5">
    <h1 class="mb-5">Bestelling afgerond</h1>

    <div class="card p-3">
        <h2 class="text-success fw-bold">Wat er nu gaat gebeuren</h2>
        <p class="fw-bold fs-5">Stap 1: Je krijgt een orderbevestiging in uw mail</p>
        <p>Uw ordernummer is: {{ $order->id }}</p>
        <p class="fw-bold fs-5"><b>Stap 2: We sturen de bestelling naar je toe</b></p>
        <p>Wij zorgen ervoor dat uw bestelling zo snel mogelijk bij u thuis terechtkomt en dat u er zo snel mogelijk van kunt genieten</p>
        <p class="fw-bold fs-5"><b>Stap 3: Je ontvangt je bestelling aan huis</b></p>
        <p>Je krijgt je bestelling zo spoedig mogelijk zodat je er thuis zo veel mogelijk van kan genieten</p>

        <h2>Jouw bestelde artikelen:</h2>
        <table class="table">
            <thead>
                <th>Naam</th>
                <th>Aantal</th>
                <th>Prijs per stuk</th>
                <th>Kortingsprijs</th>
                <th>Prijs exclusief btw</th>
                <th>BTW</th>
                <th>Prijs inclusief btw</th>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>&euro; {{ number_format($product->price_excl, 2, ',', '.') }}</td>
                    <td>&euro; {{ number_format($product->discount_price, 2, ',', '.') }}</td>
                    <td>&euro; {{ $product->discount_price ? number_format(($product->price_excl - $product->discount_price) * $product->quantity, 2, ',', '.') : number_format($product->price_excl * $product->quantity, 2, ',', '.') }}</td>
                    <td>{{ $product->vat }}%</td>
                    <td>&euro; {{ $product->discount_price ? number_format((($product->price_excl - $product->discount_price) * $product->quantity * ($product->vat / 100)) + (($product->price_excl - $product->discount_price) * $product->quantity), 2, ',', '.') : number_format(($product->price_excl * $product->quantity * ($product->vat / 100)) + ($product->price_excl * $product->quantity), 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="ms-auto me-3">
            <p><b>Prijs exclusief BTW:</b> &euro; {{ number_format($order->subtotal_excl, 2, ',', '.') }}</p>
            <p><b>BTW:</b> &euro; {{ number_format($order->vat_total, 2, ',', '.') }}</p>
            <p><b>Totaal prijs:</b> &euro; {{ number_format($order->total_amount, 2, ',', '.') }}</p>
        </div>
        <a class="ms-auto me-3 btn btn-success d-flex align-items-center" href="{{ route('products.index') }}">Ga terug naar de webshop <i class="fa-solid fa-right-long ms-2"></i></a>
    </div>
</div>


@endsection