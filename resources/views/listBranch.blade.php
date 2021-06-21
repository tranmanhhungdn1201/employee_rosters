@extends('master')
@include('header')
@section('content')

<div class="container container-content">
  <div class="row">
    @foreach ($branches as $branch)
    <div class="col-sm-6 col-md-4 col-lg-3 mt-4">
      <div class="card text-center">
        <div class="card-body">
          <a href="{{route('listRoster', $branch->id)}}" class="text-dark"><h5 class="card-title">{{$branch->name}}</h5></a>
          <p class="card-text">{{$branch->description}}</p>
          <p class="card-text"><small class="text-muted">Since 2020</small></p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection