<div class="modal fade" id="confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{__('app.Title.Modal.Confirm delete')}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>{{__('app.Notification.Are you delete')}}</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default btn-close-confirm">{{__('app.Close')}}</button>
        <button type="button" class="btn btn-danger" id="delete-btn">{{__('app.Delete button')}}</button>
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