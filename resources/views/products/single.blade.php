@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <a href="{{ route('products.index') }}" class="text-dark text-decoration-none mb-5"><i class="fa-solid fa-arrow-left"></i> Terug</a>
    <h1 class="mb-5">{{ $product->name }}</h1>
    <div class="row">
        <div class="col-md-3">
            <img src="/product_images/{{ $product->image }}" alt="" class="img-thumbnail">
        </div>
        <div class="col-md-8 d-flex flex-column">
            <h2 class="mb-4 fw-bold">Productbeschrijving</h2>
            {!! $product->description !!}
            <form action="{{ route('cart.add', $product) }}" method="post" class="mt-auto">
            @foreach($product->accessories->unique('category_id') as $category)
            <div class="mb-3">
                <p class="mb-0">{{ $category->category->name }}</p>
                <select name="accessoires[]" class="form-select" id="{{ $category->category->id }}" onchange="calculate()">
                    <option value="{{NULL}}">Kies een accessoire</option>
                    @foreach($product->accessories->where('category_id', $category->category_id) as $accessory)
                    <option value="{{ $accessory->id }}">{{ $accessory->name }} + &euro; {{ $accessory->discount_price ? number_format(($accessory->discount_price), '2', ',', '.') : number_format(($accessory->price), '2', ',', '.') }}</option>
                    @endforeach
                </select>
            </div>
            @endforeach
            @if ($product->discount_price)
            <p class="fs-5 fw-bold italic"><s id="price_excl">&euro; {{ number_format(($product->price_excl), '2', ',', '.') }}</s> <span class="text-danger" id="price_discount">&euro; {{ number_format(($product->discount_price), '2', ',', '.') }}</span> <span class="text-secondary">exclusief BTW</span></p>
            @else
            <p class="fs-5 fw-bold italic"><span id="price_excl">&euro; {{ number_format(($product->price_excl), '2', ',', '.') }}</span> <span class="text-secondary">exclusief BTW</span></p>
            @endif
                @csrf
                <button class="btn btn-success fs-5 w-25"><i class="fa-solid fa-cart-shopping me-2"></i> Bestel nu</button>
            </form>
        </div>
        <div class="row mt-5">
            <h2 class="fw-bold mb-4">Onze nieuwste producten</h2>
            @forelse ($products as $productFeed)
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="/product_images/{{ $productFeed->image  }}" class="card-img-top" alt="Photo">
                    <div class="card-body">
                        <h5 class="card-title">{{ $productFeed->name }}</h5>
                        @if ($productFeed->discount_price)
                            <p class="card-text mb-0"><s>&euro; {{ number_format($productFeed->price_excl, 2, ',', '.') }}</s></p>
                            <p class="card-text"><span class="text-danger">&euro; {{ number_format($productFeed->discount_price, 2, ',', '.') }}</span> exclusief BTW</p>
                        @else
                        <p class="card-text">&euro; {{ number_format($productFeed->price_excl, 2, ',', '.') }} exclusief BTW</p>
                        @endif
                        <a href="{{ route('products.show', $productFeed) }}" class="btn btn-success stretched-link">Bekijk product</a>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
<script>
    const accessories = {!!  collect($product->accessories) !!}
    const price = {!! $product->price_excl !!}
    const discountPrice = {!! $product->discount_price ?? 0 !!}
    const priceDiscount = {!! $product->discount_price ? 'true' : 'false' !!} ? document.getElementById('price_discount') : ''
    const priceExcl = document.getElementById('price_excl')
    const selects = document.querySelectorAll('[name="accessoires[]"]')
    let total = price
    let discountTotal = discountPrice;

    const calculate = () => {
        total = price
        discountTotal = discountPrice
        selects.forEach(select => {
            accessories.forEach(accessory => {
                if (select.value == accessory.id) {
                   discountTotal += accessory.discount_price ? accessory.discount_price : accessory.price
                   total += accessory.discount_price ? accessory.discount_price : accessory.price
                }
            })
        });
        if ({!! $product->discount_price ? 'true' : 'false' !!}) {
            priceExcl.innerText = new Intl.NumberFormat('nl-NL' , { style: 'currency', currency: 'EUR' }).format(total)
            priceDiscount.innerText = new Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(discountTotal)
        } else {
            priceExcl.innerText= new Intl.NumberFormat('nl-NL' , { style: 'currency', currency: 'EUR' }).format(total)
        }
    }

</script>

@endsection