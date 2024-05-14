<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>OpalTime Card</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/">
        @include('layouts.head')
  </head>
    <body class="pb-0" style="background-image: url({{ URL::asset('assets/images/bg1.jpg') }})">
        @yield('content')
        @include('layouts.footer-script')
        @include('includes.flash')
    </body>
</html>
