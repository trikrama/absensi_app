@extends('layouts..admin.tabler')

@section('title', 'Rekap Absensi Harian')

@section('content')
<div class="container mt-4">
    <h2>Rekap Absensi Harian</h2>
    <form action="{{ route('rekap.harian') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tanggal" class="form-label">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ $tanggal }}">
            </div>
            <div class="col-md-4">
                <label for="kode_cabang" class="form-label">Cabang:</label>
                <select name="kode_cabang" id="kode_cabang" class="form-select">
                    <option value="">Semua Cabang</option>
                    @foreach ($data_cabang as $d)
                        <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
                <a href="#" 
                class="btn btn-primary" 
                    id="cetakRekapButton" 
                    target="_blank">
                    Cetak Rekap Harian
                </a>
                {{-- <button type="submit" name="exportexcel" class="btn btn-success">Export Excel</button> --}}
            </div>
        </div>

    </form>

    @if($rekapHarian->count() > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Departemen</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapHarian as $index => $rekap)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $rekap->nik }}</td>
                <td>{{ $rekap->nama_lengkap }}</td>
                <td>{{ $rekap->kode_dept }}</td>
                <td>{{ $rekap->jam_in ?? '-' }}</td>
                <td>{{ $rekap->jam_out ?? '-' }}</td>
                <td>{{ $rekap->status ?? 'Tidak Hadir' }}</td>
                <td>{{ $rekap->alasan_izin ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="text-center mt-4">Tidak ada data absensi untuk tanggal <strong>{{ $tanggal }}</strong>.</p>
    @endif
</div>
<script>
    document.getElementById('cetakRekapButton').addEventListener('click', function (event) {
        // Cegah link default jika tanggal tidak ada
        event.preventDefault();
        
        // Ambil nilai dari input tanggal
        const tanggalInput = document.getElementById('tanggal').value;
        const cabangInput = document.getElementById('kode_cabang').value;

        if (!tanggalInput) {
            alert('Silakan pilih tanggal terlebih dahulu.');
            return;
        }

        // Buat URL dengan parameter tanggal
        const baseUrl = "{{ route('rekap.cetak') }}"; // Pastikan route ini sesuai
        const url = `${baseUrl}?tanggal=${tanggalInput}&&cabang=${cabangInput}`;

        // Buka halaman baru
        window.open(url, '_blank');
    });
</script>
@endsection
