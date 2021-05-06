@extends('master')
@include('header')
@section('content')

<div class="container container-content">
  <h5>List of rosters</h5>
  <table class="table">
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
      @foreach ($rosters as $key => $roster)
        <tr>
          <th scope="row">{{$key + 1}}</th>
          <td>{{$roster->day_start}}</td>
          <td>{{$roster->day_finish}}</td>
          <td>{{$roster->status}}</td>
          <td>{{$roster->user_created_id}}</td>
          <td>{{$roster->created_at}}</td>
          <td>{{$roster->updated_at}}</td>
          <td></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection