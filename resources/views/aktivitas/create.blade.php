@extends('layouts.presensi')

@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal {
        max-height: 430px !important;
    }

    .datepicker-date-display {
        background-color: #0f3a7e !important;
    }

    #deskripsi {
        height: 5rem !important;
    }
</style>
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Input Aktivitas</div>
    <div class="right"></div>
</div>
<div class="row">
    <div class="col-12">
        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::get('error'))
            <div class="alert alert-warning">
                {{ Session::get('warning') }}
            </div>
        @endif
    </div>
</div>
<!-- * App Header -->
@endsection


@section('content')
<div class="row" style="margin-top:70px; margin-bottom: 70px">
    <div class="col">
        <!-- Form untuk Input Aktivitas -->
        <form method="POST" action="{{ route('aktivitas.store') }}" id="frmAktivitas" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" id="tanggal_aktivitas" autocomplete="off" name="tanggal_aktivitas" class="form-control datepicker" placeholder="Tanggal Aktivitas">
            </div>
            <div class="form-group">
                <input type="text" id="waktu_aktivitas" name="waktu_aktivitas" class="form-control timepicker" placeholder="Waktu Aktivitas">
            </div>
            <div class="form-group">
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" autocomplete="off" placeholder="Deskripsi">
            </div>
            <div class="custom-file-upload" id="fileUpload1" style="height: 100px !important">
                <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                <label for="fileuploadInput">
                    <span>
                        <strong>
                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                            <i>Tap to Upload Foto</i>
                        </strong>
                    </span>
                </label>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100">Simpan Aktivitas</button>
            </div>
        </form>

        <div class="filter-section" style="margin-top: 30px;">
            <form method="GET" action="{{ route('aktivitas.create') }}" class="row">
                <div class="form-group col-md-6">
                    <input type="text" name="from_date" class="form-control datepicker" placeholder="Dari Tanggal" required>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" name="to_date" class="form-control datepicker" placeholder="Sampai Tanggal" required>
                </div>
                <div class="form-group col-md-12">
                    <button class="btn btn-secondary w-100">Filter Aktivitas</button>
                </div>
            </form>
        </div>

        <!-- Menampilkan Aktivitas Bulan Ini -->
        <h5 style="margin-top: 30px;">Aktivitas Bulan Ini</h5>
        <table class="striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aktivitas as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_aktivitas)->format('d-m-Y') }}</td>
                        <td>{{ $item->waktu_aktivitas }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>
                            <a href="{{ route('aktivitas.edit', $item->id) }}" class="btn btn-warning btn-small">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd",
            autoClose: true // Menutup otomatis setelah memilih tanggal
        });

        $(".timepicker").timepicker({
            timeFormat: 'H:i',
            interval: 30,
            minTime: '0',
            maxTime: '23:59',
            defaultTime: 'now',
            startTime: '0:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $("#frmAktivitas").submit(function() {
            var tanggal_aktivitas = $("#tanggal_aktivitas").val();
            var waktu_aktivitas = $("#waktu_aktivitas").val();
            var deskripsi = $("#deskripsi").val();
            if (tanggal_aktivitas == "") {
                Swal.fire({
                    title: 'Oops !',
                    text: 'Tanggal Aktivitas Harus Diisi',
                    icon: 'warning'
                });
                return false;
            } else if (waktu_aktivitas == "") {
                Swal.fire({
                    title: 'Oops !',
                    text: 'Waktu Aktivitas Harus Diisi',
                    icon: 'warning'
                });
                return false;
            } else if (deskripsi == "") {
                Swal.fire({
                    title: 'Oops !',
                    text: 'Deskripsi Harus Diisi',
                    icon: 'warning'
                });
                return false;
            }
        });
    });
</script>
@endpush