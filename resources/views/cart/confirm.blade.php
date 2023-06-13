@extends('layouts.app')

@section('content')
@php
$vat = 0;
$subtotal = 0;
@endphp
<div class="container mt-5">
    <h1 class="mb-5">Bestelling bevestigen</h1>
<div class="row">
    <div class="col-md-9">
        <div class="card p-3">
            <div class="mb-4">
                <h3>Gegevens</h3>
                <p class="mb-1"><b>Naam:</b> {{ $customer["name"] }}</p>
                <p class="mb-1"><b>Email:</b> {{ $customer["email"] }}</p>
                <p class="mb-1"><b>Adres:</b> {{ $customer["address"] }}</p>
                <p class="mb-1"><b>Stad:</b> {{ $customer["city"] }}</p>
                <p class="mb-1"><b>Postcode:</b> {{ $customer["zip_code"] }}</p>
            </div>
            <table class="table  table-striped">
                <thead>
                    <tr>
                        <th scope="col">Productnaam</th>
                        <th scope="col">Aantal</th>
                        <th scope="col">Per stuk</th>
                        <th scope="col">Kortingsprijs</th>
                        <th scope="col">Prijs excl.</th>
                        <th scope="col">BTW</th>
                        <th scope="col">Prijs incl.</th>
                    </tr>
                </thead>
                @foreach($items as $item)
                <tbody>
                    <tr>
                        <td>{{ $item["product"]->name }}</td>
                        <td>{{ $item["quantity"] }}</td>
                        <td>&euro; {{ number_format($item["product"]->price_excl, '2', ',', '.') }}</td>
                        <td>&euro; {{ $item["product"]->discount_price ? number_format($item["product"]->discount_price, '2', ',', '.') : '-' }}</td>
                        <td>&euro; {{$item["product"]->discount_price ? number_format($item["product"]->discount_price * $item["quantity"], 2, ',', '.') : number_format($item["product"]->price_excl * $item["quantity"], 2, ',', '.') }}</td>
                        <td>{{ $item["product"]->vat }}%</td>
                        <td>&euro; {{ $item["product"]->discount_price ? number_format((($item["product"]->discount_price * $item["quantity"]) * $item["product"]->vat / 100 + ($item["product"]->discount_price * $item["quantity"])), 2, ',', '.') : number_format((($item["product"]->price_excl * $item["quantity"]) * $item["product"]->vat / 100 + ($item["product"]->price_excl * $item["quantity"])), 2, ',', '.')  }}</td>
                    </tr>
                </tbody>
                @php
                    $vat += $item["product"]->discount_price ? ($item["product"]->discount_price) * $item["quantity"] * ($item["product"]->vat / 100) : ($item["product"]->price_excl) * $item["quantity"] * ($item["product"]->vat / 100) ;
                    $subtotal += $item["product"]->discount_price ? ($item["product"]->discount_price * $item["quantity"]) : ($item["product"]->price_excl * $item["quantity"]);
                    $total = $subtotal + $vat;
                @endphp
                @endforeach
            </table>
            <div class="mb-3 me-3 d-flex align-items-center ms-auto">
                <a href="{{ route('cart.data') }}" class="text-dark me-3">Gegevens bewerken</a>
                <div id="paypal-button-container"></div>
            </div>
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
    {{-- <form action="/order" method="post">
        <button type="submit">bestel</button>
    </form> --}}
</div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}&currency=EUR"></script>

<script script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?= number_format($total, 2, '.', '') ?>'
                    }
                }]
            });
        },
        onApprove: async function(data, actions) {
            const response = await fetch('/order', {
                method: 'POST', // *GET, POST, PUT, DELETE, etc.
                mode: 'cors', // no-cors, *cors, same-origin
                cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                credentials: 'same-origin', // include, *same-origin, omit
                headers: {
                    'Content-Type': 'application/json',
                    // 'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                redirect: 'follow', // manual, *follow, error
                referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
            });
            return actions.order.capture().then(function(details) {
                window.location.href = '/cart/confirmed'
            });

        },
        onCancel: function(data, action) {
            alert('De betaling is geannuleerd')
        },

        style: {
            layout: 'horizontal',
            color: 'black'
        }
    }).render('#paypal-button-container');
</script>


@endsection