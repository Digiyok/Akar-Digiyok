<script>
  function finishModal(route, id, modal = null) {
    var modalId = '#finish-form';
    if (modal) modalId = modal;

    $(modalId + ' .modal-load').show();
    $(modalId + ' .modal-body').hide();

    $.post(route, {
        '_token': $('meta[name=csrf-token]').attr('content'),
        id: id
      },
      function(response) {
        $(modalId + ' .modal-body').html(response);
        $(modalId + ' .modal-load').hide();
        $(modalId + ' .modal-body').show();
      });
  }
</script>
