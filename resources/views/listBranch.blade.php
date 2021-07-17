@extends('master')
@section('content')

<div class="row">
  @foreach ($branches as $branch)
  <div class="col-sx-12 col-sm-6 col-md-6 col-lg-4 mb-1">
    <div class="card">
      <div class="card-header">
        <div class="card-header__icon">
          <img alt="alt text" src="{!! asset('image/branch.svg') !!}">
          {{$branch->name}}
        </div>
      </div>
      <div class="card-body">
        <p class="card-desc">{{$branch->description}}</p>
      </div>
      <div class="card-footer text-center">
        <a href="{{route('listRoster', $branch->id)}}" class="btn btn-primary btn-radius--50 btn-shadow">Xem bảng phân công</a>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
