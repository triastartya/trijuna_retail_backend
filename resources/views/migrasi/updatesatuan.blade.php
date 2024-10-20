@extends('layout.layout')
@section('css')
@endsection

@section('content')
    <section class="content">
        <!-- Default box -->
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">Migrasi Update Satuan</h4>
            </div>
            <div class="card-body">
                <form id="formSupplier">
                <div class="row" >
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Update Satuan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
        <table class="table table-bordered mt-3" id='datatable'>
            <thead>
                <tr>
                    @if(count($items) > 0)
                        @foreach(array_keys((array) $items[0]) as $key)
                            <th>{{ ucfirst($key) }}</th>
                        @endforeach
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    @foreach((array) $item as $value)
                        <td>{{ is_string($value) ? $value : json_encode($value) }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection

@section('ctrl')
    <script>
    app.controller("myCtrl", function($scope,$http) {
                $('#datatable').DataTable();

        $('#formSupplier').validate({
            rules: {
                
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
                form = $("#formSupplier")[0];
                let formData = new FormData(form);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ url('migrasi/updatesatuan') }}",
                    type: "GET",
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.success){
                            Swal.fire({icon: 'success',title: ' Berhasil Update Satuan',text: '',}).then(function(){

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