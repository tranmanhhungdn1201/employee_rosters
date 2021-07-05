<div class="modal fade" id="confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Xác nhận</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Bạn có muốn xóa không?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-close-confirm">Đóng</button>
        <button type="button" class="btn btn-danger" id="delete-btn">Xóa</button>
      </div>
    </div>
  </div>
</div>
<script>
  $( document ).ready(function() {
      $('.btn-close-confirm').click(function(){
        $('#confirm').modal('hide');
      })
  });
</script>