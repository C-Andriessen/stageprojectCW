  <div class="modal fade" id="edit{{$category->id}}Modal" tabindex="-1" aria-labelledby="edit{{$category->id}}ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="edit{{$category->id}}ModalLabel">Categorie aanpassen</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.category.update', $category) }}" id="edit{{$category->id}}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="name" class="form-label">Naam</label>
                    <input type="text" class="form-control @error('name' . $category->id) is-invalid @enderror" id="name" name="name{{ $category->id }}" value="{{ old('name', $category->name) }}">
                    @error('name' . $category->id)
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <input type="hidden" value="true" name="edit">
                  <input type="hidden" name="id" value="{{ $category->id }}">
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" form="edit{{$category->id}}" class="btn btn-success">Aanpassen</button>
        </div>
      </div>
    </div>
  </div>

  @if(old('edit') && old('id') == $category->id)
    <script>
        $(document).ready(function () {
            $('#edit' + {{ old('id') }} + 'Modal').modal('show')
        })
    </script>
@endif