@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-admin-menu :page="'bestellingen'" />

        </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <div>
                    <h1><a href="{{route('admin.orders.index')}}" class="text-decoration-none text-dark">Bestellingen</a></h1>
                </div>

                <form action="{{ route('admin.orders.search') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Zoek bestelling" aria-describedby="button-addon2" name="search" value="{{ request()->search ?? '' }}">
                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
                <div>
                    <form action="{{ route('admin.orders.clear.session') }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-success">Bestelling maken</button>
                    </form>
                </div>
            </div>
            @if (session('status'))
            <x-alert />
            @endif
            <div class="card">
                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nummer</th>
                                <th>Totaal prijs</th>
                                <th>Klant</th>
                                <th>Type</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td># {{ $order->id }}</td>
                                <td>&euro; {{ number_format($order->total_amount, 2, ',', '.') }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>
                                    @if ($order->status == 0)
                                        Factuur
                                    @elseif($order->status == 1)
                                        Offerte
                                    @else
                                        Bestelling
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.edit.index', $order) }}" class="btn btn-link text-dark text-decoration-none p-0">Bewerk</a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Weet je zeker dat je &#8220;#{{ $order->id }}&#8221; wilt verwijderen?')" class="btn btn-link text-dark text-decoration-none p-0">Verwijder</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection