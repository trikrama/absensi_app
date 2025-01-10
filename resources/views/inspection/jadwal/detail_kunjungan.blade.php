@extends('layouts.admin.tabler')

@section('content')
<title>Pemeriksaan</title>

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

<div class="container-fluid px-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Pemeriksaan</h5>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th class="text-start" scope="row" style="width: 30%;">Tanggal</th>
                        <td style="width: 5%;">:</td>
                        <td>{{ $data->tgl_pemeriksaan }}</td>
                    </tr>
                    <tr>
                        <th class="text-start" scope="row">Koordinator</th>
                        <td>:</td>
                        <td>{{ $data->user->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-start" scope="row">Waktu Mulai</th>
                        <td>:</td>
                        <td>{{ $data->waktu_mulai }}</td>
                    </tr>
                    <tr>
                        <th class="text-start" scope="row">Lokasi</th>
                        <td>:</td>
                        <td>{{ $data->lokasi }}</td>
                    </tr>
                    <tr>
                        <th class="text-start" scope="row">Foto Kunjungan</th>
                        <td>:</td>
                        <td>
                            <a href="{{ asset('storage/uploads/inspection/' . $data->foto_bukti) }}" class="btn btn-link p-0" target="_blank" rel="noopener noreferrer">Klik Untuk Lihat Foto</a>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-start" scope="row">Tujuan Kunjungan</th>
                        <td>:</td>
                        <td>{{ $data->tujuan }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

   <div class="d-flex justify-content-end mr-4">
        <a href="{{ url('/inspection/mulai/'.$data->id) }}" class="btn btn-warning btn- mt-4 me-2">Tambah Penilaian</a>
        <a href="{{ route('inspection.jadwal.index') }}" class="btn btn-secondary btn-xl mt-4">
            <i class="fas fa-arrow-left"></i> Batal
        </a>
    </div>
    <!-- Filter Section -->
    {{-- <div class="card mt-4">
        <div class="card-body">
            
        </div>
    </div> --}}

     <div class="card mt-4">
        <div class="card-body">
            <form action="{{ url('/inspection/detail_kunjungan/' . $data->id) }}" method="GET" class="row g-3 mb-3 align-items-end d-flex">
                <div class="col-md-3 me-3">
                    <label for="nama_petugas" class="form-label">Nama Petugas</label>
                    <input type="text" name="nama_petugas" id="nama_petugas" class="form-control" value="{{ request('nama_petugas') }}">
                </div>
                <div class="col-md-3 me-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <select name="jabatan" id="jabatan" class="form-select">
                        <option value="">Pilih Jabatan</option>
                        @foreach ($jabatan_list as $id => $nama_jabatan)
                            <option value="{{ $nama_jabatan }}" {{ request('jabatan') == $nama_jabatan ? 'selected' : '' }}>
                                {{ $nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 me-3">
                    <label for="cabang" class="form-label">Cabang</label>
                    <select name="cabang" id="cabang" class="form-select">
                        <option value="">Pilih Cabang</option>
                        @foreach ($cabang_list as $kode_cabang => $nama_cabang)
                            <option value="{{ $nama_cabang }}" {{ request('cabang') == $nama_cabang ? 'selected' : '' }}>
                                {{ $nama_cabang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ url('/inspection/detail_kunjungan/' . $data->id) }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
            
            <table class="table table-striped">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Petugas/Karyawan</th>
                        <th>Penempatan Cabang</th>
                        <th>Jabatan</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody  class="text-center">
                    @php $no = 1; @endphp
                    @foreach ($detail_kunjungan as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->karyawan->nama_lengkap }}</td>
                        <td>{{ $row->cabang }}</td>
                        <td>{{ $row->jabatan }}</td>
                        <td>{{ $row->nilai }}</td>
                        <td>
                            <a href="{{ route('inspection.detailInspectionEdit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('inspection.detailInspectionDelete', $row->id) }}" method="POST" class="d-inline" id="delete-form-{{ $row->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $row->id }})">Hapus</button>
                            </form>
                            <a href="{{ url('/inspection/detailInspection/'.$row->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $detail_kunjungan->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    
</div>
@endsection

@push('myscript')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Hapus',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit(); // Submit form jika konfirmasi
            }
        });
    }
</script>
@endpush

