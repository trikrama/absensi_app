@extends('layouts.admin.tabler')

@section('content')
<title>Mulai Pemeriksaan | HaloMutiara!</title>
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
</style>

<div class="container-fluid px-4">
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
      <input type="hidden" name="id_pemeriksaan" value="{{ $data->id }}">
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
      @foreach($semuaPertanyaan as $title => $pertanyaanGroup)
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

