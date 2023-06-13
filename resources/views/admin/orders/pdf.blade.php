<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if ($order->status == 0)
            Factuur {{" "}}
        @elseif($order->status == 1)
            Offerte {{" "}}
        @else
            Bestelling {{" "}}
        @endif
        #{{$order->id}}
    </title>
    <style>
        table {
            border-collapse: collapse;
        }

        tr.border-bottom {
            border-bottom: 1px solid #ddd;
        }

        td {
            padding: 10px;
        }

        body {
            padding: 2rem;
        }
    </style>
</head>

<body>

    <h1>
        @if ($order->status == 0)
            Factuur {{" "}}
        @elseif($order->status == 1)
            Offerte {{" "}}
        @else
            Bestelling {{" "}}
        @endif
        #{{$order->id}}
    </h1>
    <div class="card p-3">
        <div style="margin-bottom: 3rem;">
            <h2>Gegevens klant:</h2>
            <p class="mb-1"><b>Naam:</b> {{ $order->customer_name }}</p>
            <p class="mb-1"><b>Email:</b> {{ $order->customer_email }}</p>
            <p class="mb-1"><b>Adres:</b> {{ $order->customer_address }}</p>
            <p class="mb-1"><b>Stad:</b> {{ $order->customer_city }}</p>
            <p class="mb-1"><b>Postcode:</b> {{ $order->customer_zip_code }}</p>
        </div>
        <table style="width: 100%; text-align: left; border: #000 1px solid; margin-bottom: 3rem;">
            <thead>
                <tr style="border-bottom: #000 1px solid !important;">
                    <th style="border-bottom: #000 1px solid;">Naam</th>
                    <th style="border-bottom: #000 1px solid;">Aantal</th>
                    <th style="border-bottom: #000 1px solid;">Per stuk</th>
                    <th style="border-bottom: #000 1px solid;">Kortingsprijs</th>
                    <th style="border-bottom: #000 1px solid;">Prijs excl.</th>
                    <th style="border-bottom: #000 1px solid;">BTW</th>
                    <th style="border-bottom: #000 1px solid;">Prijs Incl.</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-bottom">
                    <td>{{ $product->product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>&euro; {{ number_format($product->price_excl, 2, ',', '.') }}</td>
                    <td>&euro; {{ $product->discount_price ? number_format($product->discount_price, 2, ',', '.') : '-' }}</td>
                    <td>&euro; {{ $product->discount_price ? number_format($product->discount_price * $product->quantity, 2, ',', '.') : number_format($product->price_excl * $product->quantity, 2, ',', '.') }}</td>
                    <td>{{ $product->vat }}%</td>
                    <td>&euro; {{ $product->discount_price ? number_format(($product->discount_price * $product->quantity * ($product->vat / 100)) + ($product->quantity * $product->discount_price), 2, ',', '.') : number_format(($product->price_excl * $product->quantity * $product->vat / 100) + ($product->quantity * $product->price_excl), 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p><b>Prijs exclusief BTW:</b> &euro; {{ number_format($order->subtotal_excl, 2, ',', '.') }}</p>
        <p><b>BTW:</b> &euro; {{ number_format($order->vat_total, 2, ',', '.') }}</p>
        <p><b>Totaal prijs:</b> &euro; {{ number_format($order->total_amount, 2, ',', '.') }}</p>
    </div>
</body>

</html>