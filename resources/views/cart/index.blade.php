@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-5">Winkelwagen</h1>
    @if (session('status'))
    <x-alert />
    @endif
    @if($items)
    <div class="row">
        <div class="col-md-9">
            <div class="card p-3">
                <table class="table  table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Productnaam</th>
                            <th scope="col">
                                Aantal {{" "}}
                                @error('quantity')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </th>
                            <th scope="col">Per stuk</th>
                            <th scope="col">Kortingsprijs</th>
                            <th scope="col">Prijs excl.</th>
                            <th scope="col">BTW</th>
                            <th scope="col">Prijs incl.</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item["product"]->name }}</td>
                            <td class="w-25">
                                <form action="{{ route('cart.update', $item['product']) }}" method="post">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td>&euro; {{ number_format($item["product"]->price_excl, '2', ',', '.') }}</td>
                            <td>&euro; {{ $item["product"]->discount_price ? number_format($item["product"]->discount_price, '2', ',', '.') : '-' }}</td>
                            <td>&euro; {{$item["product"]->discount_price ? number_format(($item["product"]->discount_price) * $item["quantity"], '2', ',', '.') : number_format($item["product"]->price_excl * $item["quantity"], '2', ',', '.') }}</td>
                            <td>{{ $item["product"]->vat }}%</td>
                            <td>&euro; {{ $item["product"]->discount_price ? number_format((($item["product"]->discount_price * $item["quantity"]) * $item["product"]->vat / 100 + ($item["product"]->discount_price) * $item["quantity"]), '2', ',', '.') : number_format((($item["product"]->price_excl * $item["quantity"]) * $item["product"]->vat / 100 + ($item["product"]->price_excl * $item["quantity"])), '2', ',', '.')  }}</td>
                            <td>
                                <form action="{{ route('cart.destroy', $item['product']) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="bg-transparent border border-0" onclick="return confirm('Weet je zeker dat je &ldquo;{{ $item["product"]->name  }}&rdquo; wilt verwijderen uit winkelwagen')"><i class="fa-solid fa-circle-xmark text-danger fa-lg"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mb-3 me-3 d-flex ms-auto align-items-center">
                    <a href="{{ route('cart.data') }}" class="btn btn-success float-end d-flex align-items-center">Ik ga bestellen</a>
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
                            <td>&euro; {{ number_format($prices['subtotal'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Korting</td>
                            <td>- &euro; {{ number_format($prices['discount'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Prijs met korting</td>
                            <td>&euro; {{ number_format($prices['discountedTotal'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>BTW</td>
                            <td>&euro; {{ number_format($prices['vat'], 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Totaal incl. BTW</td>
                            <td>&euro; {{ number_format($prices['total'], 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <h2>Je hebt op dit moment nog geen producten in je winkelwagen</h2>
    @endif
</div>


@endsection