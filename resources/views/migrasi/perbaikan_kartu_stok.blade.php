@extends('layout.layout')
@section('css')
@endsection

@section('content')
    <section class="content">
        <!-- Default box -->
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">Perbaikan Kartu Stok</h4>
            </div>
            <div class="card-body">
                <form id="formRak">
                <div class="row" >
                    <div class="col-md-12 mb-2">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Id Barang</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="id_barang" name="id_barang">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Warehouse</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="warehouse" name="warehouse">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">tanggal</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="tanggal" name="tanggal">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Proses</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('ctrl')
    <script>
    app.controller("myCtrl", function($scope,$http) {

        $('#formRak').validate({
            rules: {
                id_barang: {
                    required: true
                },
                warehouse: {
                    required: true
                },
                tanggal: {
                    required: true
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element
                    .closest('.form-group')
                    .append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(e){
                form = $("#formRak")[0];
                let formData = new FormData(form);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ url('migrasi/perbaikan_kartu_stok') }}",
                    type: "POST",
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.success){
                            Swal.fire({icon: 'success',title: 'Berhasil',text: '',}).then(function(){
                                {{-- window.location.reload(); --}}
                            })
                        }else{
                            Swal.fire({icon: 'error',title: 'Oops...',text: data.message,})
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        Swal.fire({icon: 'error',title: 'Oops...',text: 'Something went wrong!',})
                    },
                    beforeSend: function(){
                        Swal.fire({title: 'Loading..',onOpen: () => {Swal.showLoading()}})
                    }
                });
                return false;
            }
        });
    });
    </script>
@endsection