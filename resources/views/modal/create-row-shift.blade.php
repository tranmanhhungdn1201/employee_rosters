<div class="modal fade" id="create-row-shift" tabindex="-1" role="dialog" aria-labelledby="create-row-shift." aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thông tin ca</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="shift-form">
          <div class="form-group row">
            <label class="col-4">Bộ phận:</label>
            <select name="type" class="form-control col-4">
              <option value="0">Lễ Tân</option>
              <option value="1">Phục vụ</option>
              <option value="2">Giữ xe</option>
            </select>
          </div>
          <div class="form-group row">
            <label class="col-4">Thời gian bắt đầu:</label>
            <input type="time" class="form-control col-4" name="shift_start"/>
          </div>
          <div class="form-group row">
            <label class="col-4">Thời gian kết thúc:</label>
            <input type="time" class="form-control col-4" name="shift_finish"/>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 2</label>
            <input type="number" class="form-control col-4" value="0" name="day_0"></input>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 3</label>
            <input type="number" class="form-control col-4" value="0" name="day_1"></input>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 4</label>
            <input type="number" class="form-control col-4" value="0" name="day_2"></input>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 5</label>
            <input type="number" class="form-control col-4" value="0"name="day_3"></input>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 6</label>
            <input type="number" class="form-control col-4" value="0" name="day_4"></input>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 7</label>
            <input type="number" class="form-control col-4" value="0" name="day_5"></input>
          </div>
          <div class="form-group row">
            <label class="col-4">Chủ nhật</label>
            <input type="number" class="form-control col-4" value="0" name="day_6"></input>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="btn-add-row">Lưu</button>
        <button type="button" class="btn btn-danger" id="btn-del-row">Xóa</button>
      </div>
    </div>
  </div>
</div>