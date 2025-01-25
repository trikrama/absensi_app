<form action="/konfigurasi/updatejamkerja" method="POST" id="frmJK_edit">
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
                <input type="text" id="kode_jam_kerja_edit" name="kode_jam_kerja" value="{{ $jamkerja->kode_jam_kerja }}"
                    class="form-control" placeholder="Kode Jam Kerja" name="kode_jam_kerja_edit">
            </div>
        </div>
    </div>
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
                <input type="text" value="{{ $jamkerja->nama_jam_kerja }}" id="nama_jam_kerja_edit"
                    class="form-control" placeholder="Nama Jam Kerja" name="nama_jam_kerja">
            </div>
        </div>
    </div>
    {{-- --- --}}
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <!-- Label untuk input waktu -->
                <label for="awal_jam_masuk" class="form-label d-block text-muted mb-2">
                    Awal Jam Masuk
                </label>
                <div class="input-icon">
                    <span class="input-icon-addon">
                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                            <path d="M12 10l0 3l2 0"></path>
                            <path d="M7 4l-2.75 2"></path>
                            <path d="M17 4l2.75 2"></path>
                        </svg>
                    </span>
                        <input type="time" id="awal_jam_masuk_edit" 
                        value="{{ $jamkerja->awal_jam_masuk }}"
                        class="form-control" 
                        placeholder="Awal Jam Masuk" 
                        name="awal_jam_masuk"
                        min="00:00" 
                        max="23:59">    
                </div>
            </div>
        </div>
    </div>
    {{-- --- --}}
    {{-- <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M12 10l0 3l2 0"></path>
                        <path d="M7 4l-2.75 2"></path>
                        <path d="M17 4l2.75 2"></path>
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->awal_jam_masuk }}" id="awal_jam_masuk_edit"
                    class="form-control" placeholder="Awal Jam Masuk" name="awal_jam_masuk">
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <!-- Label untuk input waktu -->
                <label for="jam_masuk" class="form-label d-block text-muted mb-2">
                    Jam Masuk
                </label>
                <div class="input-icon ">
                    <span class="input-icon-addon">
                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                            <path d="M12 10l0 3l2 0"></path>
                            <path d="M7 4l-2.75 2"></path>
                            <path d="M17 4l2.75 2"></path>
                        </svg>
                    </span>
                        <input type="time" id="jam_masuk_edit" 
                        value="{{ $jamkerja->jam_masuk }}"
                        class="form-control" 
                        placeholder="Jam Masuk" 
                        name="jam_masuk"
                        min="00:00" 
                        max="23:59">
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M12 10l0 3l2 0"></path>
                        <path d="M7 4l-2.75 2"></path>
                        <path d="M17 4l2.75 2"></path>
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->jam_masuk }}" id="jam_masuk_edit" class="form-control"
                    placeholder="Jam Masuk" name="jam_masuk">
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <!-- Label untuk input waktu -->
                <label for="akhir_jam_masuk" class="form-label d-block text-muted mb-2">
                    Akhir Jam Masuk
                </label>
                
                <div class="input-icon">
                    <span class="input-icon-addon">
                        <!-- SVG icon alarm -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                            <path d="M12 10l0 3l2 0"></path>
                            <path d="M7 4l-2.75 2"></path>
                            <path d="M17 4l2.75 2"></path>
                        </svg>
                    </span>
                    <input type="time" id="akhir_jam_masuk_edit" 
                        value="{{ $jamkerja->akhir_jam_masuk }}"
                        class="form-control" 
                        placeholder="Akhir Jam Masuk" 
                        name="akhir_jam_masuk"
                        min="00:00" 
                        max="23:59">
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M12 10l0 3l2 0"></path>
                        <path d="M7 4l-2.75 2"></path>
                        <path d="M17 4l2.75 2"></path>
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->akhir_jam_masuk }}" id="akhir_jam_masuk_edit"
                    class="form-control" placeholder="Akhir Jam Masuk" name="akhir_jam_masuk">
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <!-- Label untuk input waktu -->
                <label for="jam_pulang" class="form-label d-block text-muted mb-2">
                    Jam Pulang
                </label>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                            <path d="M12 10l0 3l2 0"></path>
                            <path d="M7 4l-2.75 2"></path>
                            <path d="M17 4l2.75 2"></path>
                        </svg>
                    </span>
                    <input type="time" id="jam_pulang_edit" 
                        value="{{ $jamkerja->jam_pulang }}"
                        class="form-control" 
                        placeholder="Jam Pulang" 
                        name="jam_pulang"
                        min="00:00" 
                        max="23:59">
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M12 10l0 3l2 0"></path>
                        <path d="M7 4l-2.75 2"></path>
                        <path d="M17 4l2.75 2"></path>
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->jam_pulang }}" id="jam_pulang_edit" class="form-control"
                    placeholder="Jam Pulang" name="jam_pulang">
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M12 10l0 3l2 0"></path>
                        <path d="M7 4l-2.75 2"></path>
                        <path d="M17 4l2.75 2"></path>
                    </svg>
                </span>
                <input type="text" id="total_jam_edit" class="form-control" placeholder="Total Jam"
                    name="total_jam" value="{{ $jamkerja->total_jam }}">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="form-group">
                <select name="status_istirahat" id="status_istirahat_edit" class="form-select">
                    <option value="">Istirahat</option>
                    <option value="1">Ada</option>
                    <option value="0">Tidak</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row setjamistirahat">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M12 10l0 3l2 0"></path>
                        <path d="M7 4l-2.75 2"></path>
                        <path d="M17 4l2.75 2"></path>
                    </svg>
                </span>
                <input type="text" value="" id="awal_jam_istirahat_edit" class="form-control"
                    placeholder="Awal Jam Istirahat" name="awal_jam_istirahat">
            </div>
        </div>
    </div>
    <div class="row setjamistirahat">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alarm" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M12 10l0 3l2 0"></path>
                        <path d="M7 4l-2.75 2"></path>
                        <path d="M17 4l2.75 2"></path>
                    </svg>
                </span>
                <input type="text" value="" id="akhir_jam_istirahat_edit" class="form-control"
                    placeholder="Akhir Jam Istirahat" name="akhir_jam_istirahat">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <select name="lintashari" id="lintashari" class="form-select">
                    <option value="">Lintas Hari</option>
                    <option value="1" {{ $jamkerja->lintashari == 1 ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ $jamkerja->lintashari == 0 ? 'selected' : '' }}>Tidak</option>
                </select>
            </div>
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
    $(function() {
    $("#kode_jam_kerja_edit").mask("AAAA");
    $("#nama_jam_kerja_edit").mask("AAAAAAAAAAAAAA");

    const jamMasukInput = document.getElementById('jam_masuk_edit');
    const jamKeluarInput = document.getElementById('jam_pulang_edit');
    const totalJamInput = document.getElementById('total_jam_edit');

    // Fungsi untuk menghitung total jam kerja
    // function hitungTotalJam() {
    //     const jamMasuk = jamMasukInput.value;
    //     const jamKeluar = jamKeluarInput.value;
        
    //     // Jika kedua waktu sudah diisi
    //     if (jamMasuk && jamKeluar) {
    //         const [masukJam, masukMenit] = jamMasuk.split(':').map(num => parseInt(num));
    //         const [keluarJam, keluarMenit] = jamKeluar.split(':').map(num => parseInt(num));

    //         // Membuat objek Date untuk jam masuk dan keluar
    //         const masukDate = new Date(0, 0, 0, masukJam, masukMenit); 
    //         const keluarDate = new Date(0, 0, 0, keluarJam, keluarMenit);

    //         // Menghitung selisih waktu (dalam menit)
    //         const diff = (keluarDate - masukDate) / 60000;

    //         // Jika keluar lebih awal dari masuk (misal jam keluar setelah tengah malam), tambah 24 jam
    //         if (diff < 0) {
    //             keluarDate.setHours(keluarDate.getHours() + 24);
    //         }

    //         // Hitung total jam dan menit
    //         const totalJam = Math.floor(diff / 60);
    //         const totalMenit = diff % 60;

    //         // Tampilkan total jam dan menit
    //         // totalJamInput.value = `${totalJam} jam ${totalMenit} menit`;
    //         totalJamInput.value = totalJam;
    //     } else {
    //         totalJamInput.value = '';
    //     }
    // }

    function hitungTotalJam() {
                const jamMasuk = jamMasukInput.value;
                const jamKeluar = jamKeluarInput.value;

                if (jamMasuk && jamKeluar) {
                    const [masukJam, masukMenit] = jamMasuk.split(':').map(num => parseInt(num, 10));
                    const [keluarJam, keluarMenit] = jamKeluar.split(':').map(num => parseInt(num, 10));

                    // Membuat objek Date untuk jam masuk dan keluar
                    const masukDate = new Date(0, 0, 0, masukJam, masukMenit);
                    const keluarDate = new Date(0, 0, 0, keluarJam, keluarMenit);

                    if (keluarDate <= masukDate) {
                        keluarDate.setDate(keluarDate.getDate() + 1); // Tambahkan 1 hari ke jam keluar
                    }

                    // Menghitung selisih waktu kerja (dalam menit)
                    let diff = (keluarDate - masukDate) / 60000;

                    // Periksa status istirahat
                    // if (statusIstirahat.value === "1") {
                    //     const awalIstirahat = awalJamIstirahat.value;
                    //     const akhirIstirahat = akhirJamIstirahat.value;

                    //     if (awalIstirahat && akhirIstirahat) {
                    //         const [istirahatAwalJam, istirahatAwalMenit] = awalIstirahat.split(':').map(num => parseInt(num, 10));
                    //         const [istirahatAkhirJam, istirahatAkhirMenit] = akhirIstirahat.split(':').map(num => parseInt(num, 10));

                    //         const istirahatAwalDate = new Date(0, 0, 0, istirahatAwalJam, istirahatAwalMenit);
                    //         const istirahatAkhirDate = new Date(0, 0, 0, istirahatAkhirJam, istirahatAkhirMenit);

                    //         if (istirahatAkhirDate <= istirahatAwalDate) {
                    //             istirahatAkhirDate.setDate(istirahatAkhirDate.getDate() + 1); // Tambahkan 1 hari ke akhir istirahat
                    //         }

                    //         const istirahatDiff = (istirahatAkhirDate - istirahatAwalDate) / 60000;

                    //         // Kurangi waktu istirahat dari total waktu kerja
                    //         diff -= istirahatDiff;
                    //     }
                    // }

                    // Hitung total jam dan menit
                    const totalJam = Math.floor(diff / 60);
                    const totalMenit = diff % 60;

                    // Tampilkan total jam dan menit di input dan set atribut data-totaljam
                    totalJamInput.value = `${totalJam}`;
                    totalJamInput.setAttribute('data-totaljam', totalJam);
                } else {
                    // Kosongkan input dan atribut jika salah satu waktu belum diisi
                    totalJamInput.value = '';
                    totalJamInput.removeAttribute('data-totaljam');
                }
            }

    // Event listener untuk input jam masuk dan keluar
    jamMasukInput.addEventListener('input', hitungTotalJam);
    jamKeluarInput.addEventListener('input', hitungTotalJam);
            
    function showsetjamistirahat() {
        var status_istirahat = $("#status_istirahat_edit").val();
        if (status_istirahat == "1") {
            $(".setjamistirahat").show();
        } else {
            $(".setjamistirahat").hide();
        }
    }

    $("#status_istirahat_edit").change(function() {
        showsetjamistirahat();
    });
    showsetjamistirahat();
    $("#awal_jam_masuk_edit, #jam_masuk_edit, #akhir_jam_masuk_edit, #jam_pulang_edit,#awal_jam_istirahat_edit,#akhir_jam_istirahat_edit")
        .mask("00:00");
    $("#frmJK_edit").submit(function() {
        var kode_jam_kerja = $("#kode_jam_kerja_edit").val();
        var nama_jam_kerja = $("#nama_jam_kerja_edit").val();
        var awal_jam_masuk = $("#awal_jam_masuk_edit").val();
        var jam_masuk = $("#jam_masuk_edit").val();
        var akhir_jam_masuk = $("#akhir_jam_masuk_edit").val();
        var jam_pulang = $("#jam_pulang_edit").val();
        var total_jam = $("#total_jam_edit").val();
        var lintashari = $("#lintashari_edit").val();
        var awal_jam_istirahat = $("#awal_jam_istirahat_edit").val();
        var akhir_jam_istirahat = $("#akhir_jam_istirahat_edit").val();
        var status_istirahat = $("#status_istirahat_edit").val();
        if (kode_jam_kerja == "") {
            // alert('Nik Harus Diisi');
            Swal.fire({
                title: 'Warning!',
                text: 'Kode Jam Kerja Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#kode_jam_kerja").focus();
            });

            return false;
        } else if (nama_jam_kerja == "") {
            // alert('Nik Harus Diisi');
            Swal.fire({
                title: 'Warning!',
                text: 'Nama Jam Kerja Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nama_jam_kerja").focus();
            });

            return false;
        } else if (awal_jam_masuk == "") {
            // alert('Nik Harus Diisi');
            Swal.fire({
                title: 'Warning!',
                text: 'Awal Jam Masuk Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#awal_jam_masuk").focus();
            });

            return false;
        } else if (jam_masuk == "") {
            // alert('Nik Harus Diisi');
            Swal.fire({
                title: 'Warning!',
                text: 'Jam Masuk Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#jam_masuk").focus();
            });

            return false;
        } else if (akhir_jam_masuk == "") {
            // alert('Nik Harus Diisi');
            Swal.fire({
                title: 'Warning!',
                text: 'Akhir Masuk Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#akhir_jam_masuk").focus();
            });

            return false;
        } else if (status_istirahat === "") {

            Swal.fire({
                title: 'Warning!',
                text: 'Status Istirahat Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#status_istirahat").focus();
            });

            return false;
        } else if (awal_jam_istirahat == "" && status_istirahat == "1") {

            Swal.fire({
                title: 'Warning!',
                text: 'Jam Awal Istirahat Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#awal_jam_istirahat").focus();
            });

            return false;
        } else if (akhir_jam_istirahat == "" && status_istirahat == "1") {
            // alert('Nik Harus Diisi');
            Swal.fire({
                title: 'Warning!',
                text: 'Jam Akhir Istirahat Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#akhir_jam_istirahat").focus();
            });

            return false;
        } else if (jam_pulang == "") {
            // alert('Nik Harus Diisi');
            Swal.fire({
                title: 'Warning!',
                text: 'Jam Pulang Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#jam_pulang").focus();
            });

            return false;
        } else if (total_jam == "") {
            // alert('Nik Harus Diisi');
            Swal.fire({
                title: 'Warning!',
                text: 'Total Jam Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#total_jam").focus();
            });

            return false;
        } else if (lintashari == "") {
            // alert('Nik Harus Diisi');
            Swal.fire({
                title: 'Warning!',
                text: 'Lintas Hari Harus Diisi !',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#lintashari").focus();
            });

            return false;
        }
    });
});

</script>
