@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->

                    <h2 class="page-title">
                        Set Tugas Karyawan
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if (Session::get('warning'))
                                        <div class="alert alert-warning">
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @role('administrator', 'user')
                                <div class="row">
                                    <div class="col-12">
                                        <a href="#" class="btn btn-primary" id="btnSettugaskaryawan">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 5l0 14"></path>
                                                <path d="M5 12l14 0"></path>
                                            </svg>
                                            Tambah Data
                                        </a>
                                    </div>
                                </div>
                            @endrole

                            <div class="row mt-2">
                                <div class="col-12">
                                    <table class="table">
                                        <tr>
                                            <th>ID Tugas</th>
                                            <td>{{ $tugas->tugas_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Judul Tugas</th>
                                            <td>{{ $tugas->judul_tugas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <td>{{ $tugas->deskripsi_tugas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Lampiran</th>
                                            <td>{{ $tugas->lampiran_tugas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Deadline</th>
                                            <td>{{ date('d-m-Y', strtotime($tugas->deadline)) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>NIK</th>
                                                <th>Nama Karyawan</th>
                                                <th>Jabatan</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="loadtugaskaryawan"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-settugaskaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tugas Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama Karyawan</th>
                                <th>Jabatan</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody id="loadsettugaskaryawan"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('myscript')
    <script>
        $(function() {

            function loadtugaskaryawan() {
                var tugas_id = "{{ $tugas->tugas_id }}";
                $("#loadtugaskaryawan").load('/tugas/' + tugas_id + '/gettugaskaryawan');
            }

            loadtugaskaryawan();

            $("#btnSettugaskaryawan").click(function(e) {
                var tugas_id = "{{ $tugas->tugas_id }}";
                $("#modal-settugaskaryawa").modal("show");
                $("#loadsettugaskaryawan").load('/tugas/' + tugas_id +
                    '/setlisttugaskaryawan');
            });
        });
    </script>
@endpush --}}
@push('myscript')
<script>
    $(function() {
        // function loadtugaskaryawan() {
        //     var tugas_id = "{{ $tugas->tugas_id }}";
        //     console.log(tugas_id)
        //     $("#loadsettugaskaryawan").load('/tugas/' + tugas_id + '/gettugaskaryawan');
        // }

        function loadtugaskaryawan() {
                var tugas_id = "{{ $tugas->tugas_id }}";
                $("#loadtugaskaryawan").load('/tugas/' + tugas_id + '/gettugaskaryawan');
            }


        loadtugaskaryawan();

        $("#btnSettugaskaryawan").click(function(e) {
            var tugas_id = "{{ $tugas->tugas_id }}";
            console.log(tugas_id)
            $("#modal-settugaskaryawan").modal("show");
            $("#loadsettugaskaryawan").load('/tugas/' + tugas_id + '/getsetlisttugaskaryawan');
            
            // Update aria-hidden attribute
            $("#modal-settugaskaryawan").attr("aria-hidden", "false");
        });
        
        // Optionally, reset aria-hidden when modal is hidden
        $('#modal-settugaskaryawan').on('hidden.bs.modal', function () {
            $(this).attr("aria-hidden", "true");
        });
    });
</script>
@endpush
