@extends('master')
@include('header')
@section('content')

<div class="container container-content">
  <div class="action">
    <a href="#" class="btn btn-info create-user">Create user</a>
  </div>
	<div class="row">
      <div class="col-md-12">
        <h4>Danh sách nhân viên</h4>
        <div class="mb-2 mt-2">
          <input type="text" class="form-control" id="search" placeholder="Tìm kiếm">
        </div>
          <table id="users-table" class="table table-bordred table-striped">
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
@include('modal.create-user');
<script type="text/javascript">
  let table = $('#users-table').DataTable({
      processing: false,
      searching: true,
      lengthChange: false,
      serverSide: true,
      language: LANGUAGE,
      ajax: '{!! route('getUserListDatatables') !!}',
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