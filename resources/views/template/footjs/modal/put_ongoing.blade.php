<script>
  function ongoingModal(title, item, url) {
    $('#ongoing-confirm').modal('show', {
      backdrop: 'static',
      keyboard: false
    });
    $("#ongoing-confirm .title").text(title);
    $("#ongoing-confirm .item").text(item);
    $('#ongoing-link').attr("action", url);
  }
</script>
