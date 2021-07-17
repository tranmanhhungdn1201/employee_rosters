@extends('master')
@section('content')
<div class="row container-create-roster">
  <div class="container">
    <div class="row gutters-sm">
      <div class="col-md-4 d-none d-md-block">
        <div class="card">
          <div class="card-body">
            <nav class="nav flex-column nav-pills nav-gap-y-1">
              <a href="#branch" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded active">
                <img alt="alt text" src="{!! asset('image/restaurant.svg') !!}" height="24" width="24">
                Nhà hàng
              </a>
              <a href="#account" data-toggle="tab" class="btn-tab-account nav-item nav-link has-icon nav-link-faded">
                <img alt="alt text" src="{!! asset('image/user_type.svg') !!}" height="24" width="24">
                Bộ phận
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
                <a href="#branch" data-toggle="tab" class="nav-link has-icon active"><img alt="alt text" src="{!! asset('image/restaurant.svg') !!}" height="24" width="24"></a>
              </li>
              <li class="nav-item">
                <a href="#account" data-toggle="tab" class="btn-tab-account nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></a>
              </li>
            </ul>
          </div>
          <div class="card-body tab-content">
            {{-- branch --}}
            <div class="tab-pane active" id="branch">
              <div class="tab-header">
                <div class="tab-header__title">
                  <h6>DANH SÁCH NHÀ HÀNG</h6>
                </div>
                <div class="tab-header__action">
                  <a href="#" class="btn btn-success btn-create-branch">
                    <i class="fas fa-plus"></i>
                    Tạo mới
                  </a>
                </div>
              </div>
              <hr>
              <div id="create-branch" style="display: none;">
                <form id="form-branch">
                  <input type="hidden" name="branch_id" value="">
                  <div class="form-group">
                    <label for="name">Tên</label>
                    <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="" value="" required>
                  </div>
                  <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea class="form-control autosize" name="description" placeholder="" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 62px;"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary btn-save">Lưu</button>
                  <button type="reset" class="btn btn-light">Đóng</button>
                </form>
                <hr>
              </div>
              <ul class="list-group">
                @foreach($branches as $branch)
                  <li href="#" class="list-group-item text-left">
                    <div class="branch-item branch_{{$branch->id}}">
                      <div>
                        <h6 class="name">
                          {{ $branch->name }}
                        </h6>
                        <small id="usernameHelp" class="form-text text-muted">{{ $branch->description }}</small>
                      </div>
                      <label class="pull-right">
                          <a class="btn btn-success btn-sm glyphicon glyphicon-ok btn-edit" href="#" title="View" data-data="{{$branch}}"><i class="fas fa-edit"></i></a>
                          <a class="btn btn-danger  btn-sm glyphicon glyphicon-trash btn-remove" href="#" title="Delete" data-id="{{$branch->id}}"><i class="fas fa-trash"></i></a>
                      </label>
                    </div>
                    <div class="break"></div>
                  </li>
                @endforeach
              </ul>

            </div>
            {{-- user type --}}
            <div class="tab-pane" id="account">
              <div class="tab-header">
                <div class="tab-header__title">
                  <h6>BỘ PHẬN</h6>
                </div>
                <div class="tab-header__action">
                  <a href="#" class="btn btn-success btn-create-user-type">
                    <i class="fas fa-plus"></i>
                    Tạo mới
                  </a>
                </div>
              </div>
              <hr>
                <div class="form-group">
                  <label for="username">Nhà hàng</label>
                  <select class="form-control branch-select">
                  </select>
                </div>
                <hr>
                <div id="create-user-type" style="display: none;">
                  <form id="form-user-type">
                    <input type="hidden" name="branch_id" value="">
                    <input type="hidden" name="usertype_id" value="">
                    <div class="form-group">
                      <label for="name">Tên</label>
                      <input type="text" class="form-control" name="name" aria-describedby="name" placeholder="" value="" required>
                    </div>
                    <div class="form-group">
                      <label for="description">Mô tả</label>
                      <textarea class="form-control autosize" name="description" placeholder="" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 62px;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-save">Lưu</button>
                    <button type="reset" class="btn btn-light">Đóng</button>
                  </form>
                  <hr>
                </div>
                <ul class="list-group">
                </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    //Branch
    function handleFormBranch(editMode) {
      let formCreate = $("#create-branch");
			if(formCreate.hasClass("open") && !editMode){
				formCreate.removeClass("open");
				formCreate.slideUp(300);
			}
			else{
				formCreate.slideDown(300);
				formCreate.addClass("open");
			}
    }

	  $('#branch').on('click', '.btn-create-branch', function(event){
      event.preventDefault();
      $('#branch').find('form').trigger('reset');
      handleFormBranch();
		});

    $('#branch').on('click', '.btn-light', function(event){
      event.preventDefault();
      handleFormBranch();
		});

    $('#branch').on('click', '.btn-save', function(e) {
      if(!checkValidateHTML('form-branch')) {
        return;
      }
      e.preventDefault();
      loading('show');
      let branchID = $('#branch').find('[name="branch_id"]').val();
      let data = $('#branch').find('form').serializeArray();
      let dataObj = arrDataToObject(data);
      if(branchID)
        updateBranch(dataObj);
      else
        createBranch(dataObj);
    })

    //create branch
    function createBranch(data) {
      const url = "{{ route('setting.createBranch') }}";
      const options = {
        url,
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          ...data
        },
        method: 'POST',
        success: (res) => {
          if(res.Status === 'Success') {
            toastr.success(res.Message);
            handleFormBranch();
            drawNewBranch(data);
            $('#branch').find('form').trigger('reset');
          } else {
            toastr.error(res.Message);
          }
          loading('hide');
        },
        error: (err) => {
          loading('hide');
          toastr.error(err.message);
          console.log(err.message);
        }
      }
      $.ajax(options);
    }

    function drawNewBranch(data) {
      let listDOM = $('#branch').find('.list-group');
      let content = `<li href="#" class="list-group-item text-left">
                    <div class="branch-item">
                      <div>
                        <h6 class="name">
                          ${data.name}
                        </h6>
                        <small id="usernameHelp" class="form-text text-muted">${data.description}</small>
                      </div>
                      <label class="pull-right">
                          <a class="btn btn-success btn-sm glyphicon glyphicon-ok btn-edit" href="#" title="View" data-data='${JSON.stringify(data)}''><i class="fas fa-edit"></i></a>
                          <a class="btn btn-danger  btn-sm glyphicon glyphicon-trash btn-remove" href="#" title="Delete" data-id="${data.id}"><i class="fas fa-trash"></i></a>
                      </label>
                    </div>
                    <div class="break"></div>
                  </li>`;
      listDOM.append(content);
    }

    //update branch
    function updateBranch(data) {
      const url = "{{ route('setting.updateBranch') }}";
      const options = {
        url,
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          ...data
        },
        method: 'POST',
        success: (res) => {
          if(res.Status === 'Success') {
            toastr.success(res.Message);
            handleFormBranch();
            setDataBranchAfterUpdate(data);
            $('#branch').find('form').trigger('reset');
          } else {
            toastr.error(res.Message);
          }
          loading('hide');
        },
        error: (err) => {
          toastr.error(err.message);
          console.log(err.message);
          loading('hide');
        }
      }
      $.ajax(options);
    }

    //edit
    function setDataFormBranch(data) {
      let form = $('#branch').find('form');
      form.find('[name="name"]').val(data.name);
      form.find('[name="branch_id"]').val(data.id??data.branch_id);
      form.find('[name="description"]').val(data.description);
    }

    $('#branch .list-group').on('click', '.btn-edit', function() {
      let data = $(this).attr('data-data');
      setDataFormBranch(JSON.parse(data));
      handleFormBranch(true);
    })
    //user-type
    function handleFormUserType(editMode) {
      let formCreate = $("#create-user-type");
			if(formCreate.hasClass("open") && !editMode){
				formCreate.removeClass("open");
				formCreate.slideUp(300);
			}
			else{
				formCreate.slideDown(300);
				formCreate.addClass("open");
			}
    }

    function drawNewUserType(data) {
      let listDOM = $('#account').find('.list-group');
      let content = `<li href="#" class="list-group-item text-left">
                    <div class="branch-item usertype_${data.id}">
                      <div>
                        <h6 class="name">
                          ${data.name}
                        </h6>
                        <small id="usernameHelp" class="form-text text-muted">${data.description}</small>
                      </div>
                      <label class="pull-right">
                          <a class="btn btn-success btn-sm glyphicon glyphicon-ok btn-edit" href="#" title="View" data-data='${JSON.stringify(data)}'><i class="fas fa-edit"></i></a>
                          <a class="btn btn-danger  btn-sm glyphicon glyphicon-trash btn-remove" href="#" title="Delete" data-id="${data.id}"><i class="fas fa-trash"></i></a>
                      </label>
                    </div>
                    <div class="break"></div>
                  </li>`;
      listDOM.append(content);
    }

    $('#account').on('click', '.btn-create-user-type', function(event){
      event.preventDefault();
      $('#account').find('[name=name]').val('');
      $('#account').find('[name=description]').text('');
      $('#account').find('[name=usertype_id]').val('');
      handleFormUserType();
		});

    $('#account').on('click', '.btn-save', function(e) {
      if(!checkValidateHTML('form-user-type')) {
        return;
      }
      e.preventDefault();
      loading('show');
      let usertypeID = $('#account').find('[name="usertype_id"]').val();
      let data = $('#account').find('form').serializeArray();
      let dataObj = arrDataToObject(data);
      if(usertypeID)
        updateUserType(dataObj);
      else
        createUserType(dataObj);
    })

    function createUserType(data) {
      const url = "{{ route('setting.createUserType') }}";
      const options = {
        url,
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          ...data
        },
        method: 'POST',
        success: (res) => {
          if(res.Status === 'Success') {
            toastr.success(res.Message);
            handleFormUserType();
            drawNewUserType(data);
            //setDataToOption
            let dataOption = JSON.parse($('.branch-select option:selected').attr('data-user-type'));
            dataOption.push(res.Data);
            $('.branch-select option:selected').attr('data-user-type', JSON.stringify(dataOption));
            $('#account').find('form').trigger('reset');
          } else {
            toastr.error(res.Message);
          }
          loading('hide');
        },
        error: (err) => {
          loading('hide');
          toastr.error(err.message);
          console.log(err.message);
        }
      }
      $.ajax(options);
    }

    function updateUserType(data) {
      const url = "{{ route('setting.updateUserType') }}";
      const options = {
        url,
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          ...data
        },
        method: 'POST',
        success: (res) => {
          if(res.Status === 'Success') {
            toastr.success(res.Message);
            handleFormUserType();
            setDataUserAfterUpdate(data);
            $('#account').find('[name=name]').val('');
            $('#account').find('[name=description]').text('');
            $('#account').find('[name=usertype_id]').val('');
          } else {
            toastr.error(res.Message);
          }
          loading('hide');
        },
        error: (err) => {
          toastr.error(err.message);
          console.log(err.message);
          loading('hide');
        }
      }
      $.ajax(options);
    }

    $('.btn-tab-account').on('click', function(){
      setDataBranchSelect();
    })

    function setDataBranchSelect() {
      loading('show');
      getDataBranch().then(res => {
        loading('hide');
        let data = res.Data;
        let content = data.map(branch =>
          `<option value="${branch.id}" data-user-type='${JSON.stringify(branch.user_types)}'>${branch.name}</option>`
        );
        $('.branch-select').empty();
        $('.branch-select').append(content.join(''));
        $('.branch-select').trigger('change');
      });
    }

    function getDataBranch() {
      const url = "{{ route('setting.getAllBranch') }}";
      const options = {
        url,
        method: 'GET',
        error: (err) => {
          loading('hide');
          toastr.error(err.message);
          console.log(err.message);
        }
      }
      return $.ajax(options);
    }

    $('.branch-select').on('change', function() {
      $('#account').find('[name=branch_id]').val(this.value);
      setDataUserType();
    })

    function setDataUserType() {
      let data = JSON.parse($('.branch-select option:selected').attr('data-user-type'));
      $('#account').find('.list-group').empty();
      data.forEach((item) => {
        drawNewUserType(item)
      })
    }

    $('#account .list-group').on('click', '.btn-edit', function() {
      let data = $(this).attr('data-data');
      setDataFormUserType(JSON.parse(data));
      handleFormUserType(true);
    })

    function setDataFormUserType(data) {
      let form = $('#account').find('form');
      form.find('[name="name"]').val(data.name);
      form.find('[name="branch_id"]').val(data.branch_id);
      form.find('[name="usertype_id"]').val(data.id??data.usertype_id);
      form.find('[name="description"]').val(data.description);
    }

    function setDataUserAfterUpdate(data){
      let userTypeItem = $(`.usertype_${data.usertype_id}`);
      userTypeItem.find('h6').text(data.name);
      userTypeItem.find('small').text(data.description);
      userTypeItem.find('.btn-edit').attr('data-data', JSON.stringify(data));
      //setDataToOption
      let dataOption = JSON.parse($('.branch-select option:selected').attr('data-user-type'));
      dataOption.forEach((item) => {
        if(item.id == data.usertype_id) {
          item.name = data.name;
          item.description = data.description;
        }
      })
      $('.branch-select option:selected').attr('data-user-type', JSON.stringify(dataOption));
    }

    function setDataBranchAfterUpdate(data){
      let branchItem = $(`.branch_${data.branch_id}`);
      branchItem.find('h6').text(data.name);
      branchItem.find('small').text(data.description);
      branchItem.find('.btn-edit').attr('data-data', JSON.stringify(data));
    }

    $('#account').on('click', '.btn-remove',function(){
      alert('oke');
      let that = this;
      const url = "{{ route('setting.deleteUserType') }}";
      let id = $(this).attr('data-id');
      const options = {
        url,
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          id
        },
        method: 'DELETE',
        success: (res) => {
          if(res.Status === 'Success') {
            $(that).closest('li').remove();
            toastr.success(res.Message);
            let dataOption = JSON.parse($('.branch-select option:selected').attr('data-user-type'));
            let index = dataOption.findIndex(item => item.id == id)
            dataOption.splice(index, 1);
            $('.branch-select option:selected').attr('data-user-type', JSON.stringify(dataOption));
          } else {
            toastr.error(res.Message);
          }
          loading('hide');
        },
        error: (err) => {
          toastr.error(err.message);
          console.log(err.message);
          loading('hide');
        }
      }
      $.ajax(options);
    })
	});
</script>
@endsection
