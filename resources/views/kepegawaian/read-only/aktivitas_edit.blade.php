<form id="edit-data-form" action="{{ route($route . '.update') }}" method="post" enctype="multipart/form-data"
  accept-charset="utf-8">
  {{ csrf_field() }}
  {{ method_field('PUT') }}

  <input id="id" name="id" type="hidden" value="{{ $data->id }}" required="required">
  <input id="department_id" name="department_id" type="hidden" value="{{ $data->department_id }}" required="required">

  <div class="row">
    <div class="col-lg-10 col-md-12">
      <div class="form-group">
        <div class="row mb-3">
          <div class="col-lg-3 col-md-4 col-12">
            <label class="form-control-label" for="normal-input">Nama</label>
          </div>
          <div class="col-lg-9 col-md-8 col-12">
            <input class="form-control form-control-sm @error('editName') is-invalid @enderror" id="editName"
              name="editName" type="text" value="{{ old('editName', $data->name) }}" maxlength="255"
              required="required">
            @error('editName')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-10 col-md-12">
      <div class="form-group">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-12">
            <label class="form-control-label" for="normal-input">Deskripsi</label>
          </div>
          <div class="col-lg-9 col-md-8 col-12">
            <textarea class="form-control form-control-sm @error('editDesc') is-invalid @enderror" id="inputEditDesc"
              name="editDesc" maxlength="255" rows="3" required="required">{{ old('editDesc', $data->desc) }}</textarea>
            @error('editDesc')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-6 text-left">
      <button class="btn btn-light" data-dismiss="modal" type="button">Kembali</button>
    </div>
    <div class="col-6 text-right">
      <input class="btn btn-primary" id="save-data" type="submit" value="Simpan">
    </div>
  </div>
</form>

<script>
  $('input[name="editActive"]').bootstrapToggle({
    width: 60
  });
</script>
