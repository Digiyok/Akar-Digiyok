<form action="{{ route($route.'.update') }}" id="edit-data-form" method="post" enctype="multipart/form-data" accept-charset="utf-8">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <input id="id" type="hidden" name="id" required="required" value="{{ $data->id }}">
  <div class="row">
    <div class="col-lg-10 col-md-12">
      <div class="form-group">
        <div class="row mb-3">
          <div class="col-lg-3 col-md-4 col-12">
            <label for="editDesc" class="form-control-label">Nama Proposal</label>
          </div>
          <div class="col-lg-9 col-md-8 col-12">
            @if(!$data->anggaran)
            <input type="text" id="editTitle" class="form-control form-control-sm @error('editTitle') is-invalid @enderror" name="editTitle" maxlength="100" required="required" value="{{ $data->title ? $data->title : '' }}">
            <small class="form-text text-muted">Maksimal 100 karakter</small>
            @else
            {{ $data->title ? $data->title : '' }}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-10 col-md-12">
      <div class="form-group">
        <div class="row mb-3">
          <div class="col-lg-3 col-md-4 col-12">
            <label for="normal-input" class="form-control-label">Deskripsi</label>
          </div>
          <div class="col-lg-9 col-md-8 col-12">
            <textarea id="editDesc" class="form-control form-control-sm @error('editDesc') is-invalid @enderror" name="editDesc" maxlength="180" rows="2">{{ $data->desc ? $data->desc : '' }}</textarea>
            <small class="form-text text-muted">Opsional. Maksimal 180 karakter.</small>
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
      <button type="button" class="btn btn-light" data-dismiss="modal">Kembali</button>
    </div>
    <div class="col-6 text-right">
      <input id="save-data" type="submit" class="btn btn-brand-green-dark" value="Simpan">
    </div>
  </div>
</form>

@include('template.footjs.kepegawaian.tooltip')