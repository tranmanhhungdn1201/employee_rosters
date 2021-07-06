<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Employee Roster</title>

        <!-- Custom -->
        <link rel="stylesheet" href="{!! asset('css/app.css') !!}">
        <link rel="stylesheet" href="{!! asset('css/common.css') !!}">
    </head>
<body>
@includeWhen(!isset($isNonShowHeader), 'header');
<main class="site-main container">
  <!-- Custom -->
  <script src="{!! asset('js/common.js') !!}"></script>
  <script src="{!! asset('js/javascript.js') !!}"></script>
  <script src="{!! asset('js/app.js') !!}"></script>
  @yield('content')
</main>
<div class="overlay hidden"></div>
<div class="loader hidden">
  <h2>Loading..</h2>
  <div class="dots"></div>
</div>
@include('footer')