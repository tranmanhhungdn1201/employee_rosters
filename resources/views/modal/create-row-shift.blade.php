<div class="modal fade" id="create-row-shift" tabindex="-1" role="dialog" aria-labelledby="create-row-shift." aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thông tin ca</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="shift-form">
      <div class="modal-body">
      
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Bộ phận</label>
            <div class="col-4">
              <select name="type" class="form-control" required>
                @foreach ($userTypes as $userType)
                  <option value="{{$userType->id}}">{{$userType->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
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
          <div class="form-group row">
            <label class="col-4">Thứ 2</label>
            <div class="col-4">
              <input type="number" class="form-control" value="0" name="day_0" min="0" max="10">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 3</label>
            <div class="col-4">
              <input type="number" class="form-control" value="0" name="day_1" min="0" max="10">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 4</label>
            <div class="col-4">
              <input type="number" class="form-control" value="0" name="day_2" min="0" max="10">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 5</label>
            <div class="col-4">
              <input type="number" class="form-control" value="0"name="day_3" min="0" max="10">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 6</label>
            <div class="col-4">
              <input type="number" class="form-control" value="0" name="day_4" min="0" max="10">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-4">Thứ 7</label>
            <div class="col-4">
              <input type="number" class="form-control" value="0" name="day_5" min="0" max="10">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-4">Chủ nhật</label>
            <div class="col-4">
              <input type="number" class="form-control" value="0" name="day_6" min="0" max="10">
            </div>
          </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary mr-3" data-dismiss="modal">Đóng</button>
        <button type="submit" class="btn btn-success" id="btn-add-row">Lưu</button>
        <button type="button" class="btn btn-danger ml-3" id="btn-del-row">Xóa</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    $('#create-row-shift').on('shown.bs.modal', function() { 
       $('#shift-form').trigger('reset');
    });
    /**** format datepicker ****/

    // start time of shift
    $('#shift_start').datetimepicker({
      locale: "vi",
      format: 'HH:mm'
    });
   
    // finish time of shift
    $('#shift_finish').datetimepicker({
      locale: "vi",
      format: 'HH:mm'
    });
  });
</script>