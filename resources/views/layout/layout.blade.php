<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Layout</title>
  <script src="{{ url('/') }}/plugins/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="{{ url('/') }}/plugins/fontawesome/css/all.min.css">
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
</head>
<body ng-app="app" ng-controller="myCtrl">
  <header class="shadow p-2 mb-2 sticky-top bg-light">
    <div class="d-flex flex-row justify-content-between">
      <a href="#"><i class="fa-solid fa-grip"></i></a>
      <a href="#"><i class="fa-solid fa-cart-shopping text-primary mx-2"></i></a>
    </div>
  </header>
</body>
</html>