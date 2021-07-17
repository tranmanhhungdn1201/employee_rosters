<div class="modal fade" id="create-user-modal" tabindex="-1" role="dialog" aria-labelledby="create-row-shift." aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tạo tài khoản</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="user-form">
      <div class="modal-body">
          <input type="hidden" name="user_id">
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Nhà hàng</label>
            <div class="col-5">
                <select name="branch_id" class="form-control" required>
                @foreach ($branches as $branch)
                  <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Chức vụ</label>
            <div class="col-5">
              <select name="type" class="form-control" required></select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Tên tài khoản</label>
            <div class="col-5"><input type="text" class="form-control" name="username" required/></div>
          </div>
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Mật khẩu</label>
            <div class="col-5"><input type="password" class="form-control" name="password" required/></div>
          </div>
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Tên</label>
            <div class="col-5"><input type="text" class="form-control" name="first_name" required/></div>
          </div>
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Họ</label>
            <div class="col-5"><input type="text" class="form-control" name="last_name" required/></div>
          </div>
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Giới tính</label>
            <div class="col-5">
              <div class="row mx-0">
                <div class="form-check mr-3">
                  <input type="radio" value="1" name="gender" id="sex-man" class="form-check-input" checked />
                  <label class="form-check-label" for="sex-man">
                    Nam
                  </label>
                </div>
                <div class="form-check">
                  <input type="radio" value="0" name="gender" id="sex-woman" class="form-check-input"/>
                  <label class="form-check-label" for="sex-woman">
                    Nữ
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-4"><span class="text-danger">*</span>&nbsp;Số điện thoại</label>
            <div class="col-5"><input type="text" class="form-control" name="phone" required pattern="((09|03|07|08|05)+([0-9]{8})\b)"/></div>
          </div>
          <div class="form-group row">
            <label class="col-4">Ngày sinh</label>
            <div class="col-5">
              <div class="input-group date" id="birth_date" data-target-input="nearest">
                <input type="text" placeholder="dd-mm-yyyy" class="form-control datetimepicker-input" name="birth_date" data-target="#birth_date" data-toggle="datetimepicker" value="">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button" data-target="#birth_date" data-toggle="datetimepicker"><i class="fas fa-calendar-alt"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-outline-secondary mr-4" data-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-success" id="btn-save-user">Lưu</button>
          </div>
      </div>
    </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    // birthday
    $('#birth_date').datetimepicker({
      format: 'YYYY-MM-DD',
      locale: 'vi',
    });

    const USER_TYPE = {!! json_encode($userTypes) !!};
    $('#create-user-modal').on('shown.bs.modal', function () {
      let branchID = $('select[name="branch_id"]').val();
      setDataType(branchID)
    })

    $('select[name="branch_id"]').on('change', function(){
      let branchID = $(this).val();
      setDataType(branchID)
    })

    function setDataType(branchID){
      let data = USER_TYPE.filter(item => item.branch_id === +branchID);
      let typeDOM = $('select[name="type"]');
      let content = data.map(type => `<option value="${type.id}">${type.name}</option>`);
      typeDOM.empty();
      typeDOM.append(content);
    }
  });
</script>
