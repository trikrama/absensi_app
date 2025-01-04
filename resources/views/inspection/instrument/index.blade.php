@extends('layouts.admin.tabler')

@section('content')
<div class="container">
    <!-- Pilihan Tambah Instrumen -->
    <div class="mb-4">
        <h3>Tambah Instrumen</h3>
        {{-- <button class="btn btn-primary" onclick="showForm('umum')">Tambah Instrumen Umum</button> --}}
        <button class="btn btn-secondary" onclick="showForm('khusus')">Tambah Instrumen Khusus</button>
    </div>

    <!-- Formulir Tambah Instrumen (Awalnya Tersembunyi) -->
    <div id="formInstrumen" style="display:none;">
        <form action="{{ route('instrument.store') }}" method="POST">
            @csrf
            <input type="hidden" id="tipe" name="tipe">
            <div class="form-group">
                <label for="title">Title Instrument</label>
                <select class="form-control" name="title" required>
                    <option value="" disabled selected>Pilih Title</option>
                    {{-- @foreach ($jabatan as $title)
                        <option value="{{ $title->id }}">{{ $title->nama_jabatan }}</option>
                    @endforeach --}}
                    @foreach ($instrumentTitles as $title)
                        <option value="{{ $title->id }}">{{ $title->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="kodeDeptForm">
                <label for="title">Jabatan</label>
                <select class="form-control" name="jabatan" required>
                    <option value="" disabled selected>Pilih Jabatan</option>
                    @foreach ($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required></textarea>
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
                            {{-- <th scope="col">Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php $noUmum = 1; @endphp
                        @foreach ($pertanyaanGroup as $item)
                            <tr>
                                <td>{{ $noUmum++ }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                {{-- <td> --}}
                                    <!-- Tombol Edit -->
                                    {{-- <a href="{{ route('instrument.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                                    <!-- Tombol Hapus -->
                                    {{-- <form action="{{ route('instrument.destroyUmum', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form> --}}
                                {{-- </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

    
        <!-- Tampilkan Pertanyaan Khusus berdasarkan Title -->
        <h2 class="my-4 text-center">Pertanyaan Khusus</h2>
        @foreach ($pertanyaanKhusus as $title => $pertanyaanGroup)
            @php
                $jsonString = $title;
                $data = json_decode($jsonString);
            @endphp
            <h4 class="text-success my-3">{{ $data->nama_jabatan }}</h4>
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
                                    {{-- <a href="{{ route('instrument.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                                    <!-- Tombol Hapus -->
                                    {{-- <form action="{{ route('instrument.destroyKhusus', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form> --}}
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('instrument.destroyKhusus', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-button" data-id="{{ $item->id }}">Hapus</button>
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
    // Fungsi untuk menampilkan form berdasarkan tipe
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

    // SweetAlert untuk konfirmasi penghapusan
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil semua tombol dengan class delete-button
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.getAttribute('data-id');
                const form = document.getElementById(`delete-form-${itemId}`);

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Kirim form jika dikonfirmasi
                    }
                });
            });
        });
    });
</script>
@endpush
