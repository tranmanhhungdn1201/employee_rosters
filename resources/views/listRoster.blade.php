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
        <?php
            switch($roster->status){
                case '1':
                    $bgColor = 'badge-warning';
                    break;
                case '2':
                    $bgColor = 'badge-success';
                    break;
                case '3':
                    $bgColor = 'badge-dark';
                    break;
                default:
                    $bgColor = '';
            }
        ?>
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
    </tbody>
  </table>
</div>
@endsection