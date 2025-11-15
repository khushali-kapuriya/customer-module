<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Master Modules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('head')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Masters</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="{{ route('countries.index') }}">Countries</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('states.index') }}">States</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('cities.index') }}">Cities</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('customers.index') }}">Customers</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@yield('scripts')
</body>
</html>
