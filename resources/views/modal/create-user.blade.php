<div class="modal fade" id="create-user-modal" tabindex="-1" role="dialog" aria-labelledby="create-row-shift." aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tạo tài khoản</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="user-form">
          <div class="form-group row">
            <label class="col-4">Chức vụ:</label>
            <select name="type" class="form-control col-4">
              <option value="0">Admin</option>
              <option value="0">Quản lý</option>
              <option value="1">Lễ tân</option>
              <option value="2">Phục vụ</option>
              <option value="3">Giữ xe</option>
            </select>
          </div>
          <div class="form-group row">
            <label class="col-4">Nhà hàng:</label>
            <select name="branch_id" class="form-control col-4">
              <option value="0">PapaSteak 2/9</option>
              <option value="1">PapaSteak Phan Thanh</option>
            </select>
          </div>
          <div class="form-group row">
            <label class="col-4">Tên tài khoản:</label>
            <input type="text" class="form-control col-4" name="username"/>
          </div>
          <div class="form-group row">
            <label class="col-4">Mật khẩu:</label>
            <input type="password" class="form-control col-4" name="password"/>
          </div>
          <div class="form-group row">
            <label class="col-4">Tên:</label>
            <input type="text" class="form-control col-4" name="first_name"/>
          </div>
          <div class="form-group row">
            <label class="col-4">Họ</label>
            <input type="text" class="form-control col-4" name="last_name"></input>
          </div>
          <div class="form-group row">
            <label class="col-4">Giới tính</label>
            <input type="radio" value="1" name="sex">Nam</input>
            <input type="radio" value="0" name="sex">Nữ</input>
          </div>
          <div class="form-group row">
            <label class="col-4">Số điện thoại</label>
            <input type="text" class="form-control col-4" name="phone"></input>
          </div>
          <div class="form-group row">
            <label class="col-4">Ngày sinh</label>
            <input type="date" class="form-control col-4"name="birth_date"></input>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="btn-add-user">Lưu</button>
        <button type="button" class="btn btn-danger" id="btn-del-user">Xóa</button>
      </div>
    </div>
  </div>
</div>