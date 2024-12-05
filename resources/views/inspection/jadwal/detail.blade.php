@extends('layouts.admin.tabler')
@section('content')
{{-- 
<div class="container mt-5">
    <h3 class="mb-4 text-center">Pemeriksaan Karyawan</h3>
    <h4 class="text-center text-primary">{{ $data->karyawan->nama_lengkap }}</h4>
    <p class="lead text-center">Unit Kerja: <strong>{{ $data->kode_dept }}</strong></p>

    <div class="row">
        @foreach ($data_detail as $detail)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $detail->indikator }}</h5>
                        <p class="card-text"><strong>Jawaban:</strong> {{ $detail->jawaban }}</p>
                        <p class="card-text"><strong>Keterangan:</strong> {{ $detail->keterangan }}</p>
                        @if($detail->foto)
                            <img src="{{ asset('storage/' . $detail->foto) }}" alt="Foto Pemeriksaan" class="img-fluid mt-2" style="border-radius: 5px;">
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div> --}}
<div class="container mt-5">
    <h3 class="mb-4 text-center">Pemeriksaan Karyawan</h3>
    <h4 class="text-center text-primary">{{ $data->karyawan->nama_lengkap }}</h4>
    <p class="lead text-center">Unit Kerja: <strong>{{ $data->departemen->nama_dept }}</strong></p>

    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Indikator</th>
                <th>Jawaban</th>
                <th>Keterangan</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_detail as $detail)
                <tr>
                    <td>{{ $detail->indikator }}</td>
                    <td>{{ $detail->jawaban }}</td>
                    <td>{{ $detail->keterangan }}</td>
                    <td>
                        @if($detail->foto)
                            <img src="{{ asset('storage/' . $detail->foto) }}" alt="Foto Pemeriksaan" class="img-fluid" style="max-width: 100px; border-radius: 5px;">
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="{{ route('inspection.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Jadwal Inspeksi
        </a>
    </div>
</div>
@endsection