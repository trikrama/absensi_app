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
                                    <tr>
                                        <th>Password</th>
                                        <td>**********</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <!-- Profil Karyawan -->
                            <div class="col-md-12">
                                <h4 class="text-primary">Profil Karyawan</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>{{ $karyawan->profil->tempat_lahir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>{{ $karyawan->profil->tanggal_lahir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Ibu Kandung</th>
                                        <td>{{ $karyawan->profil->nama_ibu_kandung ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>{{ $karyawan->profil->jenis_kelamin ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td>{{ $karyawan->profil->agama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status Menikah</th>
                                        <td>{{ $karyawan->profil->status_menikah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat KTP</th>
                                        <td>{{ $karyawan->profil->alamat_ktp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor KK</th>
                                        <td>{{ $karyawan->profil->nomor_kk ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pendidikan Terakhir</th>
                                        <td>{{ $karyawan->profil->pendidikan_terakhir ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Institusi Pendidikan</th>
                                        <td>{{ $karyawan->profil->institusi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Masa Aktif SIM</th>
                                        <td>{{ $karyawan->profil->masa_aktif_sim ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pendidikan Satpam</th>
                                        <td>{{ $karyawan->profil->pendidikan_satpam ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tahun Pelatihan</th>
                                        <td>{{ $karyawan->profil->tahun_pelatihan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No KTA</th>
                                        <td>{{ $karyawan->profil->no_kta ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Penerbit KTA</th>
                                        <td>{{ $karyawan->profil->penerbit_kta ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Masa Aktif KTA</th>
                                        <td>{{ $karyawan->profil->masa_aktif_kta ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No Registrasi</th>
                                        <td>{{ $karyawan->profil->no_registrasi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>TMT Awal Penugasan</th>
                                        <td>{{ $karyawan->profil->tmt_awal_penugasan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Bank</th>
                                        <td>{{ $karyawan->profil->nama_bank ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No Rekening</th>
                                        <td>{{ $karyawan->profil->no_rekening ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No BPJS Kesehatan</th>
                                        <td>{{ $karyawan->profil->no_bpjs_kesehatan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No BPJS Ketenagakerjaan</th>
                                        <td>{{ $karyawan->profil->no_bpjs_ketenagakerjaan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No NPWP</th>
                                        <td>{{ $karyawan->profil->no_npwp ?? '-' }}</td>
                                    </tr>
                                </table>
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
