@extends('layouts.admin.tabler')

@section('content')
{{-- <title>Mulai Pemeriksaan | HaloMutiara!</title>
<style>
  #progressBar {
    transition: width 0.3s ease;
  }
  .check-input:checked + .checkbox {
    background: #26bfbf;
    border: 2px solid #26bfbf;
  }
  .check-input:checked + .checkbox svg path {
    stroke-dasharray: 500;
    stroke-dashoffset: 500;
    stroke: #fff;
    stroke-width: 3;
    animation: check 4s forwards;
  }
  .check-input:checked + .checkbox::before {
    animation: ripple 0.3s;
  }
  @keyframes check {
    to {
      stroke-dashoffset: 0;
    }
  }
  @keyframes ripple {
    to {
      transform: scale(1);
    }
  }
</style> --}}

{{-- <div class="container-fluid px-4">
  <div class="row mb-4">
    <div class="col">
      <p class="text-muted">Hi Molsyam,</p>
      <div class="d-flex justify-content-between">
        <div class="d-flex gap-2">
          <p class="font-weight-bold text-muted">Admin / Pemeriksaan / </p>
          <a href="javascript:;" class="font-weight-bold text-dark">Mulai Pemeriksaan</a>
        </div>
      </div>
    </div>
  </div>

  <div class="card p-4">
    <p class="h5 font-weight-bold">Instrumen Penilaian Unit</p>
    <p class="text-muted">Selesaikan instrumen pemeriksaan dibawah ini kepada unit yang di tuju.</p>

    <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
      <p class="font-weight-bold" id="progressPercent">0%</p>
      <div class="w-100">
        <div class="progress">
          <div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>

    <form id="form-pemeriksaan" method="POST" action="{{ url('admin/pemeriksaan/store_detail') }}">
      @csrf
      <input type="hidden" name="id_pemeriksaan" value="{{ $data->id }}"> --}}
      {{-- @foreach($data_instrumen as $instrumen) --}}
      {{-- @foreach($semuaPertanyaan as $instrumen)
        <div class="form-check form-check-inline my-2">
          {{-- <input type="checkbox" name="indikator[{{$instrumen->id}}]" value="BAIK" id="input-{{ $instrumen->id }}" class="check-input d-none" onclick="updateProgress()" {{ in_array($instrumen->id, $data_detail) ? 'checked' : '' }}> 
          <label for="input-{{ $instrumen->id }}" class="checkbox btn btn-outline-secondary d-flex justify-content-center align-items-center rounded-circle">
            <svg viewBox="0 0 22 16" fill="none" class="w-5 h-5">
              <path d="M1 6.85L8.09677 14L21 1" />
            </svg>
          </label>
        </div>
        <input type="hidden" name="id_instrumen[]" value="{{ $instrumen->id }}">
      @endforeach --}}
      {{-- @foreach($semuaPertanyaan as $title => $pertanyaanGroup)
      <h3>{{ $title }}</h3>
      <ul>
        @foreach($pertanyaanGroup as $instrumen)
          <li>
            <label>{{ $instrumen->deskripsi }}</label>
            <input type="range" name="jawaban[{{ $instrumen->id }}]" min="0" max="100" step="1">
          </li>
        @endforeach
      </ul>
    @endforeach
      <label for="jawaban">Jawaban</label>
        <select name="jawaban[instrument_id]" id="jawaban">
            @foreach ($ranges as $range)
                <option value="{{ $range->id }}">{{ $range->label }} ({{ $range->min_value }}-{{ $range->max_value }})</option>
            @endforeach
        </select>
      <input type="hidden" name="status_pending" id="status_pending" placeholder="Status Pending">
    </form>

    <div class="d-flex justify-content-end mt-3">
      <button type="button" id="btn-submit" class="btn btn-primary w-100">
        Pending Pemeriksaan
      </button>
    </div>
  </div>
</div>
@endsection

@push('myscript')
<script>
  $(document).ready(function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const checkedCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
    const totalCheckboxes = checkboxes.length;
    const progressPercent = Math.round((checkedCount / totalCheckboxes) * 100);

    document.getElementById('progressBar').style.width = progressPercent + '%';
    document.getElementById('progressPercent').innerText = progressPercent;

    var isComplete = progressPercent >= 100;
    $('#btn-submit').html(isComplete ? 'Selesai Pemeriksaan' : 'Pending Pemeriksaan');
    $('#btn-submit')
      .removeClass(isComplete ? 'btn-warning' : 'btn-success')
      .addClass(isComplete ? 'btn-success' : 'btn-warning');
    $('#status_pending').val(isComplete ? 'selesai' : 'belum');
  });

  function updateProgress() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const checkedCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
    const totalCheckboxes = checkboxes.length;
    const progressPercent = Math.round((checkedCount / totalCheckboxes) * 100);

    document.getElementById('progressBar').style.width = progressPercent + '%';
    document.getElementById('progressPercent').innerText = progressPercent;

    var isComplete = progressPercent >= 100;
    $('#btn-submit').html(isComplete ? 'Selesai Pemeriksaan' : 'Pending Pemeriksaan');
    $('#btn-submit')
      .removeClass(isComplete ? 'btn-warning' : 'btn-success')
      .addClass(isComplete ? 'btn-success' : 'btn-warning');
    $('#status_pending').val(isComplete ? 'selesai' : 'belum');
  }

  $('#btn-submit').on('click', function() {
    var stt = $('#status_pending').val();
    var msg = stt === "selesai" ? "Apakah semua sudah di periksa dengan benar sebelum mengakhiri pemeriksaan?" : "Pemeriksaan akan dipending sementara";
    var btn = stt === "selesai" ? "Ya, Selesai" : "Ya, Pending";

    Swal.fire({
      title: "Anda Yakin?",
      text: msg,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: btn,
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        $('#form-pemeriksaan').submit();
        return true;
      }
    });
  })
</script>
@endpush
 --}}


 {{-- <div class="card mt-2">
  <div class="card-body">
      <h5 class="card-title">Pemeriksaan</h5>
      <form method="POST" action="{{ url('/inspection/store') }}" id="form-pemeriksaan">@csrf
          <div class="row"> --}}
              {{-- <div class="col-md-4 mb-3">
                  <div class="form-group">
                      <label for="pemeriksa">Pilih Pemeriksa</label>
                      <select name="pemeriksa" class="form-control form-control-sm">
                          <option value="">Pilih Pemeriksa</option>
                          @foreach($data_user as $row)
                              <option value="{{ $row->id }}">{{ $row->name }}</option>
                          @endforeach
                      </select>
                  </div>
              </div> --}}
              {{-- <div class="col-md-4 mb-3">
                  <div class="form-group">
                      <label for="unit">Pilih Unit Yang Akan Diperiksa</label>
                      <select name="unit" class="form-control form-control-sm">
                          <option value="">Pilih Unit</option>
                          @foreach($data_unit as $row => $nama)
                              <option value="{{ $row }}">{{ $nama }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-md-4 mb-3">
                  <div class="form-group">
                      <label for="lokasi">Lokasi Pemeriksaan</label>
                      <select name="lokasi" class="form-control form-control-sm">
                          <option value="">Pilih Lokasi</option>
                          @foreach($data_cabang as $row => $nama)
                              <option value="{{ $row }}">{{ $nama }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4 mb-3">
                  <div class="form-group">
                      <label for="tgl_pemeriksaan">Tanggal Pemeriksaan</label>
                      <input type="date" id="datepicker" 
                             value="{{ date('Y-m-d') }}" 
                             name="tgl_pemeriksaan"
                             class="form-control" 
                             placeholder="Tanggal Pemeriksaan"
                             autocomplete="off">
                  </div>
              </div>
            </div>
              <div class="col-md-4 mb-3 d-flex align-items-end">
                  <button type="submit" id="btn-submit" class="btn btn-primary btn-sm w-100">Mulai Pemeriksaan</button>
              </div>
      </form>
  </div>
</div> --}}

 <form action="{{ route('inspection.store') }}" method="POST" enctype="multipart/form-data" class="container mt-4">
  @csrf
  <div class="mb-4">
      <input type="hidden" name="id" id="id" class="form-control" value="{{ $data->id }}">
      <input type="hidden" name="id_pemeriksa" id="id_pemeriksa" class="form-control" value="{{ $data->user_id}}">
      <input type="hidden" name="lokasi" id="lokasi" class="form-control" value="{{ $data->lokasi}}">
      <input type="hidden" name="tgl_pemeriksaan" id="tgl_pemeriksaan" class="form-control" value="{{ $data->tgl_pemeriksaan }}">
      <input type="hidden" name="tujuan" id="tujuan" class="form-control" value="{{ $data->tujuan }}">
      <label for="nik" class="form-label">Pilih Karyawan:</label>
      <select name="nik" id="nik" class="form-select" required>
          <option value="">Pilih Karyawan..</option>
          @foreach($karyawans as $karyawan)
              <option value="{{ $karyawan->nik }}">{{ $karyawan->nama_lengkap }}</option>
          @endforeach
      </select>
  </div>

  @foreach($semuaPertanyaan as $title => $pertanyaanGroup)
      <h2 class="mt-4">{{ $title }}</h2>
      <div class="mb-3">
          @foreach($pertanyaanGroup as $instrument)
              <div class="row mb-3 align-items-center">
                  <div class="col-md-6">
                      <h4>{{ $instrument->deskripsi }}</h4>
                  </div>
                  <div class="col-md-6">
                      <div class="row">
                          <div class="col-4">
                              <label for="jawaban{{ $loop->index }}" class="form-label">Jawaban (0-100):</label>
                              {{-- <input type="number" id="jawaban{{ $loop->index }}" name="details[{{ $loop->index }}][jawaban]" class="form-control" min="0" max="100" required> --}}
                              <input type="number" id="jawaban{{ $loop->index }}" name="details[{{ $instrument->id }}][jawaban]" class="form-control" min="0" max="100" required>
                          </div>
                          <div class="col-4">
                              <label for="keterangan{{ $loop->index }}" class="form-label">Keterangan:</label>
                              <textarea id="keterangan{{ $loop->index }}" name="details[{{ $instrument->id }}][keterangan]" class="form-control" rows="2"></textarea>
                          </div>
                          {{-- <div class="col-4">
                              <label for="foto{{ $loop->index }}" class="form-label">Upload Foto:</label>
                              <input type="file" id="foto{{ $loop->index }}" name="details[{{ $instrument->id }}][foto]" class="form-control">
                          </div> --}}
                      </div>
                  </div>
              </div>
              <input type="hidden" name="details[{{ $instrument->id }}][id_instrumen]" value="{{ $instrument->id }}">
          @endforeach
      </div>
  @endforeach

  <label for="keterangan" class="form-label">Hasil Pengecekan</label>
  <textarea id="keterangan" name="keterangan" class="form-control mb-3" rows="4"></textarea>

  <label for="foto_bukti" class="form-label">Upload Foto Bukti :</label>
  <input type="file" id="foto_bukti" name="foto_bukti" class="form-control">



  <button type="submit" class="btn btn-primary" name="submit">Simpan Pemeriksaan</button>
  {{-- Panding Pemeriksaan --}}
  {{-- <button type="submit" id="btn-submit" class="btn btn-warning" name="pending">Pending Pemeriksaan</button> --}}
</form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
@endpush