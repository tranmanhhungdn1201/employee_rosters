<?php
  $disabled = $roster->status === Config::get('constants.status_roster.CLOSE') ? true : false;
?>
<div class="modal fade" id="shift-modal" tabindex="-1" role="dialog" aria-labelledby="shift-modal." aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title" id="exampleModalLabel">Thông tin ca</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="shift-form">
          <div class="form-group row">
            <label class="col-4">Số lượng:</label>
            <input type="number" class="form-control col-4 amount" value="2" name="" disable="{{$disabled}}"/>
          </div>
          <div class="form-group row">
            <label class="col-4">Trạng thái:</label>
            <select name="status" class="form-control status col-4" disable="{{$disabled}}">
              <option value="1">Trống</option>
              <option value="2">Đầy</option>
              <option value="3">Khóa</option>
            </select>
          </div>
          <div class="form-group">
            <label>Người đăng ký:</label>
            <table class="table table-bordered table-sm">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Tên</th>
                  <th scope="col">Ngày đăng ký</th>
                  <th scope="col">Ghi chú</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        @if(empty($disabled))
          <button type="button" class="btn btn-primary" id="btn-save-shift">Lưu</button>
        @endif
        <button type="button" class="btn btn-dark" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>