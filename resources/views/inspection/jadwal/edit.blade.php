{{-- @extends('layouts.admin.tabler')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.css" rel="stylesheet">
<style>
  .bg-diagonal-gradient {
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
</style>

{{-- <div class="container px-4 py-5">
  <p class="text-md text-[#3bb09f]">Hi Molsyam,</p>
  <div class="d-flex justify-content-between">
    <div class="d-flex gap-2">
      <p class="font-weight-bold text-muted">Admin / Pemeriksaan / </p>
      <a href="javascript:;" class="font-weight-bold text-muted">Pemeriksaan & Jadwal</a>
    </div>
  </div>
</div> --}}

{{-- <form method="POST" id="form-pemeriksaan" action="{{ url('/inspection/update/'.$data->id) }}">
@csrf
@method('PUT')
<input type="hidden" value="{{ $data->id }}" name="id_pemeriksaan">
<div class="container mt-5">
  <div class="row bg-white p-4 rounded-lg">
    <div class="col-md-6">
      <div class="form-group mb-3">
        <label for="pemeriksa" class="font-weight-semibold">Pemeriksa</label>
        <select name="pemeriksa" id="pemeriksa" class="form-control">
          <option value="{{ $data->id_user }}" selected>{{ $data->user->name }}</option>
          @foreach($data_user as $row)
            <option value="{{ $row->id }}">{{ $row->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group mb-3">
        <label for="unit" class="font-weight-semibold">Unit Diperiksa</label>
        <select name="unit" id="unit" class="form-control">
          <option value="{{ $data->kode_dept }}" selected>{{ $data->departemen->nama_dept }}</option>
          @foreach($data_unit as $row => $nama)
            <option value="{{ $row }}">{{ $nama }}</option>
          @endforeach
        </select>
      </div>
     <div class="form-group mb-3">
        <label for="lokasi" class="font-weight-semibold">Lokasi</label> --}}
        {{-- <input name="lokasi" id="lokasi" value="{{ $data->lokasi }}" class="form-control" placeholder="Masukan Lokasi Pemeriksaan"> --}}
        {{-- <select name="lokasi" class="form-control form-control-sm" id="lokasi">
            <option value="{{ $data->lokasi }}" selected> {{ $nama_cabang->nama_cabang }}</option>
            @foreach($data_cabang as $row => $nama)
                <option value="{{ $row }}">{{ $nama }}</option>
            @endforeach
        </select>
      </div>
     
      <div class="form-group mb-3">
        <label for="datepicker" class="font-weight-semibold">Tanggal Pemeriksaan</label>
        <input name="tgl_pemeriksaan" id="datepicker" value="{{ $data->tgl_pemeriksaan }}" class="form-control" placeholder="Masukan Tanggal Pemeriksaan">
      </div>
       <div class="form-group">
        <button type="button" id="btn-submit" class="btn btn-gradient w-100">Ubah Data Jadwal Pemeriksaan</button>
      </div>
    </div>
  </div>
</div>
</form>
@endsection --}}

{{-- @push('myscript')
<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.js"></script>
<script>
  if (typeof AirDatepicker !== 'undefined' && !AirDatepicker.locales) {
    AirDatepicker.locales = {};
  }
  AirDatepicker.locales.id = {
    days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
    daysShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
    daysMin: ['Mg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
    months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
    today: 'Hari ini',
    clear: 'Bersihkan',
    dateFormat: 'yyyy-mm-dd',
    timeFormat: 'hh:ii aa',
    firstDay: 1
  };
  new AirDatepicker('#datepicker', {
    locale: AirDatepicker.locales.id,
    dateFormat: 'yyyy-MM-dd',
  });

  $('#btn-submit').on('click', function(){
     // Menginisialisasi pesan peringatan
     // Mengambil nilai dari setiap input
    const pemeriksa = $('select[name="pemeriksa"]').val();
    const unit = $('select[name="unit"]').val();
    const lokasi = $('select[name="lokasi"]').val();
    const tglPemeriksaan = $('input[name="tgl_pemeriksaan"]').val();

    // Menginisialisasi pesan peringatan
    let messages = [];

    // Memeriksa apakah ada input yang kosong
    if (!pemeriksa) {
        messages.push('Pilih Pemeriksa tidak boleh kosong.');
    }
    if (!unit) {
        messages.push('Pilih Unit tidak boleh kosong.');
    }
    if (!lokasi) {
        messages.push('Pilih Lokasi tidak boleh kosong.');
    }
    if (!tglPemeriksaan) {
        messages.push('Tanggal Pemeriksaan tidak boleh kosong.');
    }

    // Menampilkan SweetAlert jika ada input yang kosong
    if (messages.length > 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: messages.join('\n'),
            confirmButtonText: 'OK'
        });
    }

    Swal.fire({
      title: "Anda Yakin?",
      text: "Anda Akan mengubah data Jadwal ini",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Ubah",
      cancelButtonText: "Saya Periksa Kembali"
    }).then((result) => {
      $('#form-pemeriksaan').submit();
    });
  });
</script>
@endpush --}}

@extends('layouts.admin.tabler')

@section('content')

<div class="card mt-2">
    <div class="card-body">
        <h5 class="card-title">Edit Laporan</h5>
        <form method="POST" action="{{ url('/inspection/update/' . $inspection->id) }}" id="form-edit-laporan" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Hari/Tanggal:</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm" value="{{ $inspection->tgl_pemeriksaan }}">
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi:</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control form-control-sm" value="{{ $inspection->lokasi }}">
                    </div>
                    <div class="mb-3">
                        <label for="tujuan_kegiatan" class="form-label">Tujuan Kegiatan:</label>
                        <textarea name="tujuan_kegiatan" id="tujuan_kegiatan" class="form-control form-control-sm" rows="3">{{ $inspection->tujuan }}</textarea>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai:</label>
                        <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control form-control-sm" value="{{ $inspection->waktu_mulai }}">
                    </div>
                    <div class="mb-3">
                        <label for="foto_kunjungan" class="form-label">Foto Kunjungan:</label>
                        <input type="file" name="foto_kunjungan" id="foto_kunjungan" class="form-control form-control-sm" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preview Gambar:</label>
                        <div class="border p-2" style="height: 150px; display: flex; align-items: center; justify-content: center;">
                            <img id="preview" src="{{ asset('storage/uploads/inspection/' . $inspection->foto_bukti) }}" alt="Preview Gambar" style="max-height: 100%;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="wysiwyg" class="form-label">Deskripsi/Hasil Pengecekan:</label>
                <textarea name="wysiwyg" id="wysiwyg" class="form-control">{{ $inspection->keterangan }}</textarea>
            </div>

            <div class="text-center">
                <button type="submit" id="btn-submit" class="btn btn-primary btn-sm mt-4">Update Laporan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('myscript')
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

   // SweetAlert Validation and Confirmation
   document.getElementById('btn-submit').addEventListener('click', function (event) {
    event.preventDefault(); // Mencegah form dikirim secara langsung

    const form = document.getElementById('form-edit-laporan');
    const fields = ['tanggal', 'lokasi', 'tujuan_kegiatan', 'waktu_mulai', 'wysiwyg'];
    let valid = true;

    // Validasi input tidak boleh kosong
    fields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
            valid = false;
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Semua inputan harus diisi!'
            });
            return false;
        }
    });

    // Jika validasi berhasil
    if (valid) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan diupdate!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, update!'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log("Form akan dikirim"); // Debugging: pastikan langkah ini tercapai
                form.submit(); // Kirim form setelah konfirmasi
            } else {
                console.log("Aksi dibatalkan"); // Debugging: cek jika konfirmasi ditolak
            }
        });
    }
});


</script>
@endpush

