@extends('layouts.admin.tabler')

@section('content')
<title>Pemeriksaan</title>

{{-- <style>
    .bg-diagonal-gradient{
        background: linear-gradient(45deg, #effefd, #d9f7f5);
    }
    .datepicker {
        background-color: white;
        border: none;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .datepicker--cell.-selected-, .datepicker--cell.-current- {
        background-color: #4f46e5;
        color: white;
    }
    .datepicker--cell:hover {
        background-color: #a5b4fc;
    }
</style> --}}
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

   <div class="d-flex justify-content-end">
        <a href="{{ url('/inspection/mulai/'.$data->id) }}" class="btn btn-warning btn-sm">Tambah Penilaian</a>
    </div>
     <div class="card mt-4">
        <div class="card-body">
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
                            {{-- <form method="POST" action="{{ url('/inspection/delete/'.$row->id) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" data-id="{{ $row->id }}" class="btn btn-danger btn-sm">Hapus</button>
                            </form> --}}
                            <form action="{{ route('inspection.detailInspectionDelete', $row->id) }}" method="POST" class="d-inline" id="delete-form-{{ $row->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $row->id }})">Hapus</button>
                            </form>
                            <a href="{{ url('/inspection/detailInspection/'.$row->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                            {{-- <button id="downloadPdf" class="btn btn-primary btn-sm" >Cetak</button> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- <div class="mt-3">
        {{ $data->links() }}
    </div>  --}}
    
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

