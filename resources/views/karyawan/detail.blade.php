@extends('layouts.admin.tabler')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Detail Karyawan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Foto Karyawan -->
                            <div class="col-md-3 text-center">
                                <img src="{{ asset('storage/uploads/karyawan/' . $karyawan->foto) }}" alt="Foto Karyawan"
                                    class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                            </div>

                            <!-- Informasi Karyawan -->
                            <div class="col-md-9">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>{{ $karyawan->nama_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td>{{ $karyawan->nik }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td>{{ $karyawan->jabatan }}</td>
                                    </tr>
                                    <tr>
                                        <th>No HP</th>
                                        <td>{{ $karyawan->no_hp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kode Departemen</th>
                                        <td>{{ $karyawan->kode_dept }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kode Cabang</th>
                                        <td>{{ $karyawan->kode_cabang }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <th>Password</th>
                                        <td>**********</td>
                                    </tr> --}}
                                </table>
                            </div>
                        </div>
                        
                        <hr>
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

                        <div class="row">
                            <!-- Profil Karyawan -->
                            <div class="col-md-12">
                                <h4 class="text-primary">Profil Karyawan</h4>
                                {{-- <form  method="POST"> --}}
                                <form action="{{ route('karyawan.storeProfile', ['id' => $karyawan->nik]) }}" method="POST">
                                    @csrf
                                    {{-- @method('PUT') --}}
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Tempat Lahir</label>
                                        <div class="col-md-9">
                                            <input type="text" name="tempat_lahir" class="form-control" value="{{ $karyawan->profil->tempat_lahir ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Tanggal Lahir</label>
                                        <div class="col-md-9">
                                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $karyawan->profil->tanggal_lahir ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Nama Ibu Kandung</label>
                                        <div class="col-md-9">
                                            <input type="text" name="nama_ibu_kandung" class="form-control" value="{{ $karyawan->profil->nama_ibu_kandung ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Jenis Kelamin</label>
                                        <div class="col-md-9">
                                            <select name="jenis_kelamin" class="form-control">
                                                <option value="">Jenis Kelamin</option>
                                                <option value="l" {{ old('jenis_kelamin', optional($karyawan->profil)->jenis_kelamin) == 'l' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="p" {{ old('jenis_kelamin', optional($karyawan->profil)->jenis_kelamin) == 'p' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Agama</label>
                                        <div class="col-md-9">
                                            <input type="text" name="agama" class="form-control" value="{{ $karyawan->profil->agama ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Status Menikah</label>
                                        <div class="col-md-9">
                                            <select name="status_menikah" id="status_menikah" class="form-select">
                                                <option value="">Status Menikah</option>
                                                <option value="0" {{ old('status_menikah', optional($karyawan->profil)->status_menikah) == '0' ? 'selected' : '' }}>Belum Menikah</option>
                                                <option value="1" {{ old('status_menikah', optional($karyawan->profil)->status_menikah) == '1' ? 'selected' : '' }}>Menikah</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Tambahkan input lainnya sesuai data tabel -->
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Alamat KTP</label>
                                        <div class="col-md-9">
                                            <textarea name="alamat_ktp" id="alamat_ktp" class="form-control" placeholder="Alamat KTP">{{ old('alamat_ktp',  $karyawan->profil->alamat_ktp ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Nomor KK</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('nomor_kk', $karyawan->profil->nomor_kk ?? '') }}" id="nomor_kk" name="nomor_kk" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Pendidikan Terakhir</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('pendidikan_terakhir', $karyawan->profil->pendidikan_terakhir ?? '') }}" id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Institusi</label>
                                        <div class="col-md-9">
                                            <input type="text" name="institusi" class="form-control" value="{{ $karyawan->profil->institusi ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Masa Aktif SIM</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('masa_aktif_sim', $karyawan->profil->masa_aktif_sim ?? '') }}" id="masa_aktif_sim" name="masa_aktif_sim" placeholder="Masa Aktif SIM" class="form-control"
                                            onfocus="(this.type='date')" onblur="(this.type='text'); if(!this.value){this.placeholder='Masa Aktif SIM';}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Pendidikan Satuan Pengamanan</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('pendidikan_satpam', $karyawan->profil->pendidikan_satpam ?? '') }}" id="pendidikan_satpam" name="pendidikan_satpam" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Tahun Pelatihan</label>
                                        <div class="col-md-9">
                                            <input type="number" value="{{ old('tahun_pelatihan', $karyawan->profil->tahun_pelatihan ?? '') }}" id="tahun_pelatihan" name="tahun_pelatihan" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">No KTA</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('no_kta', $karyawan->profil->no_kta ?? '') }}" id="no_kta" name="no_kta" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Penerbit KTA</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('penerbit_kta', $karyawan->profil->penerbit_kta ?? '') }}" id="penerbit_kta" name="penerbit_kta" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Masa Aktif KTA</label>
                                        <div class="col-md-9">
                                            <input type="date" value="{{ old('masa_aktif_kta', $karyawan->profil->masa_aktif_kta ?? '') }}" id="masa_aktif_kta" name="masa_aktif_kta" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label"> No Registrasi</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('no_registrasi', $karyawan->profil->no_registrasi ?? '') }}" id="no_registrasi" name="no_registrasi" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label"> TMT Awal Penugasan </label>
                                        <div class="col-md-9">
                                            <input type="date" value="{{ old('tmt_awal_penugasan', $karyawan->profil->tmt_awal_penugasan ?? '') }}" id="tmt_awal_penugasan" name="tmt_awal_penugasan" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label"> Nama Bank</label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('nama_bank',  $karyawan->profil->nama_bank ?? '') }}" id="nama_bank" name="nama_bank" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label"> No Rekening </label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('no_rekening', $karyawan->profil->no_rekening ?? '') }}"  id="no_rekening" name="no_rekening" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label"> No BPJS Kesehatan </label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('no_bpjs_kesehatan', $karyawan->profil->no_bpjs_kesehatan ?? '') }}" id="no_bpjs_kesehatan" name="no_bpjs_kesehatan" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label"> No BPJS Ketenagakerjaan </label>
                                        <div class="col-md-9">
                                            <input type="text" value="{{ old('no_bpjs_ketenagakerjaan', $karyawan->profil->no_bpjs_ketenagakerjaan ?? '') }}" id="no_bpjs_ketenagakerjaan" name="no_bpjs_ketenagakerjaan" class="form-control">
                                        </div>
                                    </div>

                                    
                                    <!-- Tambahkan input lainnya sesuai data tabel -->

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">No NPWP</label>
                                        <div class="col-md-9">
                                            <input type="text" name="no_npwp" class="form-control" value="{{ $karyawan->profil->no_npwp ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer text-right">
                        <a href="/karyawan" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
<script>
     document.getElementById('tahun_pelatihan').addEventListener('input', function (e) {
            const min = 1901;
            const max = 2155;
            let value = parseInt(e.target.value);

            if (value < min) {
                e.target.value = min;
            } else if (value > max) {
                e.target.value = max;
            }
        });
</script>
@endpush
