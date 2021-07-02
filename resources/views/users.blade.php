@extends('master')
@section('content')

<div class="row mx-0">
  <div class="card">
    <div class="card-header">
      <div class="card-header__icon">
        <img alt="alt text" src="{!! asset('image/staff.svg') !!}">
        Danh sách nhân viên
      </div>
      <div class="card-header__action">
        <a href="#" class="btn btn-success create-user">
          <i class="fas fa-plus"></i>
          Tạo mới nhân viên
        </a>
      </div>
    </div>
    <div class="card-body">
      <div class="datatable-custom">
        <div class="form-group datatable-custom__search">
          <label for="search" class="col-form-label">Tìm kiếm</label>
          <div class="datatable-custom__search__input">
            <input type="text" class="form-control" id="search" placeholder="Tìm kiếm">
          </div>
        </div>
        <table id="users-table" class="table display responsive nowrap">
          <thead>
            <th>ID</th>
            <th>Tên</th>
            <th>Họ Tên</th>
            <th>Chức vụ</th>
            <th>Số điện thoại</th>
            <th>Ngày làm</th>
            <th>Nhà hàng</th>
            <th>Action</th>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@include('modal.create-user');
@include('modal.delete-confirm-modal');
<script type="text/javascript">
  let isAdmin = "{{auth()->user()->isAdmin()}}";
  let table = $('#users-table').DataTable({
      processing: false,
      searching: true,
      lengthChange: false,
      serverSide: true,
      language: LANGUAGE,
      ajax: '{!! route('getUserListDatatables') !!}',
      autoWidth: false,
      columns: [
          { data: 'id', name: 'id' },
          { data: 'first_name', name: 'first_name' },
          { data: 'last_name', name: 'last_name' },
          { data: 'user_type.name', name: 'user_type.name' },
          { data: 'phone', name: 'phone' },
          { data: 'hire_date', name: 'hire_date' },
          { data: 'branch.name', name: 'branch.name' },
          { data: 'action', name: 'action' },
      ]
  });

  $('.create-user').click(function(){
    $('#user-form').trigger('reset');
    if(!isAdmin) {
      $('#user-form').find('[name="type"] option').filter(':eq(0), :eq(1)').attr('disabled', true);
    }
    $('#user-form').find('.modal-title').val('Tạo mới tài khoản');
    $('#create-user-modal').modal('show');
  })

  $('#btn-save-user').click(function(){
    let userId= $('#user-form [name="user_id"]').val();
    if(userId)
    editNewUser();
    else 
    createNewUser();
  })

  function editNewUser(){
    const url = "{{route('editUser')}}";
    let data = $('#user-form').serializeArray();
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
              table.ajax.reload();
            } else {
              toastr.error(res.Message);
            }
            $('#create-user-modal').modal('hide');
        },
        error: function(err) {
            toastr.error('Error!');
            console.error(err.message);
        }
    }
    $.ajax(options);
  }

  function createNewUser(){
    const url = "{{route('createUser')}}";
    let data = $('#user-form').serializeArray();
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
              table.ajax.reload();
            } else {
              toastr.error(res.Message);
            }
            $('#create-user-modal').modal('hide');
        },
        error: function(err) {
            console.error(err.message);
        }
    }
    $.ajax(options);
  }

  $('#search').on('keyup', debounce(function () {
    table.search(this.value).draw();
  }, 300));

  $('table').on('click', '.btn-edit', function() {
    let dataUser = table.row($(this).closest('tr')).data();
    showEditUser(dataUser);
  })

  function showEditUser(data) {
    let userForm = $('#user-form');
    userForm.trigger('reset');
    console.log(data);
    userForm.find('[name="user_id"]').val(data.id);
    userForm.find('[name="type"]').val(data.user_type_id);
    userForm.find('[name="branch_id"]').val(data.branch.id);
    userForm.find('[name="username"]').val(data.username);
    userForm.find('[name="first_name"]').val(data.first_name);
    userForm.find('[name="last_name"]').val(data.last_name);
    userForm.find('[name="sex"]').filter('[value="'+ data.gender +'"]').click();
    userForm.find('[name="birth_date"]').val(data.birth_date);
    userForm.find('[name="phone"]').val(data.phone);
    userForm.find('.modal-title').val('Chỉnh sửa tài khoản');
    $('#create-user-modal').modal('show');
  }

  $('table').on('click', '.btn-remove', function() {
    let userID = table.row($(this).closest('tr')).data().id;
    removeUser(userID);
  })

  function removeUser(userID) {
    $('#confirm').modal('show');
    $('#confirm').on('shown.bs.modal', function (e) {
      $('#delete-btn').click(function(){
        let url = "{{route('deleteUser', ':id')}}";
        url = url.replace(':id', userID);
        const options = {
          url,
          method: 'POST',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
          },
          success: function(res) {
              if(res.Status === 'Success') {
                toastr.success(res.Message);
                table.ajax.reload();
              } else {
                toastr.error(res.Message);
              }
              $('#confirm').modal('hide');
          },
          error: function(err) {
              console.error(err.message);
          }
        }
        $.ajax(options);
      })
    })
  }
</script>
@endsection