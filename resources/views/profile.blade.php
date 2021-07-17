@extends('master')
@section('content')
<div class="row container-create-roster">
  <div class="container">
    <div class="row gutters-sm">
      <div class="col-md-4 d-none d-md-block">
        <div class="card">
          <div class="card-body">
            <nav class="nav flex-column nav-pills nav-gap-y-1">
              <a href="#profile" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded active">
                Cá nhân
              </a>
              <a href="#password" data-toggle="tab" class="btn-tab-account nav-item nav-link has-icon nav-link-faded">
                Đổi mật khẩu
              </a>
            </nav>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header border-bottom mb-3 d-flex d-md-none">
            <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
              <li class="nav-item">
                <a href="#profile" data-toggle="tab" class="nav-link has-icon active"><img alt="alt text" src="{!! asset('image/restaurant.svg') !!}" height="24" width="24"></a>
              </li>
              <li class="nav-item">
                <a href="#password" data-toggle="tab" class="btn-tab-password nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></a>
              </li>
            </ul>
          </div>
          <div class="card-body tab-content">
            {{-- profile --}}
            <div class="tab-pane active" id="profile">
              <div class="tab-header">
                <div class="tab-header__title">
                  <h6>THÔNG TIN CÁ NHÂN</h6>
                </div>
              </div>
              <hr>
              <div id="create-profile">
                  <?php
                   $data = auth()->user();
                  ?>
                <form id="form-profile">
                  <input type="hidden" name="user_id" value="{{ $data['id'] }}">
                  <div class="form-group">
                    <label for="name">Nhà hàng</label>
                    <input type="text" class="form-control" value="{{$data->branch_name}}" disabled>
                  </div>
                  <div class="form-group">
                    <label for="name">Tên tài khoản</label>
                    <input type="text" class="form-control" name="username" aria-describedby="name" placeholder="" value="{{$data->username}}" disabled>
                  </div>
                  <div class="form-group">
                    <label for="name"><span class="text-danger">*</span>&nbsp;Tên</label>
                    <input type="text" class="form-control" name="first_name" aria-describedby="name" placeholder="" value="{{$data->first_name}}" required>
                  </div>
                  <div class="form-group">
                    <label for="name"><span class="text-danger">*</span>&nbsp;Họ</label>
                    <input type="text" class="form-control" name="last_name" aria-describedby="name" placeholder="" value="{{$data->last_name}}" required>
                  </div>
                  <div class="form-group">
                    <label for="name"><span class="text-danger">*</span>&nbsp;Số điện thoại</label>
                    <input type="text" class="form-control" name="phone" aria-describedby="name" placeholder="" value="{{$data->phone}}" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Ngày sinh</label>
                    <div class="input-group date" id="birth_date" data-target-input="nearest">
                        <input type="text" placeholder="dd-mm-yyyy" class="form-control datetimepicker-input" name="birth_date" data-target="#birth_date" data-toggle="datetimepicker" value="{{$data->birth_date}}">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button" data-target="#birth_date" data-toggle="datetimepicker"><i class="fas fa-calendar-alt"></i></button>
                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="name">Ngày làm</label>
                    <input type="text" class="form-control" name="hire_date" aria-describedby="name" placeholder="" value="{{$data->hire_date}}" disabled>
                  </div>
                  <button type="button" class="btn btn-primary btn-save">Lưu</button>
                </form>
              </div>
            </div>
            {{-- change password --}}
            <div class="tab-pane" id="password">
              <div class="tab-header">
                <div class="tab-header__title">
                  <h6>ĐỔI MẬT KHẨU</h6>
                </div>
              </div>
              <hr>
                <form id="change-password">
                <div class="form-group">
                    <label for="name">Mật khẩu cũ</label>
                    <input type="password" class="form-control" name="old_password" aria-describedby="name" placeholder="" value="" required>
                </div>
                <div class="form-group">
                    <label for="description">Mật khẩu mới</label>
                    <input type="password" class="form-control" name="new_password" aria-describedby="name" placeholder="" value="" required>
                </div>
                <button type="submit" class="btn btn-primary btn-save">Lưu</button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    // birthday
    $('#birth_date').datetimepicker({
      format: 'YYYY-MM-DD',
      locale: 'vi',
    });
    $('#form-profile ').on('click', '.btn-save', function(e) {
        if (!checkValidateHTML('form-profile')) return;
        e.preventDefault();
        loading('show');
        const url = "{{route('editUser')}}";
        let data = $('#form-profile').serializeArray();
        let objData = arrDataToObject(data);
        const options = {
            url,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ...objData
            },
            success: function(res) {
                if(res.Status === 'Success') {
                toastr.success(res.Message);
                } else {
                toastr.error(res.Message);
                }
                loading('hide');
            },
            error: function(err) {
                toastr.error('Error!');
                console.error(err.message);
                loading('hide');
            }
        }
        $.ajax(options);
    })
    $('#change-password').on('click', '.btn-save', function(e) {
        if (!checkValidateHTML('change-password')) return;
        e.preventDefault();
        loading('show');
        const url = "{{route('changePassword')}}";
        let data = $('#change-password').serializeArray();
        let objData = arrDataToObject(data);
        const options = {
            url,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ...objData
            },
            success: function(res) {
                if(res.Status === 'Success') {
                    $('#change-password').trigger('reset');
                    toastr.success(res.Message);
                } else {
                    toastr.error(res.Message);
                }
                loading('hide');
            },
            error: function(err) {
                toastr.error('Error!');
                console.error(err.message);
                loading('hide');
            }
        }
        $.ajax(options);
    })
  });
</script>
@endsection
