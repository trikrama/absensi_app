@extends('layouts.admin.tabler')

@section('content')
<div class="container">
    <!-- Pilihan Tambah Instrumen -->
    <div class="mb-4">
        <h3>Tambah Instrumen</h3>
        <button class="btn btn-primary" onclick="showForm('umum')">Tambah Instrumen Umum</button>
        <button class="btn btn-secondary" onclick="showForm('khusus')">Tambah Instrumen Khusus</button>
    </div>

    <!-- Formulir Tambah Instrumen (Awalnya Tersembunyi) -->
    <div id="formInstrumen" style="display:none;">
        <form action="{{ route('instrument.store') }}" method="POST">
            @csrf
            <input type="hidden" id="tipe" name="tipe">
            <div class="form-group">
                <label for="title">Title</label>
                <select class="form-control" name="title" required>
                    <option value="" disabled selected>Pilih Title</option>
                    @foreach ($instrumentTitles as $title)
                        <option value="{{ $title->id }}">{{ $title->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required></textarea>
            </div>
            <div class="form-group" id="kodeDeptForm">
                <label for="title">Title</label>
                <select class="form-control" name="kode_dept" required>
                    <option value="" disabled selected>Pilih Unit</option>
                    @foreach ($departements as $unit)
                        <option value="{{ $unit->kode_dept }}">{{ $unit->nama_dept }}</option>
                    @endforeach
                </select>
            </div>
            <div></div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>

   
    <div class="container-fluid">
        <!-- Tampilkan Pertanyaan Umum -->
        <h2 class="my-4 text-center">Pertanyaan Umum</h2>
        @foreach ($pertanyaanUmum as $title => $pertanyaanGroup)
            <h4 class="text-primary my-3">{{ $title }}</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $noUmum = 1; @endphp
                        @foreach ($pertanyaanGroup as $item)
                            <tr>
                                <td>{{ $noUmum++ }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('instrument.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('instrument.destroyUmum', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

    
        <!-- Tampilkan Pertanyaan Khusus berdasarkan Title -->
        <h2 class="my-4 text-center">Pertanyaan Khusus</h2>
        @foreach ($pertanyaanKhusus as $title => $pertanyaanGroup)
            <h4 class="text-success my-3">{{ $title }}</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $noKhusus = 1; @endphp
                        @foreach ($pertanyaanGroup as $item)
                            <tr>
                                <td>{{ $noKhusus++ }}</td>
                                <td>{{ $item->instrument->deskripsi }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('instrument.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('instrument.destroyKhusus', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach


</div>
@endsection

@push('myscript')
<script>
function showForm(tipe) {
    document.getElementById('formInstrumen').style.display = 'block';
    document.getElementById('tipe').value = tipe;
    if (tipe === 'khusus') {
        document.getElementById('kodeDeptForm').style.display = 'block';
        // Tambahkan atribut required pada dropdown kode_dept untuk tipe khusus
        document.querySelector('select[name="kode_dept"]').setAttribute('required', 'required');
    } else {
        document.getElementById('kodeDeptForm').style.display = 'none';
        // Hapus atribut required pada dropdown kode_dept untuk tipe umum
        document.querySelector('select[name="kode_dept"]').removeAttribute('required');
    }
}
</script>
@endpush
