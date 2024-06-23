<form id="eval-form" action="{{ route('evaluasi.perbarui') }}" method="post" enctype="multipart/form-data"
  accept-charset="utf-8">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <input id="id" name="id" type="hidden" value="{{ $eval->id }}" required="required">
  <div class="row mb-2">
    <div class="col-12 mb-1">
      Nama
    </div>
    <div class="col-12">
      <h5>{{ $eval->pegawai->name }}</h5>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-12 mb-1">
      PSC Tahun Lalu
    </div>
    <div class="col-12">
      <h5>-</h5>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-12 mb-1">
      PSC Sementara
    </div>
    <div class="col-12">
      <h5>{{ $eval->pscSementara ? $eval->pscSementara->name : '-' }}</h5>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-12 mb-1">
      Hasil Supervisi
    </div>
    <div class="col-12">
      <h5>{{ $eval->supervision_result ? $eval->supervision_result : '-' }}</h5>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-12 mb-1">
      Hasil Interview
    </div>
    <div class="col-12">
      <h5>{{ $eval->interview_result ? $eval->interview_result : '-' }}</h5>
    </div>
  </div>
  <hr>
  <div class="row mb-2">
    <div class="col-12">
      <h6 class="font-weight-bold text-brand-green">Rekomendasi</h6>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <div class="row">
          <div class="col-12">
            <label class="form-control-label" for="recommendOpt">Kelanjutan <span class="text-danger">*</span></label>
          </div>
          <div class="col-12">
            @foreach ($rekomendasi as $r)
              <div class="custom-control custom-radio custom-control-inline">
                <input class="custom-control-input" id="recommendOpt{{ $r->id }}" name="recommend_status"
                  type="radio" value="{{ $r->id }}"
                  {{ $eval->recommend_status_id == $r->id ? 'checked' : '' }} required="required">
                <label class="custom-control-label"
                  for="recommendOpt{{ $r->id }}">{{ ucwords($r->status) }}</label>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="status" style="{{ $eval->recommend_status_id == 1 ? '' : 'display: none;' }}">
    <div class="col-12">
      <div class="form-group">
        <div class="row">
          <div class="col-12">
            <label class="form-control-label" for="statusOpt">Status <span class="text-danger">*</span></label>
          </div>
          <div class="col-12">
            @foreach ($status as $s)
              <div class="custom-control custom-radio mb-1">
                <input class="custom-control-input" id="statusOpt{{ $s->id }}" name="employee_status"
                  type="radio" value="{{ $s->id }}"
                  {{ $eval->recommend_employee_status_id == $s->id ? 'checked' : '' }}
                  {{ $eval->recommend_status_id == 1 ? 'required="required"' : '' }}>
                <label class="custom-control-label" for="statusOpt{{ $s->id }}">{{ $s->status }}</label>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="reason" style="{{ $eval->recommend_status_id == 2 ? '' : 'display: none;' }}">
    <div class="col-12">
      <div class="form-group">
        <div class="row">
          <div class="col-12">
            <label class="form-control-label" for="statusOpt">Alasan <span class="text-danger">*</span></label>
          </div>
          <div class="col-12">
            @foreach ($alasan as $a)
              <div class="custom-control custom-radio mb-1">
                <input class="custom-control-input" id="reasonOpt{{ $a->id }}" name="reason" type="radio"
                  value="{{ $a->id }}" {{ $eval->dismissal_reason_id == $a->id ? 'checked' : '' }}
                  {{ $eval->recommend_status_id == 2 ? 'required="required"' : '' }}>
                <label class="custom-control-label" for="reasonOpt{{ $a->id }}">{{ $a->reason }}</label>
              </div>
            @endforeach
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
      <input class="btn btn-brand-green-dark" type="submit" value="Simpan">
    </div>
  </div>
</form>

<script>
  $('input[name="recommend_status"]').on('change', function() {
    var recommend = $(this).val();
    if (recommend == '1') {
      $('input[name="employee_status"]').prop("required", true);
      $('input[name="reason"]').prop("required", false);
      $('#reason').hide();
      $('#status').fadeIn('normal');
    } else {
      $('input[name="employee_status"]').prop("required", false);
      $('input[name="reason"]').prop("required", true);
      $('#status').hide();
      $('#reason').fadeIn('normal');
    }
  });
</script>
