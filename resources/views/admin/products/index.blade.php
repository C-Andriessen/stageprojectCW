@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-admin-menu :page="'producten'" />

        </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row">
                <div>
                    <h1><a href="{{route('admin.products.index')}}" class="text-decoration-none text-dark">Producten</a></h1>
                </div>

                <form action="{{ route('admin.products.search') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Zoek product" aria-describedby="button-addon2" name="search" value="{{ request()->search ?? '' }}">
                        <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>

                <div>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">Nieuw product</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Prijs exclusief</th>
                                <th>Kortingsprijs</th>
                                <th>BTW</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{$product->name}}</td>
                                <td>&euro; {{ number_format($product->price_excl, 2, ',', '.') }}</td>
                                <td>&euro; {{ $product->discount_price ? number_format($product->discount_price, 2, ',', '.') : '-' }}</td>
                                <td>{{ $product->vat }}%</td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-link text-dark text-decoration-none p-0">Bewerk</a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Weet je zeker dat je &#8220;{{ $product->name }}&#8221; wilt verwijderen?')" class="btn btn-link text-dark text-decoration-none p-0">Verwijder</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection