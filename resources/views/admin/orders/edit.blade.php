@extends('layouts.app')

@section('content')
@php
if (session('status') == "Order is bijgewerkt") 
{
    session()->forget('status'); 
}
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-3 mb-3">
            <x-admin-menu :page="'bestellingen'" />
        </div>
        <div class="modal fade" id="modalProducts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Product toevoegen</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('admin.orders.edit.add', $order) }}" method="post">
                    @csrf
                    <select name="product" class="select2 form-select" {{ count($productsNew) == 0 ? 'disabled' : '' }}>
                        @forelse($productsNew as $productNew)
                        <option value="{{ $productNew->id }}">{{ $productNew->name }}</option>
                        @empty
                        <option>Er zijn geen producten meer die je nog niet hebt toegevoegd</option>
                        @endforelse
                    </select>
                    <div class="modal-footer border-top-0 px-0">
                      <button type="submit" id="submitBtn" name="submitBtn" class="btn btn-success {{ count($productsNew) == 0 ? 'disabled' : '' }}">Toevoegen</button>
                    </div>
                  </div>
                </form>
                </div>
            </div>
          </div>
        <div class="col-10 col-md-9">
            <div class="d-flex justify-content-between  mb-4 flex-column flex-md-row align-items-center">
                <div>
                    <h1>
                        @if ($order->status == 0)
                        Factuur
                        @elseif($order->status == 1)
                        Offerte
                        @else
                        Bestelling
                        @endif
                        #{{ $order->id }}
                    </h1>
                </div>
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Opties
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('admin.orders.downloadPDF', $order) }}">PDF Bekijken</a></li>
                      <li><a class="dropdown-item" href="{{ route('admin.orders.edit.mail', $order) }}">Mail versturen</a></li>
                      <li>
                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalProducts">
                        Product toevoegen
                      </button>
                    </li>
                    </ul>
                  </div>
            </div>
            @if (session('status'))
            <x-alert />
            @endif
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                 @if (!$errors->has('email') && !$errors->has('name') && !$errors->has('address') && !$errors->has('zip_code') && !$errors->has('city'))
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-dark active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">Producten</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-dark" id="data-tab" data-bs-toggle="tab" data-bs-target="#data-tab-pane" type="button" role="tab" aria-controls="data-tab-pane" aria-selected="false">Gegevens</button>
                </li>
                @else
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="true">Producten</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data-tab-pane" type="button" role="tab" aria-controls="data-tab-pane" aria-selected="false">Gegevens</button>
                  </li>
                @endif
              </ul>
              <div class="card p-3">
                    <div class="tab-content" id="myTabContent">
                        @if (!$errors->has('email') && !$errors->has('name') && !$errors->has('address') && !$errors->has('zip_code') && !$errors->has('city'))
                      <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab" tabindex="0">
                          @else
                          <div class="tab-pane fade" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab" tabindex="0">
                        @endif
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Naam</th>
                                    <th>Aantal
                                        @error('quantity')
                                        <br>
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </th>
                                    <th>Per stuk</th>
                                    <th>Kortingsprijs
                                        @error('discountPrice')
                                        <br>
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </th>
                                    <th>Prijs excl.</th>
                                    <th>BTW</th>
                                    <th>Prijs Incl.</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td><a href="{{ route('admin.products.edit', $product->product) }}">{{ Str::limit($product->product->name, 25) }}</a></td>
                                    <td>
                                        <form action="{{ route('admin.orders.edit.product.quantity', [$order, $product]) }}" method="post" style="width: 80px;">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="discount_price" value="{{ $product->discount_price }}">
                                            <input type="number" name="quantity" id="" value="{{ $product->quantity }}" class="form-control">
                                        </form>
                                    </td>
                                    <td>&euro; {{ number_format($product->price_excl, 2, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('admin.orders.edit.product.discount', [$order, $product]) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="quantity" value="{{ $product->quantity }}">
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">&euro;</span>
                                                    <input type="float" name="discountPrice" value="{{ $product->discount_price }}" class="form-control w-75" onchange="this.value = this.value.replace(/,/g, '.'); this.form.submit();">
                                                </div>
                                        </form>
                                    </td>
                                    <td>&euro; {{ $product->discount_price ? number_format($product->discount_price * $product->quantity, 2, ',', '.') : number_format($product->price_excl * $product->quantity, 2, ',', '.') }}</td>
                                    <td>{{ $product->vat }}%</td>
                                    <td>&euro; {{ $product->discount_price ? number_format(($product->discount_price * $product->quantity * $product->vat / 100) + ($product->quantity * $product->discount_price), 2, ',', '.') : number_format(($product->price_excl * $product->quantity * $product->vat / 100) + ($product->quantity * $product->price_excl), 2, ',', '.') }}</td>
                                    <td>                                
                                        <form action="{{ route('admin.orders.edit.product.destroy', [$order, $product]) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            @if (count($products) == 1)
                                            <button type="submit" class="bg-transparent border-0" onclick="return confirm('Als je dit product verwijderd verwijder je de gehele order (product: {{ $product->product->name }})')"><i class="fa-solid fa-circle-xmark text-danger"></i></button>
                                            @else
                                            <button type="submit" class="bg-transparent border-0" onclick="return confirm('Weet je zeker dat je {{ $product->product->name }} wilt verwijderen uit de order?')"><i class="fa-solid fa-circle-xmark text-danger"></i></button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                                @foreach($productAccessories as $accessory)
                                @if($accessory->product_id == $product->product_id)
                                <tr>
                                    <td>{{ $accessory->accessory->name }}</td>
                                </tr>
                                @endif
                                @endforeach
                                @if(!$product->product->accessories->isEmpty())
                                <tr>
                                    <td>
                                        <p>+ Accessoire toevoegen</p>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
        
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div class="mb-3">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Prijs excl. BTW</td>
                                        <td>&euro; {{ number_format($order->subtotal_excl, 2, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>BTW</td>
                                        <td>&euro; {{ number_format($order->vat_total, 2, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Totaal incl. BTW</td>
                                        <td>&euro; {{ number_format($order->total_amount, 2, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <form action="{{ route('admin.orders.edit.change.status', $order) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <select name="type" id="" onchange="this.form.submit()" class="form-select">
                                        <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Factuur</option>
                                        <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Offerte</option>
                                        <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Bestelling</option>
                                    </select>
                                </form>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-link text-dark">Terug</a>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-success mb-5" onclick="{{ Session::flash('status', 'Order is bijgewerkt') }}">Opslaan</a>
                            </div>
                        </div>
                      </div>
                      @if ($errors->has('email') || $errors->has('name') || $errors->has('address') || $errors->has('zip_code') || $errors->has('city'))
                      <div class="tab-pane fade show active" id="data-tab-pane" role="tabpanel" aria-labelledby="data-tab" tabindex="0">
                          @else
                          <div class="tab-pane fade" id="data-tab-pane" role="tabpanel" aria-labelledby="data-tab" tabindex="0">
                        @endif
                      <form action="{{ route('admin.orders.update', $order) }}" method="post">
                        @csrf
                        @method('put')
                        <section class="customer">
                            <h2>Klantgegevens</h2>
                            <div class="mb-3">
                                <x-errored-label for="email" :value="__('Email')" :field="'email'" />
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $order->customer_email) }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <x-errored-label for="name" :value="__('Naam')" :field="'name'" />
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $order->customer_name) }}">
                                </div>
                                <div class="col-md-6">
                                    <x-errored-label for="address" :value="__('Adres')" :field="'address'" />
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $order->customer_address) }}">
                                </div>
                              </div>
                              <div class="row mb-3">
                                <div class="col-md-6">
                                    <x-errored-label for="zip_code" :value="__('Postcode')" :field="'zip_code'" />
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code', $order->customer_zip_code) }}">
                                </div>
                                <div class="col-md-6">
                                    <x-errored-label for="city" :value="__('Stad')" :field="'city'" />
                                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $order->customer_city) }}">
                                </div>
                              </div>
                              <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-link text-dark">Terug</a>
                                <button type="submit" class="btn btn-success">Opslaan</button>
                            </div>
                        </section>
                    </form>
                </div>
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