@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Instrumen</h2>
    <form action="{{ route('instrument.update', $instrument->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <select class="form-select" id="title" name="title" required>
                @foreach ($instrumentTitles as $title)
                <option value="{{ $title->id }}" {{ $instrument->instrument_title_id == $title->id ? 'selected' : '' }}>
                    {{ $title->title }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" required>{{ $instrument->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tipe" class="form-label">Tipe</label>
            <select class="form-select" id="tipe" name="tipe" required>
                <option value="umum" {{ $instrument->tipe == 'umum' ? 'selected' : '' }}>Umum</option>
                <option value="khusus" {{ $instrument->tipe == 'khusus' ? 'selected' : '' }}>Khusus</option>
            </select>
        </div>

        <div class="mb-3" id="kodeDeptField" style="{{ $instrument->tipe == 'khusus' ? '' : 'display: none;' }}">
            <label for="kode_dept" class="form-label">Kode Departemen</label>
            <select class="form-select" id="kode_dept" name="kode_dept">
                @foreach ($departements as $departement)
                <option value="{{ $departement->kode }}" {{ optional($instrument->unitInstrument)->kode_dept == $departement->kode ? 'selected' : '' }}>
                    {{ $departement->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    document.getElementById('tipe').addEventListener('change', function () {
        document.getElementById('kodeDeptField').style.display = this.value === 'khusus' ? '' : 'none';
    });
</script>
@endsection
