@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Rekap Presensi Hari Ini {{ date('d-m-Y', strtotime(date('Y-m-d'))) }}
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            <div class="row">

                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-success text-white avatar">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-fingerprint" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3"></path>
                                            <path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6"></path>
                                            <path d="M12 11v2a14 14 0 0 0 2.5 8"></path>
                                            <path d="M8 15a18 18 0 0 0 1.8 6"></path>
                                            <path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        {{ $rekappresensi->jmlhadir }}
                                    </div>
                                    <div class="text-muted">
                                        Karyawan hadir
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-info text-white avatar">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-file-text" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                            </path>
                                            <path d="M9 9l1 0"></path>
                                            <path d="M9 13l6 0"></path>
                                            <path d="M9 17l6 0"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        {{ $rekappresensi->jmlizin }}
                                    </div>
                                    <div class="text-muted">
                                        Karyawan Izin
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-warning text-white avatar">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-mood-sick" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 21a9 9 0 1 1 0 -18a9 9 0 0 1 0 18z"></path>
                                            <path d="M9 10h-.01"></path>
                                            <path d="M15 10h-.01"></path>
                                            <path d="M8 16l1 -1l1.5 1l1.5 -1l1.5 1l1.5 -1l1 1"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        {{ $rekappresensi->jmlsakit }}
                                    </div>
                                    <div class="text-muted">
                                        Karyawan Sakit
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-danger text-white avatar">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-alarm-filled" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M16 6.072a8 8 0 1 1 -11.995 7.213l-.005 -.285l.005 -.285a8 8 0 0 1 11.995 -6.643zm-4 2.928a1 1 0 0 0 -1 1v3l.007 .117a1 1 0 0 0 .993 .883h2l.117 -.007a1 1 0 0 0 .883 -.993l-.007 -.117a1 1 0 0 0 -.993 -.883h-1v-2l-.007 -.117a1 1 0 0 0 -.993 -.883z"
                                                stroke-width="0" fill="currentColor"></path>
                                            <path
                                                d="M6.412 3.191a1 1 0 0 1 1.273 1.539l-.097 .08l-2.75 2a1 1 0 0 1 -1.273 -1.54l.097 -.08l2.75 -2z"
                                                stroke-width="0" fill="currentColor"></path>
                                            <path
                                                d="M16.191 3.412a1 1 0 0 1 1.291 -.288l.106 .067l2.75 2a1 1 0 0 1 -1.07 1.685l-.106 -.067l-2.75 -2a1 1 0 0 1 -.22 -1.397z"
                                                stroke-width="0" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        {{ $rekappresensi->jmlterlambat }}
                                    </div>
                                    <div class="text-muted">
                                        Karyawan Terlambat
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Pegawai per Mitra -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Jumlah Pegawai Per Mitra</div>
                        <div class="card-body">
                            <canvas id="chartMitra"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart Pegawai per Unit -->
                {{-- <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Jumlah Pegawai Per Unit</div>
                        <div class="card-body">
                            <canvas id="chartUnit"></canvas>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <input type="hidden" id="mitra" value="{{ $pegawaiPerMitra }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctxMitra = document.getElementById('chartMitra').getContext('2d');
            var pegawaiPerMitra1 = JSON.parse(document.getElementById('mitra').value);
    
            // Prepare labels and data for the chart
            var mitraLabels = pegawaiPerMitra1.map(function(item) {
                return item.kode_cabang; // or item.kode_cabang if you want the code
            });
    
            var mitraData = pegawaiPerMitra1.map(function(item) {
                return item.jumlah;
            });
    
            new Chart(ctxMitra, {
                type: 'line',
                data: {
                    labels: mitraLabels,
                    datasets: [{
                        label: 'Jumlah Pegawai',
                        data: mitraData,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }],
                    options: {
                        scales: {
                        y: {
                            beginAtZero: true
                        }
                        }
                    },
                }
            });
        });
    </script>
@endsection
