@extends('layouts.admin.tabler')

@section('content')

<div class="card mt-2">
    <div class="card-body">
        <h5 class="card-title">Tambahkan Laporan</h5>
        <form method="POST" action="{{ url('/inspection/store') }}" id="form-tambah-laporan" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Hari/Tanggal:</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm">
                    </div>
                    <div class="mb-3">
                        <label for="koordinator" class="form-label">Koordinator:</label>
                        {{-- <select name="koordinator" id="koordinator" class="form-control form-control-sm">
                            <option value="default"></option>
                        </select> --}}
                        <input type="text" name="koorninator" id="koorninator" class="form-control form-control-sm" value="{{ $koordinator->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi:</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control form-control-sm" placeholder="Text">
                    </div>
                    <div class="mb-3">
                        <label for="tujuan_kegiatan" class="form-label">Tujuan Kegiatan:</label>
                        <textarea name="tujuan_kegiatan" id="tujuan_kegiatan" class="form-control form-control-sm" rows="3">Pemeriksaan dilakukan dengan tujuan untuk memastikan kesiapsiagaan, kedisiplinan, serta kepatuhan personil security, yang bertugas dalam menjalankan tugas dan fungsi pengamanan di area kantor ....</textarea>
                    </div>
                </div>
        
                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai:</label>
                        <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control form-control-sm">
                    </div>
                    <div class="mb-3">
                        <label for="foto_kunjungan" class="form-label">Foto Kunjungan:</label>
                        <input type="file" name="foto_kunjungan" id="foto_kunjungan" class="form-control form-control-sm" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preview Gambar:</label>
                        <div class="border p-2" style="height: 150px; display: flex; align-items: center; justify-content: center;">
                            <img id="preview" src="#" alt="Preview Gambar" style="max-height: 100%; display: none;">
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Baris WYSIWYG -->
            <div class="mb-3">
                <label for="wysiwyg" class="form-label">Deskripsi/Hasil Pengecekan:</label>
                <textarea name="wysiwyg" id="wysiwyg" class="form-control"></textarea>
            </div>
        
            <!-- Tombol Submit -->
            <div class="text-center">
                <button type="submit" id="btn-submit" class="btn btn-primary btn-sm mt-4">Kirim Laporan</button>
            </div>
        </form>
        
        
        
    </div>
</div>

<script>

    // Image Preview Function
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

</script>


@endsection
{{-- // TinyMCE Initialization
// document.addEventListener('DOMContentLoaded', function() {
//     tinymce.init({
//         selector: '#wysiwyg',
//         height: 300,
//         plugins: [
//             'advlist autolink lists link image charmap print preview anchor',
//             'searchreplace visualblocks code fullscreen',
//             'insertdatetime media table paste code help wordcount'
//         ],
//         toolbar: 'undo redo | formatselect | bold italic backcolor | ' +
//                  'alignleft aligncenter alignright alignjustify | ' +
//                  'bullist numlist outdent indent | removeformat | help',
//         branding: false
//     });
// }); --}}
<!-- Tambahkan TinyMCE Script -->
{{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}

{{-- // function previewImage(event) {
//     const preview = document.getElementById('preview');
//     const file = event.target.files[0]; // Mendapatkan file yang diunggah
//     if (file) {
//         const reader = new FileReader();
//         reader.onload = function(e) {
//             preview.style.display = "block"; // Menampilkan elemen gambar
//             preview.src = e.target.result; // Mengisi src gambar dengan data base64
//         }
//         reader.readAsDataURL(file); // Membaca file gambar sebagai DataURL
//     } else {
//         preview.style.display = "none"; // Sembunyikan jika tidak ada file
//     }
// } --}}