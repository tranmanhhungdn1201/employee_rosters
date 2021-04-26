<div class="modal fade" id="shift-time-modal" tabindex="-1" role="dialog" aria-labelledby="shift-time-modal." aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form id="shift-time-form">
          <input type="hidden" class="form-control" name="shift_time"/>
          <div class="form-group row">
            <label class="col-4">Thời gian bắt đầu:</label>
            <input type="time" class="form-control col-4" name="shift_start"/>
          </div>
          <div class="form-group row">
            <label class="col-4">Thời gian kết thúc:</label>
            <input type="time" class="form-control col-4" name="shift_finish"/>
          </div>
          <div class="form-group">
            <div class="form-group row">
              <label class="col-4">Bộ phận:</label>
              <select name="type" class="form-control col-4">
                <option value="0">Lễ Tân</option>
                <option value="1">Phục vụ</option>
                <option value="2">Giữ xe</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save-shift-time">Lưu</button>
        <button type="button" class="btn btn-danger" id="btn-del-shift">Xóa</button>
        <button type="button" class="btn btn-dark" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>