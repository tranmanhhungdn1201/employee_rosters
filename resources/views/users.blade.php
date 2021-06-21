@extends('master')
@include('header')
@section('content')

<div class="row container-user">
  <div class="col-sx-12 col-sm-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <div class="card-header__icon">
          <img alt="alt text" src="{!! asset('image/staff.svg') !!}">
        </div>
        Danh sách nhân viên
        <div class="card-header__action">
          <a href="#" class="btn btn-success create-user">
            <i class="fas fa-plus"></i>
            Create user
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="datatable-custom">
          <div class="form-group datatable-custom__search">
            <label for="search" class="col-form-label">Tìm kiếm:</label>
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
</div>
@include('modal.create-user');
<script type="text/javascript">
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
    $('#create-user-modal').modal('show');
  })

  $('#btn-add-user').click(function(){
    createNewUser();
  })

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
              table.ajax.reload();
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
</script>
@endsection