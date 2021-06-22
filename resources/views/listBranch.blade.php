@extends('master')
@include('header')
@section('content')

<div class="row">
  @foreach ($branches as $branch)
  <div class="col-sx-12 col-sm-6 col-md-6 col-lg-4">
    <div class="card">
      <div class="card-header">
        <div class="card-header__icon">
          <img alt="alt text" src="{!! asset('image/branch.svg') !!}">
        </div>
        {{$branch->name}}
      </div>
      <div class="card-body">
        <p class="card-desc">{{$branch->description}}</p>
        <p class="card-text">Since 2020</p>
      </div>
      <div class="card-footer text-center">
        <a href="{{route('listRoster', $branch->id)}}" class="btn btn-primary btn-radius--50 btn-shadow">Detail</a>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection