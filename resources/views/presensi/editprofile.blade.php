@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Edit Profile</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection

@section('content')

<form action="/presensi/{{ $karyawan->nik }}/updateprofile" method="POST" enctype="multipart/form-data" style="margin-top:70px">
    @csrf
    <div class="col" style="margin-bottom: 70px;">
        @php
        $messagesuccess = Session::get('success');
        $messageerror = Session::get('error');
        @endphp
        @if (Session::get('success'))
        <div class="alert alert-success">
            {{ $messagesuccess }}
        </div>
        @endif
        @if (Session::get('error'))
        <div class="alert alert-warning">
            {{ $messageerror }}
        </div>
        @endif

        @error('foto')
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
        @enderror
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $karyawan->nama_lengkap }}" name="nama_lengkap" placeholder="Nama Lengkap" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="text" class="form-control" value="{{ $karyawan->no_hp }}" name="no_hp" placeholder="No. HP" autocomplete="off">
            </div>
        </div>
        <div class="form-group boxed">
            <div class="input-wrapper">
                <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
            </div>
        </div>

        <div class="custom-file-upload" id="fileUpload1">
            <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
            <label for="fileuploadInput">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                        <i>Tap to Upload</i>
                    </strong>
                </span>
            </label>
        </div>

        <!-- Tempat Lahir -->
        <div class="form-group boxed">
            <label for="tempat_lahir">Tempat Lahir</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $profil->tempat_lahir ?? '' }}" placeholder="Tempat Lahir">
            </div>
        </div>

        <!-- Tanggal Lahir -->
        <div class="form-group boxed">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <div class="input-wrapper">
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $profil->tanggal_lahir ?? '' }}" placeholder="Tanggal Lahir">
            </div>
        </div>

        <!-- Nama Ibu Kandung -->
        <div class="form-group boxed">
            <label for="nama_ibu_kandung">Nama Ibu Kandung</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="nama_ibu_kandung" name="nama_ibu_kandung" value="{{ $profil->nama_ibu_kandung ?? '' }}" placeholder="Nama Ibu Kandung">
            </div>
        </div>

        <!-- Jenis Kelamin -->
        <div class="form-group boxed">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <div class="input-wrapper">
                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                    <option value="l" {{ (isset($profil->jenis_kelamin) && $profil->jenis_kelamin == 'l') ? 'selected' : '' }}>Laki-laki</option>
                    <option value="p" {{ (isset($profil->jenis_kelamin) && $profil->jenis_kelamin == 'p') ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>

        <!-- Agama -->
        <div class="form-group boxed">
            <label for="agama">Agama</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="agama" name="agama" value="{{ $profil->agama ?? '' }}" placeholder="Agama">
            </div>
        </div>

        <!-- Status Menikah -->
        <div class="form-group boxed">
            <label for="status_menikah">Status Menikah</label>
            <div class="input-wrapper">
                <select id="status_menikah" name="status_menikah" class="form-control">
                    <option value="0" {{ (isset($profil->status_menikah) && $profil->status_menikah == '0') ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="1" {{ (isset($profil->status_menikah) && $profil->status_menikah == '1') ? 'selected' : '' }}>Menikah</option>
                </select>
            </div>
        </div>

        <!-- Alamat KTP -->
        <div class="form-group boxed">
            <label for="alamat_ktp">Alamat KTP</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="alamat_ktp" name="alamat_ktp" value="{{ $profil->alamat_ktp ?? '' }}" placeholder="Alamat KTP">
            </div>
        </div>

        <!-- Nomor KK -->
        <div class="form-group boxed">
            <label for="nomor_kk">Nomor KK</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="nomor_kk" name="nomor_kk" value="{{ $profil->nomor_kk ?? '' }}" placeholder="Nomor KK">
            </div>
        </div>

        <!-- Pendidikan Terakhir -->
        <div class="form-group boxed">
            <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" value="{{ $profil->pendidikan_terakhir ?? '' }}" placeholder="Pendidikan Terakhir">
            </div>
        </div>

        <!-- Institusi Pendidikan -->
        <div class="form-group boxed">
            <label for="institusi">Institusi Pendidikan</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="institusi" name="institusi" value="{{ $profil->institusi ?? '' }}" placeholder="Institusi Pendidikan">
            </div>
        </div>

        <!-- Masa Aktif SIM -->
        <div class="form-group boxed">
            <label for="masa_aktif_sim">Masa Aktif SIM</label>
            <div class="input-wrapper">
                <input type="date" class="form-control" id="masa_aktif_sim" name="masa_aktif_sim" value="{{ $profil->masa_aktif_sim ?? '' }}" placeholder="Masa Aktif SIM">
            </div>
        </div>

        <!-- Pendidikan Satpam -->
        <div class="form-group boxed">
            <label for="pendidikan_satpam">Pendidikan Satpam</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="pendidikan_satpam" name="pendidikan_satpam" value="{{ $profil->pendidikan_satpam ?? '' }}" placeholder="Pendidikan Satpam">
            </div>
        </div>

        <!-- Tahun Pelatihan -->
        <div class="form-group boxed">
            <label for="tahun_pelatihan">Tahun Pelatihan</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="tahun_pelatihan" name="tahun_pelatihan" value="{{ $profil->tahun_pelatihan ?? '' }}" placeholder="Tahun Pelatihan">
            </div>
        </div>

        <!-- Nomor KTA -->
        <div class="form-group boxed">
            <label for="no_kta">Nomor KTA</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="no_kta" name="no_kta" value="{{ $profil->no_kta ?? '' }}" placeholder="Nomor KTA">
            </div>
        </div>

        <!-- Penerbit KTA -->
        <div class="form-group boxed">
            <label for="penerbit_kta">Penerbit KTA</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="penerbit_kta" name="penerbit_kta" value="{{ $profil->penerbit_kta ?? '' }}" placeholder="Penerbit KTA">
            </div>
        </div>

        <!-- Masa Aktif KTA -->
        <div class="form-group boxed">
            <label for="masa_aktif_kta">Masa Aktif KTA</label>
            <div class="input-wrapper">
                <input type="date" class="form-control" id="masa_aktif_kta" name="masa_aktif_kta" value="{{ $profil->masa_aktif_kta ?? '' }}" placeholder="Masa Aktif KTA">
            </div>
        </div>

        <!-- Nomor Registrasi -->
        <div class="form-group boxed">
            <label for="no_registrasi">Nomor Registrasi</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="no_registrasi" name="no_registrasi" value="{{ $profil->no_registrasi ?? '' }}" placeholder="Nomor Registrasi">
            </div>
        </div>

        <!-- TMT Awal Penugasan -->
        <div class="form-group boxed">
            <label for="tmt_awal_penugasan">TMT Awal Penugasan</label>
            <div class="input-wrapper">
                <input type="date" class="form-control" id="tmt_awal_penugasan" name="tmt_awal_penugasan" value="{{ $profil->tmt_awal_penugasan ?? '' }}" placeholder="TMT Awal Penugasan">
            </div>
        </div>

        <!-- Nama Bank -->
        <div class="form-group boxed">
            <label for="nama_bank">Nama Bank</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="nama_bank" name="nama_bank" value="{{ $profil->nama_bank ?? '' }}" placeholder="Nama Bank">
            </div>
        </div>

        <!-- Nomor Rekening -->
        <div class="form-group boxed">
            <label for="no_rekening">Nomor Rekening</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="{{ $profil->no_rekening ?? '' }}" placeholder="Nomor Rekening">
            </div>
        </div>

        <!-- Nomor BPJS Kesehatan -->
        <div class="form-group boxed">
            <label for="no_bpjs_kesehatan">Nomor BPJS Kesehatan</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="no_bpjs_kesehatan" name="no_bpjs_kesehatan" value="{{ $profil->no_bpjs_kesehatan ?? '' }}" placeholder="Nomor BPJS Kesehatan">
            </div>
        </div>

        <!-- Nomor BPJS Ketenagakerjaan -->
        <div class="form-group boxed">
            <label for="no_bpjs_ketenagakerjaan">Nomor BPJS Ketenagakerjaan</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" id="no_bpjs_ketenagakerjaan" name="no_bpjs_ketenagakerjaan" value="{{ $profil->no_bpjs_ketenagakerjaan ?? '' }}" placeholder="Nomor BPJS Ketenagakerjaan">
            </div>
        </div>


        <!-- Nomor NPWP -->
        <div class="form-group boxed">
            <label for="no_npwp">Nomor NPWP</label>
            <div class="input-wrapper">
                <input type="text" class="form-control" name="no_npwp" value="{{ $profil->no_npwp ?? '' }}" placeholder="Nomor NPWP">
            </div>
        </div>

        <div class="form-group boxed">
            <div class="input-wrapper">
                <button type="submit" class="btn btn-primary btn-block">
                    <ion-icon name="refresh-outline"></ion-icon>
                    Update
                </button>
            </div>
        </div>

    </div>
</form>
@endsection
