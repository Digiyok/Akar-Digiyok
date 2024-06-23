<div class="modal fade" id="ongoing-confirm" role="dialog" aria-labelledby="validateModalLabel" aria-hidden="true"
  tabindex="-1" style="display: none;">
  <div class="modal-dialog modal-confirm" role="document">
    <div class="modal-content">
      <div class="modal-header flex-column">
        <div class="icon-box border-success">
          <i class="material-icons text-success">&#xE5CA;</i>
        </div>
        <h4 class="modal-title w-100">Apakah Anda yakin?</h4>
        <button class="close" data-dismiss="modal" type="button" aria-hidden="true">&times;</button>
      </div>

      <div class="modal-body p-1">
        Apakah Anda yakin ingin mengubah status <span class="item font-weight-bold"></span> dari daftar <span
          class="title text-lowercase"></span> menjadi sedang dikerjakan?
      </div>

      <div class="modal-footer justify-content-center">
        <button class="btn btn-danger mr-1" data-dismiss="modal" type="button">Tidak</button>
        <form id="ongoing-link" action="#" method="post">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
          <button class="btn btn-primary" type="submit">Ya, Ubah</button>
        </form>
      </div>
    </div>
  </div>
</div>
