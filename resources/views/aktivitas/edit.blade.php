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
    <div class="pageTitle">Edit Aktivitas</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection

@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        <!-- Form untuk Edit Aktivitas -->
        <form method="POST" action="{{ route('aktivitas.update', $aktivitas->id) }}" id="frmAktivitas" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="text" id="tanggal_aktivitas" autocomplete="off" name="tanggal_aktivitas" class="form-control datepicker" placeholder="Tanggal Aktivitas" value="{{ $aktivitas->tanggal_aktivitas }}">
            </div>
            <div class="form-group">
                <input type="text" id="waktu_aktivitas" name="waktu_aktivitas" class="form-control timepicker" placeholder="Waktu Aktivitas" value="{{ $aktivitas->waktu_aktivitas }}">
            </div>
            <div class="form-group">
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" autocomplete="off" placeholder="Deskripsi" value="{{ $aktivitas->deskripsi }}">
            </div>
            <div class="custom-file-upload" id="fileUpload1" style="height: 100px !important">
                <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                <label for="fileuploadInput">
                    <span>
                        <strong>
                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                            <i>Tap to Upload Foto (Kosongkan jika tidak ingin mengubah)</i>
                        </strong>
                    </span>
                </label>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100">Update Aktivitas</button>
            </div>
        </form>
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