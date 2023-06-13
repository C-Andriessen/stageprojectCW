@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-admin-menu :page="'producten'" />
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">{{ __('Product toevoegen') }}</h1>
            <div class="card mb-5">

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <x-errored-label for="name" :value="__('Naam')" :field="'name'" />
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="name" autofocus value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <x-errored-label for="description" :value="__('Beschrijving')" :field="'description'" />
                            <div class="medium-editor">
                                <textarea class="form-control large" id="editor" rows="7" name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <x-errored-label for="price_excl" :value="__('Prijs exclusief')" :field="'price_excl'" />
                                <input type="string" name="price_excl" class="form-control" value="{{ old('price_excl') }}" onchange="this.value = this.value.replace(/,/g, '.')">
                            </div>
                            <div class="col">
                                <x-errored-label for="discount_price" :value="__('Kortingsprijs')" :field="'discount_price'" />
                                <input type="string" name="discount_price" class="form-control" value="{{ old('discount_price') }}" onchange="this.value = this.value.replace(/,/g, '.')">
                            </div>
                            <div class="col">
                                <x-errored-label for="vat" :value="__('BTW')" :field="'vat'" />
                                <input type="string" name="vat" class="form-control" value="{{ old('vat') }}">
                            </div>
                            <div class="mb-3">
                                <x-errored-label for="image" :value="__('Afbeelding')" :field="'image'" />
                                <input class="form-control" type="file" id="input" name="image">
                            </div>
                            <div class="d-flex mb-2" id="preview">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.products.index') }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                            <button class="btn btn-success mb-3">Product opslaan</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{ asset('/js/editor.js') }}" defer></script>
@endsection