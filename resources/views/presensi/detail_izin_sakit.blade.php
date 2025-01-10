<div class="row mb-3">
    <div class="col-4 text-end fw-bold">NIK</div>
    <div class="col-8 text-start">: <span id="nama-detail">{{$dataizin->nik}}</span></div>
</div>
<div class="row mb-3">
    <div class="col-4 text-end fw-bold">Nama</div>
    <div class="col-8 text-start">: <span id="nama-detail">{{$dataizin->nama_lengkap}}</span></div>
</div>
<div class="row mb-3">
    <div class="col-4 text-end fw-bold">Jabatan</div>
    <div class="col-8 text-start">: <span id="jabatan-detail">{{$dataizin->jabatan}}</span></div>
</div>

<div class="row mb-3">
    <div class="col-4 text-end fw-bold">Cabang</div>
    <div class="col-8 text-start">: <span id="jabatan-detail">{{$dataizin->kode_cabang}}</span></div>
</div>

<div class="row mb-3">
    <div class="col-4 text-end fw-bold">Keterangan</div>
    <div class="col-8 text-start">: <span id="keterangan-detail">{{$dataizin->keterangan}}</span></div>
</div>
<div class="row mb-3">
    <div class="col-4 text-end fw-bold">Lampiran</div>
    <div class="col-8 text-start">: 
        @if (!empty($d->doc_sid))
            @php
                $path = Storage::url('uploads/sid/' . $d->doc_sid);
            @endphp
            <a href="{{ url($path) }}" class="text-decoration-underline text-primary" target="_blank">Lihat Lampiran</a>
        @else
            Tidak ada lampiran
        @endif
        {{-- <a href="#" id="lampiran-detail" class="text-decoration-underline text-primary" target="_blank">Lihat Lampiran</a> --}}
    </div>
</div>