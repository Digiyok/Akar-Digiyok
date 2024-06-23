<form id="finish-data-form" action="{{ route($route . '.finish') }}" method="post" enctype="multipart/form-data"
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
            <label class="form-control-label" for="normal-input">Upload Gambar</label>
          </div>
          <div class="col-lg-7 col-md-8 col-12">
            @php
              $inputImageName = 'image';
            @endphp
            <img class="img-thumbnail photo-preview" id="previewEdit{{ ucwords($inputImageName) }}"
              src="{{ $data->{$inputImageName} ? asset($data->{$inputImageName . 'Path'}) : asset('img/avatar/default.png') }}">
            <input class="file image-input d-none" name="edit{{ ucwords($inputImageName) }}" type="file"
              accept="image/jpg,image/jpeg,image/png,image/webp">
            <div class="input-group mt-3">
              <input class="form-control form-control-sm @error('edit' . ucwords($inputImageName)) is-invalid @enderror"
                id="fileEdit{{ ucwords($inputImageName) }}" type="text" disabled placeholder="Unggah photo...">
              <div class="input-group-append">
                <button class="browse btn btn-sm btn-primary" type="button">Pilih</button>
              </div>
            </div>
            <small class="form-text text-muted">Ekstensi .jpg, .jpeg, .png, .webp. Maks 100
              KB.</small>
            @error($inputImageName)
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
