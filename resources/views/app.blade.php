<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>コミメモ</title>

<!-- Styles -->
<!-- bootstrap -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!-- bootstrap上書き用css -->
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">

<!-- Fonts -->
<!-- 本文・リンク用 -->
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<!-- タイトル -->
<link href="https://fonts.googleapis.com/css2?family=Mochiy+Pop+One&display=swap" rel="stylesheet">

<!-- FontAwesome -->
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

</head>
<body>


<div id="app">
  <header-component></header-component>
    <main class="py-4 ml-auto mr-auto">
      <router-view></router-view>
    </main>
  <footer-component></footer-component>
</div>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

</script>

</body>
</html>
