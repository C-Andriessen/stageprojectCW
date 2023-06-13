@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-5">Producten</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($products as $product)
        <div class="col">
            <div class="card h-100">
                <img src="/product_images/{{ $product->image  }}" class="card-img-top" alt="Photo">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    @if ($product->discount_price)
                    <p class="card-text mb-0"><s>&euro; {{ number_format($product->price_excl, 2, ',', '.') }}</s></p>
                    <p class="card-text"><span class="text-danger">&euro; {{ number_format($product->discount_price, 2, ',', '.') }}</span> exclusief BTW</p>
                    @else
                    <p class="card-text">&euro; {{ number_format($product->price_excl, 2, ',', '.') }} exclusief BTW</p>
                    @endif
                    <a href="{{ route('products.show', $product) }}" class="btn btn-success stretched-link">Bekijk product</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{$products->links()}}
    </div>
</div>


@endsection