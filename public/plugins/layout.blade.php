<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ url('/') }}/template/plugins/jquery/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="{{ url('/') }}/fontawesome/css/all.min.css">
    <script src="{{ url('/') }}/fontawesome/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ url('/') }}/assets/style-website.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ url('/') }}/template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <script src="{{ url('/') }}/template/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- jquery-validation -->
    <script src="{{ url('/') }}/template/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ url('/') }}/template/plugins/jquery-validation/additional-methods.min.js"></script>
 
    
    <script src="{{ url('/') }}/template/angularJS/angular.min.js"></script>
    <script src="{{ url('/') }}/template/angularJS/app.js"></script>
    <style>
      body {
          font-family: 'Poppins';
      }
    </style>
    <script>
    
    $.get("{{ url('get_page') }}", function(data, status){
      console.log(data.data)
      $('#layout_logo').attr("src", data.data.logourl);
      document.title = data.data.nama;
    });
  
      Array.prototype.sum = function (prop) {
            var total = 0
            for ( var i = 0, _len = this.length; i < _len; i++ ) {
                total += this[i][prop]
            }
            return total
      }
    </script>
    @yield('css')
    @yield('ctrl')
</head>
<body ng-app="app"  ng-controller="myCtrl">
    <header class="shadow p-2 mb-2 sticky-top bg-light">
      <div class="d-flex flex-row justify-content-between">
          <div style="width:150px" >
            <a href="{{ url('') }}">
              <img style="height:38px" alt="tokopedia-logo" id="layout_logo" src="{{ url('/') }}/images/logo.jpeg">
            </a>
          </div>
          
          <div style="width:calc(100vw - 500px)">
            <div class="input-group input-group-sm">
              <span class="input-group-text" id="basic-addon1">
                <i class="fa-solid fa-search mx-1"></i>
              </span>
              <input id="cari_barang" type="text" class="form-control" placeholder="Cari Barang">
            </div>
          </div>
          
          <div style="width:250px">
            <a href="{{ url('keranjang-belanja') }}"><i class="fa-solid fa-cart-shopping text-primary mx-2"></i></a>
            @if(session()->has('data_member'))
              <a href="{{ url('member') }}">
                <button class="btn btn-outline-primary btn-sm mx-1">Akun</button>
              </a>
            @else
              <button class="btn btn-outline-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Masuk</button>
              <button class="btn btn-primary btn-outline btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#register">Daftar</button>
            @endif
            
            @if(session()->has('data_merchant'))
              <a href="{{ url('toko') }}">
                <button class="btn btn-outline-primary btn-sm mx-1">Toko</button>
              </a>
            @endif
          </div>
      </div>
    </header>
    @yield('content')
    <hr class="mt-5"/>
    <footer>
      <div class="row m-4">
        <div class="col">
          <p class="fw-bold">Alamat</p>
          <p style="font-size:13px">Jl.Raya Rembang-Sumber KM 10 Desa Dresikulon Kec. Kaliori Kab. Rembang</p>
        </div>
        <div class="col">
          <p class="fw-bold">Cara Pemesanan</p>
            <ul style="font-size:13px">
              <li>Pilih Barang</li>
              <li>Masukan Keranjang belanja</li>
              <li>Pilih Barang yang akan di bayar</li>
              <li>Transfer Pembayan ke rekeing</li>
              <li>Konfirmasi Pembayran upload bukti transfer</li>
            </ul>
        </div>
        <div class="col">
          <p class="fw-bold">Ikuti Kami</p>
          <div>
            <img class="pointer" src="{{ url('/') }}/images/1.svg">
            <img class="pointer" src="{{ url('/') }}/images/2.svg">
          </div>
        </div>
        <div class="col">
          <img class="img-fluid" src="{{ url('/') }}/images/footer.jpg">
        </div>
      </div>
    </footer>
    <!-- Modal Login -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
        <form id="form_login_member">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Masuk</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3 row">
                <label for="email_member" class="col-sm-3 col-form-label">email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control form-control-sm" id="email_member" name="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password_member" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control form-control-sm" id="password_member" name="password">
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    <!-- Modal Register -->
    <div class="modal fade" id="register" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
        <form id="form_daftar_member">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Daftar Member</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3 row">
                <label for="nama_lengkap" class="col-sm-3 col-form-label">nama</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_lengkap" name="nama">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-3 col-form-label">email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control form-control-sm" id="email" name="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="no_hp" class="col-sm-3 col-form-label">no hp</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="no_hp" name="no_hp">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control form-control-sm" id="password" name="password">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="confirm" class="col-sm-3 col-form-label">Confirm</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control form-control-sm" id="confirm" name="confirm">
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Daftar</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    
    <script>
    $("#cari_barang").keyup(function(event) {
        if (event.keyCode === 13) {
            window.location.href = "{{ url('produk') }}?search="+$("#cari_barang").val();
        }
    });
      var validator = $("#form_login_member").validate({
        rules: {
            email: {
                required: !0,
            },
            password: {
                required: !0,
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            error.addClass('fst-italic');
            element.closest('.mb-3 .col-sm-9').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        invalidHandler: function(e, r){
    
        },
        submitHandler: function(e){
    			    
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
    					url: "{{ url('login_member') }}",
    					type: "POST",
              data:$("#form_login_member").serialize(),
    					dataType: "JSON",
    					success: function(data)
                {
                    if(data.status){
                        Swal.fire({icon: 'success',title: 'Masuk Ke Halaman Member',text: '',}).then(function(){
                          window.location.href = "{{ url('member') }}";
                        })
                    }else{
                        Swal.fire({icon: 'error',title: 'Oops...',text: data.message,})
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    Swal.fire({icon: 'error',title: 'Oops...',text: 'Something went wrong! please contact IT system',})
                },
                beforeSend: function(){
                    Swal.fire({title: 'Loading..',onOpen: () => {Swal.showLoading()}})
                }
    				});
            return false;
        }
      });
      
      var validator = $("#form_daftar_member").validate({
        rules: {
            nama: {
                required: !0,
            },
            email: {
                required: !0,
            },
            no_hp: {
                required: !0,
            },
            password: {
                required: !0,
            },
            confirm: {
                required: !0,
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            error.addClass('fst-italic');
            element.closest('.mb-3 .col-sm-9').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        invalidHandler: function(e, r){
    
        },
        submitHandler: function(e){
    			    
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
    					url: "{{ url('daftar_member') }}",
    					type: "POST",
              data:$("#form_daftar_member").serialize(),
    					dataType: "JSON",
    					success: function(data)
                {
                    if(data.status){
                        Swal.fire({icon: 'success',title: 'Masuk Ke Toko',text: '',}).then(function(){
                          window.location.href = "{{ url('member') }}";
                        })
                    }else{
                        Swal.fire({icon: 'error',title: 'Oops...',text: data.message,})
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    Swal.fire({icon: 'error',title: 'Oops...',text: 'Something went wrong! please contact IT system',})
                },
                beforeSend: function(){
                    Swal.fire({title: 'Loading..',onOpen: () => {Swal.showLoading()}})
                }
    				});
            return false;
        }
      });
    </script>
    
</body>
</html>