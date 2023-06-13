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
  <!-- Modal -->
  <div class="modal fade" id="modalProducts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Product toevoegen</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.orders.store.product') }}" method="post">
            @csrf
            <select name="product" class="form-select select2" {{ count($products) == 0 ? 'disabled' : '' }}>
                @forelse($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
                @empty
                <option>Er zijn geen producten meer in de webshop</option>
                @endforelse
            </select>
            <div class="modal-footer border-top-0 px-0">
              <button type="submit" class="btn btn-success {{ count($products) == 0 ? 'disabled' : '' }}">Toevoegen</button>
            </div>
          </div>
        </form>
        </div>
    </div>
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
                    <p class="text-success">Producten toevoegen</p>
                </div>
                <div class="col-md-4">
                    <p>Bevestigen</p>
                </div>
            </div>
            <div class="progress mb-3" style="height: 12px">
                <div class="progress-bar bg-success" role="progressbar" aria-label="Success example" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              @if (session('status'))
              <x-alert />
              @endif
              <div class="card p-3">
                @if($sessionProducts)
                <table class="table">
                    <thead>
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
                        <th>Prijs exclusief</th>
                        <th>BTW</th>
                        <th>Prijs inclusief</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($sessionProducts as $sessionProduct)
                        <tr>

                            <td>{{ Str::limit($sessionProduct['product']->name, 25) }}</td>
                            <td style="max-width: fit-content">
                                <form action="{{ route('admin.orders.update.product', $sessionProduct["product"]) }}" method="post" style="width: 80px; margin-right: 0 !important;" id="quantity">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="discountPrice" value="{{ $sessionProduct['discountPrice'] }}">
                                    <input type="number" value="{{ $sessionProduct["quantity"] }}" id="quantity{{$sessionProduct["product"]->id}}" onchange="this.form.submit()" name="quantity" class="form-control">
                                </form>
                            </td>
                            <td>&euro; {{ number_format($sessionProduct['product']->price_excl, 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('admin.orders.update.product', $sessionProduct["product"]) }}" method="post"  style="width: 150px" id="discount">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="quantity" value="{{ $sessionProduct["quantity"] }}">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">&euro;</span>
                                        <input type="string" name="discountPrice" value="{{ $sessionProduct['discountPrice'] }}" onchange="this.value = this.value.replace(/,/g, '.'); this.form.submit()" class="form-control w-75">
                                    </div>
                                </form>
                            </td>
                            <td>&euro; {{ $sessionProduct['discountPrice'] ? number_format($sessionProduct['discountPrice'] * $sessionProduct['quantity'], 2, ',', '.') : number_format($sessionProduct['product']->price_excl * $sessionProduct['quantity'], 2, ',', '.') }}</td>
                            <td>{{ $sessionProduct['product']->vat }}%</td>
                            <td>&euro; 
                                {{
                                    $sessionProduct['discountPrice'] ?
                                    number_format($sessionProduct["discountPrice"] * $sessionProduct["quantity"] * ($sessionProduct["product"]->vat / 100) + $sessionProduct["discountPrice"] * $sessionProduct["quantity"] , 2, ',', '.') :
                                    number_format(($sessionProduct['product']->price_excl * ($sessionProduct['product']->vat / 100) + $sessionProduct['product']->price_excl) * $sessionProduct['quantity'], 2, ',', '.')
                                }}
                            </td>
                            <td>
                                <form action="{{ route('admin.orders.delete.product', $sessionProduct['product']) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="bg-transparent border-0"><i class="fa-solid fa-circle-xmark text-danger"></i></button>
                                </form>
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
                <button type="button" class="btn btn-link text-end mb-3 pe-0" data-bs-toggle="modal" data-bs-target="#modalProducts">
                    + Product toevoegen
                  </button>
                <div class="ms-auto mb-3">
                    <p><b>Prijs exclusief BTW:</b> &euro; {{ number_format($subtotal, 2, ',', '.') }}</p>
                    <p><b>BTW:</b> &euro; {{ number_format($vat, 2, ',', '.') }}</p>
                    <p><b>Totaal prijs:</b> &euro; {{ number_format($total, 2, ',', '.') }}</p>
                </div>
                @else
                    <h2>Er zijn op dit moment nog geen producten toegevoegd</h2>
                    <button type="button" class="btn btn-link text-end mb-3 pe-0" data-bs-toggle="modal" data-bs-target="#modalProducts">
                        + Product toevoegen
                      </button>
                @endif
                <div class="ms-auto">
                    <a href="{{ route('admin.orders.create.customer') }}" class="btn btn-link text-dark">Stap terug</a>
                    <a href="{{ route('admin.orders.create.confirm') }}" class="btn btn-success">Volgende stap</a>
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