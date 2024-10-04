@extends('layout.layout')
@section('css')
@endsection

@section('content')
    <section class="content">
        <!-- Default box -->
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">Migrasi Data Satuan From Json File</h4>
            </div>
            <div class="card-body">
                <form id="formSatuan">
                <div class="row" >
                    <div class="col-md-12 mb-2">
                        <div class="form-group row">
                            <input type="file" class="form-control-file" id="file" name="file">
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Memory Limit</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="memory" name="memory" value="256M">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Import Data</button>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <button type="button" class="btn btn-danger" ng-click="delSatuan()">Truncate Data</button>
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

        $('#formSatuan').validate({
            rules: {
                file: {
                    required: true
                },
                memory: {
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
                form = $("#formSatuan")[0];
                let formData = new FormData(form);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ url('migrasi/satuan') }}",
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
                            Swal.fire({icon: 'success',title: 'Merek Berhasil Di Simpan',text: '',}).then(function(){
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

        $scope.delSatuan= function(){
            Swal.fire({
                title: "Yakin menghapus semua data Satuan?",
                showCancelButton: true,
                confirmButtonText: "Ya Hapus",
            }).then(function(result){
                console.log(result);
                if (result.isConfirmed) {
                    $http.get("{{ url('migrasi/satuan/truncate') }}").then(function(res){
                        console.log('respon truncate Satuan',res)
                        Swal.fire("Berhasil di Hapus!", "", "success");
                    })
                }
            })
        }
    });
    </script>
@endsection