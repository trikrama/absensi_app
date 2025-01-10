<?php

use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\HariliburController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\IzinabsenController;
use App\Http\Controllers\IzincutiController;
use App\Http\Controllers\IzinsakitController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\ManajemenTugasController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\UserController;
use App\Models\Instrument;
use App\Models\Karyawan;
use App\Models\Signature;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Psy\VarDumper\Presenter;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
// use Mews\Captcha\Captcha;
// use Mews\Captcha\Facades\Captcha;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('auth.login'); // Menampilkan halaman login yang telah digabung
    })->name('login');
    Route::get('/captcha', [CaptchaController::class, 'getCaptcha']);

    Route::post('/proseslogin', [AuthController::class, 'proseslogin']); // Proses login untuk kedua peran
});

Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    //Presensi
    Route::get('/presensi/{kode_jam_kerja}/create', [PresensiController::class, 'create']);
    Route::get('/presensi/pilihjamkerja', [PresensiController::class, 'pilihjamkerja']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);
    Route::get('/presensi/scanqr', [PresensiController::class, 'scanqr']);
    Route::post('/presensi/storeqr', [PresensiController::class, 'storeqr']);
    //Edit Profile
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/{nik}/updateprofile', [PresensiController::class, 'updateprofile']);

    //Histori
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);

    //Izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);
    Route::post('/presensi/cekpengajuanizin', [PresensiController::class, 'cekpengajuanizin']);

    //Izin Absen

    Route::get('/izinabsen', [IzinabsenController::class, 'create']);
    Route::post('/izinabsen/store', [IzinabsenController::class, 'store']);
    Route::get('/izinabsen/{kode_izin}/edit', [IzinabsenController::class, 'edit']);
    Route::post('/izinabsen/{kode_izin}/update', [IzinabsenController::class, 'update']);
    //Izin Sakit
    Route::get('/izinsakit', [IzinsakitController::class, 'create']);
    Route::post('/izinsakit/store', [IzinsakitController::class, 'store']);
    Route::get('/izinsakit/{kode_izin}/edit', [IzinsakitController::class, 'edit']);
    Route::post('/izinsakit/{kode_izin}/update', [IzinsakitController::class, 'update']);
    //Izin Cuti
    Route::get('/izincuti', [IzincutiController::class, 'create']);
    Route::post('/izincuti/store', [IzincutiController::class, 'store']);
    Route::get('/izincuti/{kode_izin}/edit', [IzincutiController::class, 'edit']);
    Route::post('/izincuti/{kode_izin}/update', [IzincutiController::class, 'update']);
    Route::post('/izincuti/getmaxcuti', [IzincutiController::class, 'getmaxcuti']);

    Route::get('/izin/{kode_izin}/showact', [PresensiController::class, 'showact']);
    Route::get('/izin/{kode_izin}/delete', [PresensiController::class, 'deleteizin']);

    Route::controller(AktivitasController::class)->group(function () {
        Route::get('/aktivitas/create', 'create')->name('aktivitas.create');
        Route::post('/aktivitas', 'store')->name('aktivitas.store');
        Route::get('/aktivitas', 'index')->name('aktivitas.index');
        Route::get('/aktivitas/{id}/edit', 'edit')->name('aktivitas.edit');
        Route::put('/aktivitas/{id}', 'update')->name('aktivitas.update');
    });
});


