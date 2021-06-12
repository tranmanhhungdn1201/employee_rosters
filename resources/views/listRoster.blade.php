@extends('master')
@include('header')
@section('content')

<div class="container container-content">
  <h5>List of rosters</h5>
  <div class="action">
    <a href="{{route('viewCreateRoster')}}" class="btn btn-info">Create roster</a>
  </div>
  <div class="mb-2 mt-2">
    <input type="text" class="form-control" id="search" placeholder="Tìm kiếm">
  </div>
  <table id="rosters-table" class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Ngày bắt đầu</th>
        <th scope="col">Ngày kết thúc</th>
        <th scope="col">Trạng thái</th>
        <th scope="col">Người tạo</th>
        <th scope="col">Ngày tạo</th>
        <th scope="col">Ngày chỉnh sửa</th>
        <th scope="col">Ghi chú</th>
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
            <td></td>
          </tr>
        @endforeach
      @endif --}}
    </tbody>
  </table>
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
      columns: [
          { data: 'id', name: 'id' },
          { data: 'day_start', name: 'day_start' },
          { data: 'day_finish', name: 'day_finish' },
          { data: 'status_roster', name: 'status_roster' },
          { data: 'user_created_name', name: 'user_created_name' },
          { data: 'created_at', name: 'created_at' },
          { data: 'updated_at', name: 'updated_at' },
          // { data: 'action', name: 'action' },
      ]
  });
  $('#search').on('keyup', debounce(function () {
    table.search(this.value).draw();
  }, 300));
</script>
@endsection