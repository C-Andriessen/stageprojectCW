<div class="modal fade" id="edit{{$accessory->id}}Modal" tabindex="-1" aria-labelledby="editModal{{$accessory->id}}Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModal{{$accessory->id}}Label">Accessoire aanpassen</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.products.accessories.update', [$product, $accessory]) }}" id="edit{{$accessory->id}}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="name" class="form-label">Naam</label>
                    <input type="text" class="form-control @error('name' . $accessory->id) is-invalid @enderror" id="name" value="{{ old('name' . $accessory->id, $accessory->name) }}" name="name{{ $accessory->id }}">
                    @error('name' . $accessory->id)
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Prijs</label>
                    <input type="number" class="form-control @error('price' . $accessory->id) is-invalid @enderror" id="price" value="{{ old('price' . $accessory->id, $accessory->price) }}" name="price{{ $accessory->id }}">
                    @error('price' . $accessory->id)
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="discount_price" class="form-label">Kortingsprijs</label>
                    <input type="number" class="form-control @error('discount_price' . $accessory->id) is-invalid @enderror" id="discount_price" value="{{ old('discount_price' . $accessory->id, $accessory->discount_price) }}" name="discount_price{{ $accessory->id }}">
                    @error('discount_price' . $accessory->id)
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="vat" class="form-label">BTW</label>
                    <input type="number" class="form-control @error('vat' . $accessory->id) is-invalid @enderror" id="vat" value="{{ old('vat' . $accessory->id, $accessory->vat) }}" name="vat{{ $accessory->id }}">
                    @error('vat' . $accessory->id)
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Categorie</label>
                    <select class="form-select @error('category' . $accessory->id) is-invalid @enderror select2-{{$accessory->id}}" name="category{{ $accessory->id }}">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category' . $accessory->id, $accessory->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category' . $accessory->id)
                    <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
                  <input type="hidden" value="true" name="editA">
                  <input type="hidden" value="{{ $accessory->id }}" name="id">
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="edit{{ $accessory->id }}" class="btn btn-success">Aanpassen</button>
        </div>
      </div>
    </div>
  </div>

@if(old('editA') && old('id') == $accessory->id)
  <script>
      $(document).ready(function () {
          $('#edit' + {{ old('id') }} + 'Modal').modal('show')
      })
  </script>
@endif
<script>
    $(document).ready(function () {
    $(".select2-" + {{$accessory->id}}).select2({
        dropdownParent: $('#edit' + {{ $accessory->id }} + 'Modal'),
        theme: 'bootstrap-5'
    });
});
</script>