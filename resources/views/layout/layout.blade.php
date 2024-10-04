<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Layout</title>
  <script src="{{ url('/') }}/plugins/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="{{ url('/') }}/plugins/fontawesome/css/all.min.css">
  @yield('css')
  <script src="{{ url('/') }}/plugins/fontawesome/js/all.min.js"></script>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ url('/') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <script src="{{ url('/') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- jquery-validation -->
  <script src="{{ url('/') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="{{ url('/') }}/plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- angular js -->
  <script src="{{ url('/') }}/angularJS/angular.min.js"></script>
  <script src="{{ url('/') }}/angularJS/app.js"></script>
  <script>
    Array.prototype.sum = function (prop) {
      var total = 0
      for ( var i = 0, _len = this.length; i < _len; i++ ) {
        total += this[i][prop]
      }
      return total
    }
  </script>
  @yield('ctrl')
</head>
<body ng-app="app" ng-controller="myCtrl">
  <header class="shadow p-2 mb-2 sticky-top bg-light">
    <div class="d-flex flex-row justify-content-between">
      <div class="d-flex flex-row">
        <a href="#"><i class="fa-solid fa-grip me-3"></i></a>
        <a href="{{ url('migrasi') }}" class="btn btn-outline-primary btn-sm me-3"> merk</a>
        <a href="{{ url('migrasi_divisi') }}" class="btn btn-outline-primary btn-sm me-3"> divisi</a>
        <a href="{{ url('migrasi_group') }}" class="btn btn-outline-primary btn-sm me-3"> group</a>
        <a href="{{ url('migrasi_rak') }}" class="btn btn-outline-primary btn-sm me-3"> rak</a>
        <a href="{{ url('migrasi_satuan') }}" class="btn btn-outline-primary btn-sm me-3"> satuan</a>
        <a href="{{ url('migrasi_edc') }}" class="btn btn-outline-primary btn-sm me-3"> edc</a>
        <a href="{{ url('migrasi_bank') }}" class="btn btn-outline-primary btn-sm me-3"> bank</a>
        <a href="{{ url('migrasi_customer') }}" class="btn btn-outline-primary btn-sm me-3"> customer</a>
        <a href="{{ url('migrasi_supplier') }}" class="btn btn-outline-primary btn-sm me-3"> supplier</a>
        <a href="{{ url('migrasi_barang') }}" class="btn btn-outline-primary btn-sm me-3"> barang</a>
      </div>
      <a href="#"><i class="fa-solid fa-cart-shopping text-primary mx-2"></i></a>
    </div>
  </header>
  
  <div class="container">
    @yield('content')
  </div>
</body>
  <link href="https://cdn.datatables.net/v/bs5/dt-2.1.6/kt-2.12.1/sc-2.4.3/sl-2.1.0/datatables.min.css" rel="stylesheet">  
  <script src="https://cdn.datatables.net/v/bs5/dt-2.1.6/kt-2.12.1/sc-2.4.3/sl-2.1.0/datatables.min.js"></script>
</html>