//Route Yang Bisa di AKses Oleh Administrator dan Admin Departemen
// Route::middleware(['auth', 'role:administrator|admin departemen,user'])->group(function () {
Route::group(['middleware' => ['role:administrator|admin departemen|pimpinan|koordinator,user']], function () {
    // Route::middleware(['auth:user'])->group(function () {
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogout']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);


    //Karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::get('/karyawan/{nik}/resetpassword', [KaryawanController::class, 'resetpassword']);

    //Konfigruasi Jam Kerja
    Route::get('/konfigurasi/{nik}/setjamkerja', [KonfigurasiController::class, 'setjamkerja']);
    Route::post('/konfigurasi/storesetjamkerja', [KonfigurasiController::class, 'storesetjamkerja']);
    Route::post('/konfigurasi/updatesetjamkerja', [KonfigurasiController::class, 'updatesetjamkerja']);
    Route::post('/konfigurasi/storesetjamkerjabydate', [KonfigurasiController::class, 'storesetjamkerjabydate']);
    Route::get('/konfigurasi/{nik}/{bulan}/{tahun}/getjamkerjabydate', [KonfigurasiController::class, 'getjamkerjabydate']);
    Route::post('/konfigurasi/deletejamkerjabydate', [KonfigurasiController::class, 'deletejamkerjabydate']);
    //Presensi
    Route::get('/presensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/getrekappresensi', [PresensiController::class, 'getrekappresensi']);
    Route::post('/tampilkanpeta', [PresensiController::class, 'tampilkanpeta']);
    Route::get('/presensi/laporan', [PresensiController::class, 'laporan']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap']);
    Route::post('/presensi/cetakrekap', [PresensiController::class, 'cetakrekap']);

    Route::get('/rekap-harian', [PresensiController::class, 'rekapHarian'])->name('rekap.harian');
    Route::post('/rekap-harian', [PresensiController::class, 'rekapHarian']); // Untuk submit export Excel

    Route::get('/rekap/cetak', [PresensiController::class, 'cetakRekapHarian'])->name('rekap.cetak');


    Route::get('/presensi/izinsakit', [PresensiController::class, 'izinsakit']);

    Route::post('/koreksipresensi', [PresensiController::class, 'koreksipresensi']);
    Route::post('/storekoreksipresensi', [PresensiController::class, 'storekoreksipresensi']);

    Route::get('/manajemen_tugas/upload_tugas', [ManajemenTugasController::class, 'index']);
    Route::get('/manajemen_tugas/kunjungan', [ManajemenTugasController::class, 'kunjungan']);

    Route::controller(InstrumentController::class)->group(function () {
        Route::get('/instrument', 'index')->name('instrumen.index');
        Route::get('/instrument/tambah', 'tambah');
        Route::post('/instrument/store', 'store')->name('instrument.store');
        Route::get('/instrument/{id}/edit', 'edit')->name('instrument.edit');
        Route::put('/instrument/{id}', 'update')->name('instrument.update');
        Route::delete('/instrument/{id}/deteteUmum', 'destroyUmum')->name('instrument.destroyUmum');
        Route::delete('/instrument/{id}/deteteKhusus', 'destroyKhusus')->name('instrument.destroyKhusus');
    });
    Route::get('/get-titles', [InstrumentController::class, 'getTitles']);
    Route::controller(InspectionController::class)->group(function () {
        Route::get('/inspection/jadwal', 'index')->name('inspection.jadwal.index');
        Route::post('/inspection/jadwal', 'index');
        Route::get('/inspection/tambah', 'tambah');
        Route::post('/inspection/store', 'store');
        Route::post('/inspection/storeInspection', 'storeInspection')->name('inspection.store');
        Route::get('/inspection/edit/{id}', 'edit')->name('inspection.edit');
        Route::put('/inspection/update/{id}', 'update')->name('inspection.update');
        Route::delete('/inspection/delete/{id}', 'delete')->name('inspection.delete');
        Route::get('/inspection/detail_kunjungan/{id}', 'detail_kunjungan')->name('inspection.detail_kunjungan');
        // Route::get('/inspection/mulai', 'mulai');
        Route::get('/inspection/mulai/{id}', 'mulai');
        Route::get('/inspection/detailInspection/{id}', 'detailInspection');
        Route::get('/get-karyawan-by-dept', 'getKaryawanByDept')->name('get-karyawan-by-dept');
        Route::post('/get-instruments', 'getInstrumentsByDept')->name('get-instruments');
        Route::get('/inspection/detailInspectionEdit/{id}', 'detailInspectionEdit')->name('inspection.detailInspectionEdit');
        Route::put('/inspection/detailInspectionUpdate', 'detailInspectionUpdate')->name('inspection.detailInspectionUpdate');
        Route::delete('/inspection/detailInspectionDelete/{id}', 'detailInspectionDelete')->name('inspection.detailInspectionDelete');
        
        Route::get('/inspection/create', 'create');
    });

    Route::get('/inspection/get-pertanyaan', [InspectionController::class, 'getPertanyaan'])->name('inspection.getPertanyaan');


    Route::controller(TugasController::class)->group(function () {
        Route::get('/tugas', 'index')->name('tugas.index');
        Route::get('/tugas/create', 'create');
        Route::post('/tugas/store', 'store')->name('tugas.store');
        Route::get('/tugas/edit', 'edit')->name('tugas.edit');
        Route::put('/tugas/{id}', 'update')->name('tugas.update');
        Route::delete('/tugas/{id}/delete', 'delete')->name('tugas.destroy');
        
        Route::get('/tugas/{id}/settugaskaryawan', 'settugaskaryawan');
        Route::get('/tugas/{id}/setlisttugaskaryawan', 'setlisttugaskaryawan');
        Route::get('/tugas/{id}/getsetlisttugaskaryawan', 'getsetlisttugaskaryawan');
        Route::post('/tugas/storetugaskaryawan', 'storetugaskaryawan');
        Route::post('/tugas/removetugaskaryawan', 'removetugaskaryawan');
        Route::get('/tugas/{id}/gettugaskaryawan', 'gettugaskaryawan');
    });
});



//ROute yang Hanya bisa di akses oleh Administrator
Route::group(['middleware' => ['role:administrator|pimpinan,user']], function () {
    //Karyawan
    Route::get('/karyawan/{nik}/details', [KaryawanController::class, 'show']);
    Route::post('/karyawan/{id}/profile', [KaryawanController::class, 'storeProfile'])->name('karyawan.storeProfile');
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nik}/update', [KaryawanController::class, 'update']);
    Route::post('/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);
    Route::get('/karyawan/{nik}/lockandunlocklocation', [KaryawanController::class, 'lockandunlocklocation']);
    Route::get('/karyawan/{nik}/lockandunlockjamkerja', [KaryawanController::class, 'lockandunlockjamkerja']);
    //Departemen
    Route::get('/departemen', [DepartemenController::class, 'index']);
    // ->middleware('permission:view-departemen,user');
    Route::post('/departemen/store', [DepartemenController::class, 'store']);
    Route::post('/departemen/edit', [DepartemenController::class, 'edit']);
    Route::post('/departemen/{kode_dept}/update', [DepartemenController::class, 'update']);
    Route::post('/departemen/{kode_dept}/delete', [DepartemenController::class, 'delete']);

    //Jabatan
    Route::get('/jabatan', [JabatanController::class, 'index']);
    // ->middleware('permission:view-departemen,user');
    Route::post('/jabatan/store', [JabatanController::class, 'store']);
    Route::post('/jabatan/edit', [JabatanController::class, 'edit']);
    Route::post('/jabatan/{kode_dept}/update', [JabatanController::class, 'update']);
    Route::post('/jabatan/{kode_dept}/delete', [JabatanController::class, 'delete']);

    //Presensi
    Route::get('/presensi/detail_izin_sakit', [PresensiController::class, 'detail_izin_sakit']);
    Route::post('/presensi/approveizinsakit', [PresensiController::class, 'approveizinsakit']);
    Route::get('/presensi/{kode_izin}/batalkanizinsakit', [PresensiController::class, 'batalkanizinsakit']);


    //Cabang
    Route::get('/cabang', [CabangController::class, 'index']);
    Route::post('/cabang/store', [CabangController::class, 'store']);
    Route::post('/cabang/edit', [CabangController::class, 'edit']);
    Route::post('/cabang/update', [CabangController::class, 'update']);
    Route::post('/cabang/{kode_cabang}/delete', [CabangController::class, 'delete']);

    //Konfigurasi

    Route::get('/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor']);
    Route::post('/konfigurasi/updatelokasikantor', [KonfigurasiController::class, 'updatelokasikantor']);

    Route::get('/konfigurasi/jamkerja', [KonfigurasiController::class, 'jamkerja']);
    Route::post('/konfigurasi/storejamkerja', [KonfigurasiController::class, 'storejamkerja']);
    Route::post('/konfigurasi/editjamkerja', [KonfigurasiController::class, 'editjamkerja']);
    Route::post('/konfigurasi/updatejamkerja', [KonfigurasiController::class, 'updatejamkerja']);

    Route::post('/konfigurasi/jamkerja/{kode_jam_kerja}/delete', [KonfigurasiController::class, 'deletejamkerja']);


    Route::get('/konfigurasi/jamkerjadept', [KonfigurasiController::class, 'jamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/create', [KonfigurasiController::class, 'createjamkerjadept']);
    Route::post('/konfigurasi/jamkerjadept/store', [KonfigurasiController::class, 'storejamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/{kode_jk_dept}/edit', [KonfigurasiController::class, 'editjamkerjadept']);
    Route::post('/konfigurasi/jamkerjadept/{kode_jk_dept}/update', [KonfigurasiController::class, 'updatejamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/{kode_jk_dept}/show', [KonfigurasiController::class, 'showjamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/{kode_jk_dept}/delete', [KonfigurasiController::class, 'deletejamkerjadept']);

    //User
    Route::get('/konfigurasi/users', [UserController::class, 'index']);
    Route::post('/konfigurasi/users/store', [UserController::class, 'store']);
    Route::post('/konfigurasi/users/edit', [UserController::class, 'edit']);
    Route::post('/konfigurasi/users/{id_user}/update', [UserController::class, 'update']);
    Route::post('/konfigurasi/users/{id_user}/delete', [UserController::class, 'delete']);


    //Harilibur

    Route::get('/konfigurasi/harilibur', [HariliburController::class, 'index']);
    Route::get('/konfigurasi/harilibur/create', [HariliburController::class, 'create']);
    Route::post('/konfigurasi/harilibur/store', [HariliburController::class, 'store']);
    Route::post('/konfigurasi/harilibur/edit', [HariliburController::class, 'edit']);
    Route::post('/konfigurasi/harilibur/{kode_libur}/update', [HariliburController::class, 'update']);
    Route::post('/konfigurasi/harilibur/{kode_libur}/delete', [HariliburController::class, 'delete']);
    Route::get('/konfigurasi/harilibur/{kode_libur}/setkaryawanlibur', [HariliburController::class, 'setkaryawanlibur']);
    Route::get('/konfigurasi/harilibur/{kode_libur}/setlistkaryawanlibur', [HariliburController::class, 'setlistkaryawanlibur']);
    Route::get('/konfigurasi/harilibur/{kode_libur}/getsetlistkaryawanlibur', [HariliburController::class, 'getsetlistkaryawanlibur']);
    Route::post('/konfigurasi/harilibur/storekaryawanlibur', [HariliburController::class, 'storekaryawanlibur']);
    Route::post('/konfigurasi/harilibur/removekaryawanlibur', [HariliburController::class, 'removekaryawanlibur']);
    Route::get('/konfigurasi/harilibur/{kode_libur}/getkaryawanlibur', [HariliburController::class, 'getkaryawanlibur']);
    //Cuti

    Route::get('/cuti', [CutiController::class, 'index']);
    Route::post('/cuti/store', [CutiController::class, 'store']);
    Route::post('/cuti/edit', [CutiController::class, 'edit']);
    Route::post('/cuti/{kode_cuti}/update', [CutiController::class, 'update']);
    Route::post('/cuti/{kode_cuti}/delete', [CutiController::class, 'delete']);

    Route::controller(SignatureController::class)->group(function () {
        Route::get('/signature', 'index')->name('signatures.index');
        Route::get('/signatures/create', 'create')->name('signatures.create');
        Route::post('/signatures/store', 'store')->name('signatures.store');
        Route::get('/signatures/{id}/edit', 'edit')->name('signatures.edit');
        Route::put('/signatures/{id}', 'update')->name('signatures.update');
        Route::delete('/signatures/{id}/deteteUmum', 'destroy')->name('signatures.destroy');
    });
});


Route::get('/createrolepermission', function () {

    try {
        Role::create(['name' => 'admin departemen']);
        // Permission::create(['name' => 'view-karyawan']);
        // Permission::create(['name' => 'view-departemen']);
        echo "Sukses";
    } catch (\Exception $e) {
        echo "Error";
    }
});


Route::get('/give-user-role', function () {
    try {
        $user = User::findorfail(1);
        $user->assignRole('administrator');
        echo "Sukses";
    } catch (\Exception $e) {
        //throw $th;
        echo "Error";
    }
});


Route::get('/give-role-permission', function () {
    try {
        $role = Role::findorfail(1);
        $role->givePermissionTo('view-departemen');
        echo "Sukses";
    } catch (\Exception $e) {
        //throw $th;
        echo "Error";
        dd($e->getMessage());
    }
});
