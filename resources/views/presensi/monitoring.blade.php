@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-fluid">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->

                    <h2 class="page-title">
                        Monitoring Presensi
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
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

                            <div class="row g-3 align-items-center">
                                @role('administrator', 'user')
                                    <div class="col-md-3">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-calendar-event" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z">
                                                    </path>
                                                    <path d="M16 3l0 4"></path>
                                                    <path d="M8 3l0 4"></path>
                                                    <path d="M4 11l16 0"></path>
                                                    <path d="M8 15h2v2h-2z"></path>
                                                </svg>
                                            </span>
                                            <input type="text" id="tanggal" value="{{ date('Y-m-d') }}" name="tanggal"
                                                value="" class="form-control" placeholder="Tanggal Presensi"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    {{-- untuk filter nama --}}
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <input type="text" name="nama_karyawan" id="nama_karyawan"
                                                class="form-control" placeholder="Nama Karyawan"
                                                value="{{ Request('nama_karyawan') }}">
                                        </div>
                                    </div>
                                    {{-- akhir filter nama --}}
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <select name="kode_cabang" id="kode_cabang" class="form-select select-search">
                                                <option value="">Semua Cabang</option>
                                                @foreach ($cabang as $d)
                                                    <option value="{{ $d->kode_cabang }}">
                                                        {{ strtoupper($d->nama_cabang) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <select name="jabatan" id="jabatan" class="form-select select-search">
                                                <option value="">Semua Jabatan</option>
                                                @foreach ($jabatan as $d)
                                                    <option
                                                        {{ Request('jabatan') == $d->nama_jabatan ? 'selected' : '' }}
                                                        value="{{ $d->nama_jabatan }}">{{ $d->nama_jabatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-calendar-event" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z">
                                                    </path>
                                                    <path d="M16 3l0 4"></path>
                                                    <path d="M8 3l0 4"></path>
                                                    <path d="M4 11l16 0"></path>
                                                    <path d="M8 15h2v2h-2z"></path>
                                                </svg>
                                            </span>
                                            <input type="text" id="tanggal" value="{{ date('Y-m-d') }}" name="tanggal"
                                                value="" class="form-control" placeholder="Tanggal Presensi"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                @endrole
                            </div>
                            <div id="loadrekap"></div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    {{-- <th>Nik</th> --}}
                                                    <th>Nama Karyawan</th>
                                                    <th>Cabang</th>
                                                    <th>Jabatan</th>
                                                    <th>Jadwal</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Foto</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Foto</th>
                                                    <th>Status</th>
                                                    <th>Keterangan</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="loadpresensi"></tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-tampilkanpeta" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lokasi Presensi User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadmap">

                </div>

            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-koreksipresensi" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Koreksi Pesensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadkoreksipresensi">

                </div>

            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(document).ready(function() {
            $('.select-search').select2();
        });

        $(function() {
            $("#tanggal").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            });

            function loadpresensi() {
                var tanggal = $("#tanggal").val();
                var kode_cabang = $("#kode_cabang").val();
                var nama_jabatan = $("#jabatan").val();
                var nama_karyawan = $("#nama_karyawan").val();
                $.ajax({
                    type: 'POST',
                    url: '/getpresensi',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        nama_karyawan: nama_karyawan,
                        kode_cabang: kode_cabang,
                        nama_jabatan: nama_jabatan
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadpresensi").html(respond);
                    }
                });
            }
            function loadrekap() {
                var tanggal = $("#tanggal").val();
                $.ajax({
                    type: 'POST',
                    url: '/getrekappresensi',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadrekap").html(respond);
                    }
                });
            }
            $("#tanggal").change(function(e) {
                loadpresensi();
                loadrekap();
            });
            $("#kode_cabang").change(function(e) {
                loadpresensi();
                loadrekap();
            });
            
            $("#jabatan").change(function(e) {
                loadpresensi();
                loadrekap();
            });
            $("#nama_karyawan").on("input", function(e) {
                loadpresensi();
                loadrekap();
            });
            loadpresensi();
            loadrekap();

        });

    </script>
@endpush
