@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Overview</div>
                    <h2 class="page-title">
                        Rekap Presensi Hari Ini {{ date('d-m-Y', strtotime(date('Y-m-d'))) }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-success text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-fingerprint" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                    <div class="font-weight-bold h5">
                                        @if ($rekappresensi->jmlhadir != null)
                                            {{ $rekappresensi->jmlhadir }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                    <div class="text-muted">Karyawan hadir</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-info text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                            <path d="M9 9l1 0"></path>
                                            <path d="M9 13l6 0"></path>
                                            <path d="M9 17l6 0"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-bold h5">
                                        @if ($rekappresensi->jmlizin != null)
                                            {{ $rekappresensi->jmlizin }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                    <div class="text-muted">Karyawan Izin</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-warning text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-sick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 21a9 9 0 1 1 0 -18a9 9 0 0 1 0 18z"></path>
                                            <path d="M9 10h-.01"></path>
                                            <path d="M15 10h-.01"></path>
                                            <path d="M8 16l1 -1l1.5 1l1.5 -1l1.5 1l1.5 -1l1 1"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-bold h5">
                                        @if ($rekappresensi->jmlsakit != null)
                                            {{ $rekappresensi->jmlsakit }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                    <div class="text-muted">Karyawan Sakit</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-primary text-white avatar">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-hanger-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 6a2 2 0 1 0 -4 0m6.506 6.506l3.461 1.922a2 2 0 0 1 1.029 1.749v.823m-2 2h-14a2 2 0 0 1 -2 -2v-.823a2 2 0 0 1 1.029 -1.749l6.673 -3.707" /><path d="M3 3l18 18" /></svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-bold h5">
                                        @if ($rekappresensi->jmlcuti != null)
                                            {{ $rekappresensi->jmlcuti }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                    <div class="text-muted">Karyawan Cuti</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-warning text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M16 6.072a8 8 0 1 1 -11.995 7.213l-.005 -.285l.005 -.285a8 8 0 0 1 11.995 -6.643zm-4 2.928a1 1 0 0 0 -1 1v3l.007 .117a1 1 0 0 0 .993 .883h2l.117 -.007a1 1 0 0 0 .883 -.993l-.007 -.117a1 1 0 0 0 -.993 -.883h-1v-2l-.007 -.117a1 1 0 0 0 -.993 -.883z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M6.412 3.191a1 1 0 0 1 1.273 1.539l-.097 .08l-2.75 2a1 1 0 0 1 -1.273 -1.54l.097 -.08l2.75 -2z" stroke-width="0" fill="currentColor"></path>
                                            <path d="M16.191 3.412a1 1 0 0 1 1.291 -.288l.106 .067l2.75 2a1 1 0 0 1 -1.07 1.685l-.106 -.067l-2.75 -2a1 1 0 0 1 -.22 -1.397z" stroke-width="0" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-bold h5">
                                        @if ($rekappresensi->jmlterlambat != null)
                                            {{ $rekappresensi->jmlterlambat }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                    <div class="text-muted">Karyawan Terlambat</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-danger text-white avatar">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  
                                            height="24"  viewBox="0 0 24 24"  fill="none"  
                                            stroke="currentColor"  stroke-width="2"  
                                            stroke-linecap="round"  stroke-linejoin="round"  
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-hexagon-letter-x">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                                            <path d="M10 8l4 8" />
                                            <path d="M10 16l4 -8" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-bold h5">{{ $jmlTidakHadir }}</div>
                                    <div class="text-muted">Karyawan Alpa</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-success text-white avatar">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-building-community"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9l5 5v7h-5v-4m0 4h-5v-7l5 -5m1 1v-6a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v17h-8" /><path d="M13 7l0 .01" /><path d="M17 7l0 .01" /><path d="M17 11l0 .01" /><path d="M17 15l0 .01" /></svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-bold h5">
                                        @if ($totalturlap != null)
                                            {{ $totalturlap }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                    <div class="text-muted">Karyawan Turun Lapangan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Chart Pegawai per Mitra -->
            </div>
        </div>
    </div>

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Rekap Karyawan 
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-success text-white avatar">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-man"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8c1.628 0 3.2 .787 4.707 2.293a1 1 0 0 1 -1.414 1.414c-.848 -.848 -1.662 -1.369 -2.444 -1.587l-.849 5.944v4.936a1 1 0 0 1 -2 0v-4h-2v4a1 1 0 0 1 -2 0v-4.929l-.85 -5.951c-.781 .218 -1.595 .739 -2.443 1.587a1 1 0 1 1 -1.414 -1.414c1.506 -1.506 3.08 -2.293 4.707 -2.293z" /><path d="M12 1a3 3 0 1 1 -3 3l.005 -.176a3 3 0 0 1 2.995 -2.824" /></svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-bold h5">{{ $totalKaryawan }}</div>
                                    <div class="text-muted">Total Karyawan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-info text-white avatar">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-pin"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" /><path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" /><path d="M19 18v.01" /></svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-bold h5">{{ $totalJabatan }}</div>
                                    <div class="text-muted">Total Jabatan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card card-sm shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-warning text-white avatar">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-replace"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M15 15m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3" /><path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3" /></svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-bold h5">{{ $totalCabang }}</div>
                                    <div class="text-muted">Total Cabang</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">Jumlah Pegawai Per Cabang</div>
                        <div class="card-body">
                            <canvas id="chartMitra"></canvas>
                        </div>
                    </div>
                </div>
    
                <!-- Chart Pegawai per Unit -->
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">Jumlah Karyawan Per Jabatan</div>
                        <div class="card-body">
                            <canvas id="chartPerJabatan"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="mitra" value="{{ $pegawaiPerMitra }}">
    <input type="hidden" id="perJabatan" value="{{ $totalKaryawanPerJabatan }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctxMitra = document.getElementById('chartMitra').getContext('2d');
            var pegawaiPerMitra1 = JSON.parse(document.getElementById('mitra').value);

            var pegawaiPerJabatan = JSON.parse(document.getElementById('perJabatan').value);

            var ctxPerJabatan = document.getElementById('chartPerJabatan').getContext('2d');
            // Prepare labels and data for the chart

            var mitraLabels = pegawaiPerMitra1.map(function(item) {
                return item.kode_cabang; // or item.kode_cabang if you want the code
            });
    
            var mitraData = pegawaiPerMitra1.map(function(item) {
                return item.jumlah;
            });

            var jabatanLabels = pegawaiPerJabatan.map(function(item) {
                return item.jabatan; // or item.kode_cabang if you want the code
            });
    
            var jabatanData = pegawaiPerJabatan.map(function(item) {
                return item.total;
            });
    
            new Chart(ctxMitra, {
                type: 'pie',
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


            new Chart(ctxPerJabatan, {
                type: 'pie',
                data: {
                    labels: jabatanLabels,
                    datasets: [{
                        label: 'Jumlah Pegawai',
                        data: jabatanData,
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
