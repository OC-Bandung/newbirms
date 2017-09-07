<!DOCTYPE html>
<html class="mdc-typography">
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="id" class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ !empty($title) ? $title : "" }}</title>
    <meta name="description" content="{{ !empty($description) ? $description : " " }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel=stylesheet href="{{ url('css/normalize.css') }}">
    <link rel=stylesheet href="{{ url('css/menu.css') }}">
    <link rel=stylesheet href="{{ url('css/search.css') }}">
    <link rel=stylesheet href="{{ url('css/homepage-slider.css') }}">
    <link rel=stylesheet href="{{ url('css/main.css') }}">
</head>

<body>
    <!--intro-->
    @include('frontend.layouts.intro')

    <!--content-->
    @yield('content')
    
    <!--footer-->
    @include('frontend.layouts.footer')
</body>

</html>