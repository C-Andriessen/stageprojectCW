<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createModalLabel">Accessoire toevoegen</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.products.accessories.store', $product) }}" id="create" method="post">
                @csrf
                <div class="mb-3">
                    <label for="accessoryName" class="form-label">Naam</label>
                    <input type="text" class="form-control @error('accessoryName') is-invalid @enderror" id="accessoryName" value="{{ old('accessoryName') }}" name="accessoryName">
                    @error('accessoryName')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="accessoryPrice" class="form-label">Prijs</label>
                    <input type="number" class="form-control @error('accessoryPrice') is-invalid @enderror" id="accessoryPrice" value="{{ old('accessoryPrice') }}" name="accessoryPrice">
                    @error('accessoryPrice')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="accessoryDiscount_price" class="form-label">Kortingsprijs</label>
                    <input type="number" class="form-control @error('accessoryDiscount_price') is-invalid @enderror" id="accessoryDiscount_price" value="{{ old('accessoryDiscount_price') }}" name="accessoryDiscount_price">
                    @error('accessoryDiscount_price')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="accessoryVat" class="form-label">BTW</label>
                    <input type="number" class="form-control @error('accessoryVat') is-invalid @enderror" id="accessoryVat" value="{{ old('accessoryVat') }}" name="accessoryVat">
                    @error('accessoryVat')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="accessoryCategory" class="form-label">Categorie</label>
                    <select class="form-select @error('accessoryCategory') is-invalid @enderror select2" name="accessoryCategory">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('accessoryCategory') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('accessoryCategory')
                    <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
                  <input type="hidden" value="true" name="create">
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="create" class="btn btn-success">Toevoegen</button>
        </div>
      </div>
    </div>
  </div>

@if(old('create'))
<script>
    $(document).ready(function () {
        $('#createModal').modal('show')
    })
</script>
@endif
<script>
    $(document).ready(function () {
    $(".select2").select2({
        dropdownParent: $('#createModal'),
        theme: 'bootstrap-5'
    });
});
</script>