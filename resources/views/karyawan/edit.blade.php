<form action="/karyawan/{{ Crypt::encrypt($karyawan->nik) }}/update" method="POST" id="frmEditkaryawan"
    enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                        <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                        <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                        <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                        <path d="M5 11h1v2h-1z"></path>
                        <path d="M10 11l0 2"></path>
                        <path d="M14 11h1v2h-1z"></path>
                        <path d="M19 11l0 2"></path>
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->nik }}" id="nik" class="form-control" placeholder="Nik"
                    name="nik_baru">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    </svg>
                </span>
                <input type="text" id="nama_lengkap" value="{{ $karyawan->nama_lengkap }}" class="form-control"
                    name="nama_lengkap" placeholder="Nama Lengkap">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-analytics"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z">
                        </path>
                        <path d="M7 20l10 0"></path>
                        <path d="M9 16l0 4"></path>
                        <path d="M15 16l0 4"></path>
                        <path d="M8 12l3 -3l2 2l3 -3"></path>
                    </svg>
                </span>
                <input type="text" id="jabatan" value="{{ $karyawan->jabatan }}" class="form-control"
                    name="jabatan" placeholder="Jabatan">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                            d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                        </path>
                    </svg>
                </span>
                <input type="text" id="no_hp" value="{{ $karyawan->no_hp }}" class="form-control" name="no_hp"
                    placeholder="No. HP">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <input type="file" name="foto" class="form-control">
            <input type="hidden" name="old_foto" value="{{ $karyawan->foto }}">
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <select name="kode_dept" id="kode_dept" class="form-select">
                <option value="">Departemen</option>
                @foreach ($departemen as $d)
                    <option {{ $karyawan->kode_dept == $d->kode_dept ? 'selected' : '' }} value="{{ $d->kode_dept }}">
                        {{ $d->nama_dept }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <select name="kode_cabang" id="kode_cabang" class="form-select">
                <option value="">Cabang</option>
                @foreach ($cabang as $d)
                    <option {{ $karyawan->kode_cabang == $d->kode_cabang ? 'selected' : '' }}
                        value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Tempat Lahir -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('tempat_lahir', $profil->tempat_lahir ?? '') }}" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
        </div>
    </div>

    <!-- Tanggal Lahir -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="date" value="{{ old('tanggal_lahir', $profil->tanggal_lahir ?? '') }}" id="tanggal_lahir" name="tanggal_lahir" class="form-control">
        </div>
    </div>

    <!-- Nama Ibu Kandung -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('nama_ibu_kandung', $profil->nama_ibu_kandung ?? '') }}" id="nama_ibu_kandung" name="nama_ibu_kandung" class="form-control" placeholder="Nama Ibu Kandung">
        </div>
    </div>

    <!-- Jenis Kelamin -->
    <div class="row mt-2">
        <div class="col-12">
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                <option value="">Jenis Kelamin</option>
                <option value="l" {{ old('jenis_kelamin', $profil->jenis_kelamin ) == 'l' ? 'selected' : '' }}>Laki-laki</option>
                <option value="p" {{ old('jenis_kelamin', $profil->jenis_kelamin ) == 'p' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
    </div>

    <!-- Agama -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('agama', $profil->agama ?? '') }}" id="agama" name="agama" class="form-control" placeholder="Agama">
        </div>
    </div>

    <!-- Status Menikah -->
    <div class="row mt-2">
        <div class="col-12">
            <select name="status_menikah" id="status_menikah" class="form-select">
                <option value="">Status Menikah</option>
                <option value="0" {{ old('status_menikah', $profil->status_menikah) == '0' ? 'selected' : '' }}>Belum Menikah</option>
                <option value="1" {{ old('status_menikah', $profil->status_menikah) == '1' ? 'selected' : '' }}>Menikah</option>
            </select>
        </div>
    </div>
    

    <!-- Alamat KTP -->
    <div class="row mt-2">
        <div class="col-12">
            <textarea name="alamat_ktp" id="alamat_ktp" class="form-control" placeholder="Alamat KTP">{{ old('alamat_ktp', $profil->alamat_ktp ?? '') }}</textarea>
        </div>
    </div>

    <!-- Nomor KK -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('nomor_kk', $profil->nomor_kk ?? '') }}" id="nomor_kk" name="nomor_kk" class="form-control" placeholder="Nomor KK">
        </div>
    </div>

    <!-- Pendidikan Terakhir -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('pendidikan_terakhir', $profil->pendidikan_terakhir ?? '') }}" id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-control" placeholder="Pendidikan Terakhir">
        </div>
    </div>

    <!-- Institusi -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('institusi', $profil->institusi ?? '') }}" id="institusi" name="institusi" class="form-control" placeholder="Institusi">
        </div>
    </div>

    <!-- Masa Aktif SIM -->
    <div class="row mt-2">
        <div class="col-12">
            {{-- <input type="date" id="masa_aktif_sim" name="masa_aktif_sim" class="form-control" placeholder="Masa Aktif SIM"> --}}
            <input type="text" value="{{ old('masa_aktif_sim', $profil->masa_aktif_sim ?? '') }}" id="masa_aktif_sim" name="masa_aktif_sim" placeholder="Masa Aktif SIM" class="form-control"
                onfocus="(this.type='date')" onblur="(this.type='text'); if(!this.value){this.placeholder='Masa Aktif SIM';}">

        </div>
    </div>

    <!-- Pendidikan Satpam -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('pendidikan_satpam', $profil->pendidikan_satpam ?? '') }}" id="pendidikan_satpam" name="pendidikan_satpam" class="form-control" placeholder="Pendidikan Satpam">
        </div>
    </div>

    <!-- Tahun Pelatihan -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="number" value="{{ old('tahun_pelatihan', $profil->tahun_pelatihan ?? '') }}" id="tahun_pelatihan" name="tahun_pelatihan" class="form-control" placeholder="Tahun Pelatihan">
        </div>
    </div>

    <!-- No KTA -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('no_kta', $profil->no_kta ?? '') }}" id="no_kta" name="no_kta" class="form-control" placeholder="No KTA">
        </div>
    </div>

    <!-- Penerbit KTA -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('penerbit_kta', $profil->penerbit_kta ?? '') }}" id="penerbit_kta" name="penerbit_kta" class="form-control" placeholder="Penerbit KTA">
        </div>
    </div>

    <!-- Masa Aktif KTA -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="date" value="{{ old('masa_aktif_kta', $profil->masa_aktif_kta ?? '') }}" id="masa_aktif_kta" name="masa_aktif_kta" class="form-control">
        </div>
    </div>

    <!-- No Registrasi -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('no_registrasi', $profil->no_registrasi ?? '') }}" id="no_registrasi" name="no_registrasi" class="form-control" placeholder="No Registrasi">
        </div>
    </div>

    <!-- TMT Awal Penugasan -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="date" value="{{ old('tmt_awal_penugasan', $profil->tmt_awal_penugasan ?? '') }}" id="tmt_awal_penugasan" name="tmt_awal_penugasan" class="form-control">
        </div>
    </div>

    <!-- Nama Bank -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('nama_bank', $profil->nama_bank ?? '') }}" id="nama_bank" name="nama_bank" class="form-control" placeholder="Nama Bank">
        </div>
    </div>

    <!-- No Rekening -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('no_rekening', $profil->no_rekening ?? '') }}"  id="no_rekening" name="no_rekening" class="form-control" placeholder="No Rekening">
        </div>
    </div>

    <!-- No BPJS Kesehatan -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('no_bpjs_kesehatan', $profil->no_bpjs_kesehatan ?? '') }}" id="no_bpjs_kesehatan" name="no_bpjs_kesehatan" class="form-control" placeholder="No BPJS Kesehatan">
        </div>
    </div>

    <!-- No BPJS Ketenagakerjaan -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('no_bpjs_ketenagakerjaan', $profil->no_bpjs_ketenagakerjaan ?? '') }}" id="no_bpjs_ketenagakerjaan" name="no_bpjs_ketenagakerjaan" class="form-control" placeholder="No BPJS Ketenagakerjaan">
        </div>
    </div>

    <!-- No NPWP -->
    <div class="row mt-2">
        <div class="col-12">
            <input type="text" value="{{ old('no_npwp', $profil->no_npwp ?? '') }}" id="no_npwp" name="no_npwp" class="form-control" placeholder="No NPWP">
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 14l11 -11"></path>
                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                    </svg>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    $("#frmEditkaryawan").submit(function() {
        var nik = $("#frmEditkaryawan").find("#nik").val();
        var nama_lengkap = $("#frmEditkaryawan").find("#nama_lengkap").val();
        var jabatan = $("#frmEditkaryawan").find("#jabatan").val();
        var no_hp = $("#frmEditkaryawan").find("#no_hp").val();
        var kode_dept = $("#frmEditkaryawan").find("#kode_dept").val();
        var kode_cabang = $("#frmEditkaryawan").find("#kode_cabang").val();

        // Validasi Data Profil
        var tempat_lahir = $("#frmEditkaryawan").find("#tempat_lahir").val();
        var tanggal_lahir = $("#frmEditkaryawan").find("#tanggal_lahir").val();
        var nama_ibu_kandung = $("#frmEditkaryawan").find("#nama_ibu_kandung").val();
        var jenis_kelamin = $("#frmEditkaryawan").find("#jenis_kelamin").val();
        var agama = $("#frmEditkaryawan").find("#agama").val();
        var status_menikah = $("#frmEditkaryawan").find("#status_menikah").val();
        var alamat_ktp = $("#frmEditkaryawan").find("#alamat_ktp").val();
        var nomor_kk = $("#frmEditkaryawan").find("#nomor_kk").val();
        var pendidikan_terakhir = $("#frmEditkaryawan").find("#pendidikan_terakhir").val();
        var institusi = $("#frmEditkaryawan").find("#institusi").val();
        var masa_aktif_sim = $("#frmEditkaryawan").find("#masa_aktif_sim").val();
        var pendidikan_satpam = $("#frmEditkaryawan").find("#pendidikan_satpam").val();
        var tahun_pelatihan = $("#frmEditkaryawan").find("#tahun_pelatihan").val();
        var no_kta = $("#frmEditkaryawan").find("#no_kta").val();
        var penerbit_kta = $("#frmEditkaryawan").find("#penerbit_kta").val();
        var masa_aktif_kta = $("#frmEditkaryawan").find("#masa_aktif_kta").val();
        var no_registrasi = $("#frmEditkaryawan").find("#no_registrasi").val();
        var tmt_awal_penugasan = $("#frmEditkaryawan").find("#tmt_awal_penugasan").val();
        var nama_bank = $("#frmEditkaryawan").find("#nama_bank").val();
        var no_rekening = $("#frmEditkaryawan").find("#no_rekening").val();
        var no_bpjs_kesehatan = $("#frmEditkaryawan").find("#no_bpjs_kesehatan").val();
        var no_bpjs_ketenagakerjaan = $("#frmEditkaryawan").find("#no_bpjs_ketenagakerjaan").val();
        var no_npwp = $("#frmEditkaryawan").find("#no_npwp").val();


        if (nik == "") {
            // alert('Nik Harus Diisi');
            Swal.fire({
                title: 'Warning!',
                text: 'Nik Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nik").focus();
            });

            return false;
        } else if (nama_lengkap == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Nama Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nama_lengkap").focus();
            });

            return false;
        } else if (jabatan == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Jabatan Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#jabatan").focus();
            });

            return false;
        } else if (no_hp == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'No. HP Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_hp").focus();
            });

            return false;
        } else if (kode_dept == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Departemen Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#kode_dept").focus();
            });

            return false;
        } else if (kode_cabang == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Cabang Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#kode_cabang").focus();
            });

            return false;
        } else if (tempat_lahir == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Tempat Lahir Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#tempat_lahir").focus();
            });
            return false;
        } else if (tanggal_lahir == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Tanggal Lahir Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#tanggal_lahir").focus();
            });
            return false;
        } else if (nama_ibu_kandung == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Nama Ibu Kandung Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nama_ibu_kandung").focus();
            });
            return false;
        } else if (jenis_kelamin == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Jenis Kelamin Harus Dipilih!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#jenis_kelamin").focus();
            });
            return false;
        } else if (agama == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Agama Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#agama").focus();
            });
            return false;
        } else if (status_menikah == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Status Menikah Harus Dipilih!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#status_menikah").focus();
            });
            return false;
        } else if (alamat_ktp == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Alamat KTP Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#alamat_ktp").focus();
            });
            return false;
        } else if (nomor_kk == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Nomor KK Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nomor_kk").focus();
            });
            return false;
        } else if (pendidikan_terakhir == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Pendidikan Terakhir Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#pendidikan_terakhir").focus();
            });
            return false;
        } else if (institusi == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Institusi Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#institusi").focus();
            });
            return false;
        } else if (masa_aktif_sim == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Masa Aktif SIM Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#masa_aktif_sim").focus();
            });
            return false;
        } else if (pendidikan_satpam == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Pendidikan Satpam Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#pendidikan_satpam").focus();
            });
            return false;
        } else if (tahun_pelatihan == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Tahun Pelatihan Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#tahun_pelatihan").focus();
            });
            return false;
        } else if (no_kta == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'No. KTA Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_kta").focus();
            });
            return false;
        } else if (penerbit_kta == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Penerbit KTA Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#penerbit_kta").focus();
            });
            return false;
        } else if (masa_aktif_kta == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Masa Aktif KTA Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#masa_aktif_kta").focus();
            });
            return false;
        } else if (no_registrasi == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'No. Registrasi Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_registrasi").focus();
            });
            return false;
        } else if (tmt_awal_penugasan == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'TMT Awal Penugasan Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#tmt_awal_penugasan").focus();
            });
            return false;
        } else if (nama_bank == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'Nama Bank Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nama_bank").focus();
            });
            return false;
        } else if (no_rekening == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'No. Rekening Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_rekening").focus();
            });
            return false;
        } else if (no_bpjs_kesehatan == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'No. BPJS Kesehatan Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_bpjs_kesehatan").focus();
            });
            return false;
        } else if (no_bpjs_ketenagakerjaan == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'No. BPJS Ketenagakerjaan Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_bpjs_ketenagakerjaan").focus();
            });
            return false;
        } else if (no_npwp == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'No. NPWP Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_npwp").focus();
            });
            return false;
        } else if (no_bpjs_kesehatan == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'No. BPJS Kesehatan Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_bpjs_kesehatan").focus();
            });
            return false;
        } else if (no_bpjs_ketenagakerjaan == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'No. BPJS Ketenagakerjaan Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_bpjs_ketenagakerjaan").focus();
            });
            return false;
        } else if (no_npwp == "") {
            Swal.fire({
                title: 'Warning!',
                text: 'No. NPWP Harus Diisi!',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_npwp").focus();
            });
            return false;
        } 
    });
</script>
