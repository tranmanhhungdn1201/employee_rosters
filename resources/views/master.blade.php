<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Employee Roster</title>

        <link rel="stylesheet" href="{!! asset('css/bootstrap.min.css') !!}">
        <link rel="stylesheet" href="{!! asset('css/header.css') !!}">

        <script src="{!! asset('js/jquery-3.6.0.min.js') !!}"></script>
        <script src="{!! asset('js/bootstrap.min.js') !!}"></script>
        <script src="{!! asset('js/common.js') !!}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    </head>
<body>
@yield('content')
@include('footer')