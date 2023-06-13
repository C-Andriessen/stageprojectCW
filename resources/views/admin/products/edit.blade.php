@extends('layouts.app')

@section('content')
@include('includes.modals.accessory.create')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-admin-menu :page="'producten'" />
            <h2 class="mt-5">Product afbeelding</h2>
            <img src="/product_images/{{ $product->image }}" class="img-thumbnail mt-3" alt="...">
        </div>
        <div class="col-md-9">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h1>{{ __('Product bewerken') }}</h1>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
                        Accesoire toevoegen
                    </button>
                </div>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @if(old('editA'))
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="false">Algemeen</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-dark active" id="accessory-tab" data-bs-toggle="tab" data-bs-target="#accessory-tab-pane" type="button" role="tab" aria-controls="accessory-tab-pane" aria-selected="true">Accessoires</button>
                </li>
                @else
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="false">Algemeen</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-dark" id="accessory-tab" data-bs-toggle="tab" data-bs-target="#accessory-tab-pane" type="button" role="tab" aria-controls="accessory-tab-pane" aria-selected="true">Accessoires</button>
                </li>
                @endif
              </ul>
            <div class="card mb-5">

                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        @if(old('editA'))
                            <div class="tab-pane fade" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                        @else
                            <div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                        @endif
                            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="mb-3">
                                    <x-errored-label for="name" :value="__('Naam')" :field="'name'" />
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name" autofocus value="{{ old('name', $product->name) }}">
                                </div>
                                <div class="mb-3">
                                    <x-errored-label for="description" :value="__('Beschrijving')" :field="'description'" />
                                    <div class="medium-editor">
                                        <textarea class="form-control large" id="editor" rows="7" name="description">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <x-errored-label for="price_excl" :value="__('Prijs exclusief')" :field="'price_excl'" />
                                        <input type="string" name="price_excl" class="form-control" value="{{ old('price_excl', $product->price_excl) }}" onchange="this.value = this.value.replace(/,/g, '.')">
                                    </div>
                                    <div class="col">
                                        <x-errored-label for="discount_price" :value="__('Kortingsprijs')" :field="'discount_price'" />
                                        <input type="string" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price) }}" onchange="this.value = this.value.replace(/,/g, '.')">
                                    </div>
                                    <div class="col">
                                        <x-errored-label for="vat" :value="__('BTW')" :field="'vat'" />
                                        <input type="string" name="vat" class="form-control" value="{{ old('vat', $product->vat) }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <x-errored-label for="image" :value="__('Afbeelding')" :field="'image'" />
                                    <input class="form-control" type="file" id="input" name="image">
                                </div>
                                <div class="d-flex mb-2" id="preview">
                                </div>
        
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.products.index') }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                                    <button class="btn btn-success mb-3">Product opslaan</button>
                                </div>
                            </form>
                        </div>
                        @if(old('editA'))
                            <div class="tab-pane fade show active" id="accessory-tab-pane" role="tabpanel" aria-labelledby="accessory-tab" tabindex="0">
                        @else
                            <div class="tab-pane fade" id="accessory-tab-pane" role="tabpanel" aria-labelledby="accessory-tab" tabindex="0">
                        @endif
                            @foreach($product->accessories->unique('category_id') as $category)
                                <h4>{{ $category->category->name }}</h4>
                                <table class="table table-striped mb-3">
                                    <thead>
                                        <tr>
                                            <th>Naam</th>
                                            <th>Prijs</th>
                                            <th>Kortingsprijs</th>
                                            <th>BTW</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product->accessories->where('category_id', $category->category_id) as $accessory)
                                        <tr>
                                            <td>{{ $accessory->name }}</td>
                                            <td>&euro; {{ $accessory->price }}</td>
                                            <td>&euro; {{$accessory->discount_price ? $accessory->discount_price : '-' }}</td>
                                            <td>{{ $accessory->vat }}%</td>
                                            <td>
                                                <button type="button" class="btn btn-link text-decoration-none text-dark p-0" data-bs-toggle="modal" data-bs-target="#edit{{ $accessory->id }}Modal">
                                                    Bewerken
                                                </button>
                                                @include('includes.modals.accessory.edit')
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.products.accessories.destroy', [$product, $accessory]) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Weet je zeker dat je &#8220;{{ $accessory->name }}&#8221; wilt verwijderen?')" class="btn btn-link text-decoration-none text-dark p-0">Verwijderen</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{ asset('/js/editor.js') }}" defer></script>
@endsection