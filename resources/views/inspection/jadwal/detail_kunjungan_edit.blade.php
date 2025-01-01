@extends('layouts.admin.tabler')

@section('content')
<div class="container-xl">
    <!-- Judul atau Header -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Edit Formulir Pemeriksaan</h2>
                <div class="text-muted mt-1">Perbarui data berikut untuk pemeriksaan</div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('inspection.detailInspectionUpdate', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Method untuk update -->

            
            <!-- Hidden Input untuk ID -->
            <input type="hidden" name="id_inspection" id="id" class="form-control" value="{{ $data->id }}">
            <input type="hidden" name="inspection_id" id="id" class="form-control" value="{{ $data->inspection_id }}">
            
            <!-- Dropdown Departemen -->
            <div class="mb-4">
                <label for="departemen" class="form-label">Pilih Departemen:</label>
                <select name="departemen" id="departemen" class="form-select" required>
                    <option value="">Pilih Departemen..</option>
                    @foreach($data_jabatan as $id => $nama_jabatan)
                        <option value="{{ $id }}" {{ $id == $data->jabatan ? 'selected' : '' }}>
                            {{ $id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Nama Karyawan -->
            <div class="mb-4">
                <label for="nama_karyawan" class="form-label">Pilih Nama Karyawan:</label>
                <select name="nama_karyawan" id="nama_karyawan" class="form-select" required>
                    <option value="">Pilih Karyawan...</option>
                    {{-- @foreach($data_karyawan as $karyawan) --}}
                        <option value="{{ $data->nik }}" selected >
                            {{ $data->karyawan->nama_lengkap }}
                        </option>
                    {{-- @endforeach --}}
                </select>
            </div>

            <!-- Kontainer Instrumen -->
            <div id="instrument-container">
                @foreach($groupedDetails as $title => $pertanyaanGroup)
                    <h2 class="mt-4">{{ $title }}</h2>
                    <div class="mb-3">
                        @foreach($pertanyaanGroup as $index => $instrument)
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-6">
                                    <h4>{{ $instrument->deskripsi }}</h4> <!-- Akses deskripsi langsung -->
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="jawaban{{ $index }}" class="form-label">Jawaban (0-100):</label>
                                            <input type="number" id="jawaban{{ $index }}" 
                                                name="details[{{ $instrument->id }}][jawaban]" 
                                                class="form-control" 
                                                value="{{ old('details.' . $instrument->id . '.jawaban', $instrument->jawaban) }}" 
                                                min="0" 
                                                max="100" 
                                                required>
                                        </div>
                                        <div class="col-4">
                                            <label for="keterangan{{ $index }}" class="form-label">Keterangan:</label>
                                            <textarea id="keterangan{{ $index }}" 
                                                name="details[{{ $instrument->id }}][keterangan]" 
                                                class="form-control" 
                                                rows="2">{{ old('details.' . $instrument->id . '.keterangan', $instrument->keterangan) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="details[{{ $instrument->id }}][id_instrumen]" value="{{ $instrument->id }}">
                        @endforeach
                    </div>
                @endforeach
            </div>
            
            

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Update Pemeriksaan</button>
        </form>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#departemen').on('change', function () {
        const kodeDept = $(this).val();

        if (kodeDept) {
            // Muat data instrumen
            $.ajax({
                url: "{{ route('get-instruments') }}",
                type: "POST",
                data: {
                    kode_dept: kodeDept,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('#instrument-container').empty(); // Hapus konten sebelumnya

                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    console.log(data);

                    // Tambahkan instrumen ke dalam container
                    $.each(data, function (title, pertanyaanGroup) {
                        let html = `<h2 class="mt-4">${title}</h2><div class="mb-3">`;

                        $.each(pertanyaanGroup, function (index, instrument) {
                            html += `
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-6">
                                    <h4>${instrument.deskripsi}</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="jawaban${index}" class="form-label">Jawaban (0-100):</label>
                                            <input type="number" id="jawaban${index}" name="details[${instrument.id}][jawaban]" class="form-control" min="0" max="100" required>
                                        </div>
                                        <div class="col-4">
                                            <label for="keterangan${index}" class="form-label">Keterangan:</label>
                                            <textarea id="keterangan${index}" name="details[${instrument.id}][keterangan]" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="details[${instrument.id}][id_instrumen]" value="${instrument.id}">
                            `;
                        });

                        html += `</div>`;
                        $('#instrument-container').append(html);
                    });
                },
                error: function (xhr) {
                    console.error(xhr);
                    alert('Gagal memuat data instrumen.');
                }
            });

            // Muat data karyawan
            $.ajax({
                url: "{{ route('get-karyawan-by-dept') }}",
                type: "GET",
                data: {
                    kode_dept: kodeDept,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('#nama_karyawan').empty(); // Kosongkan dropdown nama karyawan
                    $('#nama_karyawan').append('<option value="">Pilih Karyawan...</option>');

                    console.log(data);

                    // Tambahkan nama karyawan ke dropdown
                    $.each(data, function (index, karyawan) {
                        $('#nama_karyawan').append(`<option value="${karyawan.nik}">${karyawan.nama_lengkap }</option>`);
                    });
                },
                error: function (xhr) {
                    console.error(xhr);
                    alert('Gagal memuat data karyawan.');
                }
            });
        } else {
            $('#instrument-container').empty(); // Bersihkan jika tidak ada pilihan
            $('#nama_karyawan').empty().append('<option value="">Pilih Karyawan...</option>'); // Bersihkan dropdown karyawan
        }
    });
</script>

@endsection
