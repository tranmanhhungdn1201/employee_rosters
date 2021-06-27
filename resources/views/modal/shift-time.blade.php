<div class="modal fade" id="shift-time-modal" tabindex="-1" role="dialog" aria-labelledby="shift-time-modal." aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="shift-time-form" class="mb-0">
        <div class="modal-body">
          <input type="hidden" class="form-control" name="shift_time"/>
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Thời gian bắt đầu</label>
            <div class="col-4">
              <div class="input-group date" id="shift_start" data-target-input="nearest">
                <input type="text" placeholder="hh:mm" class="form-control datetimepicker-input" name="shift_start" data-target="#shift_start" data-toggle="datetimepicker" required pattern="^\d\d:\d\d$">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button" data-target="#shift_start" data-toggle="datetimepicker"><i class="fas fa-clock"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Thời gian kết thúc</label>
            <div class="col-4">
              <div class="input-group date" id="shift_finish" data-target-input="nearest">
                <input type="text" placeholder="hh:mm" class="form-control datetimepicker-input" name="shift_finish" data-target="#shift_finish" data-toggle="datetimepicker" required pattern="^\d\d:\d\d$">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button" data-target="#shift_finish" data-toggle="datetimepicker"><i class="fas fa-clock"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-group row">
              <label class="col-4"><span class="text-danger">*</span>&nbsp;Bộ phận</label>
              <div class="col-4">
                <select name="type" class="form-control">
                  @foreach ($userTypes as $userType)
                  <option value="{{$userType->id}}">{{$userType->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btn-save-shift-time">Lưu</button>
          <button type="button" class="btn btn-danger" id="btn-del-shift">Xóa</button>
          <button type="button" class="btn btn-dark" data-dismiss="modal">Đóng</button>
        </div>
      </form>
    </div>
  </div>
</div>