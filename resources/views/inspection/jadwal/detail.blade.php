{{-- @extends('layouts.admin.tabler')
@section('content')
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
            @foreach ($groupedDetails as $detail) --}}
            {{-- @foreach ($data_detail as $detail) --}}
                {{-- <tr>
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
    </table> --}}
    <!-- Tombol Kembali -->
    {{-- <div class="mb-3">
        <a href="{{ route('inspection.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Jadwal Inspeksi
        </a>
    </div>
</div>
@endsection --}}
@extends('layouts.admin.tabler')
@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Pemeriksaan Karyawan</h1>
    <h2 class="text-center text-primary">{{ $data->karyawan->nama_lengkap }}</h2>
    <p class="lead text-center">Unit Kerja: <strong>{{ $data->departemen->nama_dept }}</strong></p>

    @foreach ($groupedDetails as $title => $details)
        <h3 class="mt-4 text-primary">{{ $title }}</h3> <!-- Menampilkan judul instrument_title -->

        {{-- <table class="table table-responsive"> --}}
        <table class="table table-responsive" style="table-layout: fixed; width: 100%;">
            <thead>
                <tr>
                    <th>Indikator</th>
                    <th class="text-center">Jawaban</th>
                    <th class="text-center">Keterangan</th>
                    {{-- <th>Foto</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $detail)
                    <tr>
                        <td>{{ $detail->indikator }}</td>
                        <td class="text-center">{{ $detail->jawaban }}</td>
                        <td class="text-center">{{ $detail->keterangan }}</td>
                        {{-- <td>
                            @if($detail->foto)
                                <img src="{{ asset('storage/' . $detail->foto) }}" alt="Foto Pemeriksaan" class="img-fluid" style="max-width: 100px; border-radius: 5px;">
                            @endif
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="{{ route('inspection.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Jadwal Inspeksi
        </a>
    </div>
</div>
@endsection
