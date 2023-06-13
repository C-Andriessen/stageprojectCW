  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createModalLabel">Categorie toevoegen</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.category.store') }}" id="create" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Naam</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" name="name">
                    @error('name')
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