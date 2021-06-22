@extends('master')
@include('header')
@section('content')

<div class="row mx-0">
  <div class="card">
    <div class="card-header">
      <div class="card-header__icon">
        <img alt="alt text" src="{!! asset('image/roster.svg') !!}">
      </div>
      Danh sách phân công
      <div class="card-header__action">
        <a href="{{route('viewCreateRoster')}}" class="btn btn-success">
          <i class="fas fa-plus"></i>
          Tạo bảng phân công
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
        <table id="rosters-table" class="table display responsive nowrap">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Ngày bắt đầu</th>
              <th scope="col">Ngày kết thúc</th>
              <th scope="col">Trạng thái</th>
              <th scope="col">Người tạo</th>
              <th scope="col">Ngày tạo</th>
              <th scope="col">Ngày chỉnh sửa</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
          {{--       
            @if(count($rosters) === 0)
              <td colspan="8" class="text-center">Chưa có lịch đăng ký nào.</td>
            @else
              @foreach ($rosters as $key => $roster)
                <tr>
                  <th scope="row"><a class="text-dark" href="{{ route('singleRoster', $roster->id) }}">{{$key + 1}}</a></th>
                  <td>{{$roster->day_start}}</td>
                  <td>{{$roster->day_finish}}</td>
                  <td><span class="{{'badge ' . $bgColor}}">{{$roster->status_name}}</span></td>
                  <td>{{$roster->user_created_name}}</td>
                  <td>{{$roster->created_at}}</td>
                  <td>{{$roster->updated_at}}</td>
                  <!-- <td></td> -->
                </tr>
              @endforeach
            @endif --}}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  let branchID = "{!! $branchID !!}";
  let url = '{!! route("getListRosterDatatables", ":id") !!}';
  url = url.replace(':id', branchID);
  let table = $('#rosters-table').DataTable({
      processing: false,
      searching: true,
      lengthChange: false,
      serverSide: true,
      language: LANGUAGE,
      ajax: url,
      autoWidth: false,
      columns: [
          { data: 'id', name: 'id' },
          { data: 'day_start', name: 'day_start' },
          { data: 'day_finish', name: 'day_finish' },
          { data: 'status_roster', name: 'status_roster' },
          { data: 'user_created_name', name: 'user_created_name' },
          { data: 'created_at', name: 'created_at' },
          { data: 'updated_at', name: 'updated_at' },
          { data: 'action', name: 'action' },
      ]
  });
  $('#search').on('keyup', debounce(function () {
    table.search(this.value).draw();
  }, 300));
</script>
@endsection