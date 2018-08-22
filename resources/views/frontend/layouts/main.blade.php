<!DOCTYPE html>
<html>

  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title>{{ !empty($title) ? $title : "" }}</title>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Rubik:400,700,900" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,900" rel="stylesheet">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
      <link rel="stylesheet" href="{{ url('css/map.css') }}">
      <link rel="stylesheet" href="{{ url('css/style.css') }}">
  </head>

<body>

<!--header-->
@yield('header')
    
<!--content-->
@yield('content')

<!-- footer layout -->
@include('frontend.layouts.footer')

<!-- js -->
@yield('footer')

</body>

</html>