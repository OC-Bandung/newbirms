<!DOCTYPE html>
<html>

  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <title>{{ !empty($title) ? $title : "" }}</title>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Rubik:400,700,900" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,900" rel="stylesheet">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
      <link rel="stylesheet" href="{{ url('css/contract/charts.css') }}">
      <link rel="stylesheet" href="{{ url('css/map.css') }}">
      <link rel="stylesheet" href="{{ url('css/style.css') }}">
      <link rel="stylesheet" href="{{ url('css/documentation.css') }}">
  </head>

<body>

<!--header-->
@yield('header')
    
<!--content-->
@yield('content')

<!-- footer layout -->
@include('frontend.layouts.footer')

<button onclick="topFunction()" id="upBtn" title="Kembali ke atas"><i class="material-icons align-middle"> arrow_upward</i></button>
<!-- js -->
@yield('footer')

<script type="text/javascript">
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("upBtn").style.display = "block";
    } else {
        document.getElementById("upBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
</script>

</body>

</html>