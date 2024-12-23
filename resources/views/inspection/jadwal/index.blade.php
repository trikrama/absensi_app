@extends('layouts.admin.tabler')

@section('content')
<title>Pemeriksaan | HaloMutiara!</title>

{{-- <style>
    .bg-diagonal-gradient{
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
</style> --}}
<div class="row">
    <div class="col-12">
        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::get('warning'))
            <div class="alert alert-warning">
                {{ Session::get('warning') }}
            </div>
        @endif
    </div>
</div>


<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex">
            {{-- <p class="font-weight-bold text-muted">Admin / Pemeriksaan / </p> --}}
            <a href="javascript:;" class="font-weight-bold text-lg text-info hover:text-teal-500">Pemeriksaan</a>
        </div>
        {{-- @if(in_array(auth()->user()->role, ['ADMIN', 'KBAND', 'KUNIT'])) --}}
        {{-- <form class="d-flex gap-2" method="POST" action="{{ url('/inspection/jadwal') }}">@csrf
            <div class="form-group">
                <select name="cari_user" id="id_user" class="form-control form-control-sm">
                    <option value="">Pemeriksa</option>
                    @foreach($data_user as $row)
                        <option value="{{ $row->id }}" {{ request('cari_user') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                    @endforeach
                </select>
            </div> --}}
            {{-- <pre>
                @php
                    dd($data_unit);
                @endphp
            </pre> --}}
            {{-- <div class="form-group">
                <select name="cari_unit" id="id_unit" class="form-control form-control-sm">
                    <option value="">Unit Di Periksa</option>
                    @foreach($data_unit as $row => $nama)
                        <option value="{{ $row }}" {{ request('cari_unit') == $row ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <i data-icon="solar:calendar-bold-duotone" class="iconify text-md"></i>
                <input name="cari_tgl" id="rangedatepicker" value="{{ request('cari_tgl') }}" class="form-control form-control-sm" placeholder="Rentang Tanggal">
            </div>
            <button type="submit" class="btn btn-teal btn-sm">Cari</button>
        </form> --}}
        {{-- @endif --}}
    </div>
</div>


<div class="container-fluid px-4">
    {{-- @if($pemeriksaan)
        @if($pemeriksaan->status == "BELUM")
            <div class="alert alert-warning d-flex justify-content-between align-items-center">
                <p>Anda Telah Terjadwal Di Hari Ini! Klik Tombol Di Samping Untuk Memulai Pemeriksaan.</p> --}}
                {{-- <a href="/inspection/mulai" id="confirmButton" data-id="{{ $pemeriksaan->id }}" data-id_unit="{{ $pemeriksaan->kode_dept }}" class="btn btn-teal btn-sm">
                    <p>Mulai Pemeriksaan</p>
                    <i data-icon="tabler:chevrons-right" class="iconify text-lg"></i>
                </a> --}}
                {{-- <a href="{{ url('/inspection/mulai/'.$pemeriksaan->id) }}" class="btn btn-warning btn-sm">Mulai Pemeriksaan</a>
            </div>
        @else
            <div class="alert alert-success text-center">
                <p>Anda Telah Menyelesaikan Tugas Pemeriksaan, Terimakasih Selamat Bertugas.</p>
            </div>
        @endif
    @endif --}}

    {{-- <a href="{{ url('/inspection/mulai') }}" class="btn btn-warning btn-sm">Mulai Pemeriksaan</a> --}}

    <div class="d-flex justify-content-end">
        <a href="{{ url('/instrument') }}" class="btn btn-warning btn-sm">Tambah Instrument</a>
    </div>
    {{-- @if(in_array(auth()->user()->role, ['ADMIN', 'KBAND', 'KUNIT'])) --}}
    <div class="card mt-2">
        <div class="card-body">
            <h5 class="card-title">Tambahkan Jadwal Pemeriksaan</h5>
            <form method="POST" action="{{ url('/inspection/store') }}" id="form-pemeriksaan">
                @csrf
                <div class="row">
                    {{-- <div class="col-md-4 mb-3"> --}}
                        {{-- <div class="form-group">
                            <label for="pemeriksa">Pilih Pemeriksa</label>
                            <select name="pemeriksa" class="form-control form-control-sm">
                                <option value="">Pilih Pemeriksa</option>
                                @foreach($data_user as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                    {{-- </div> --}}
                    <div class="col-md-4 mb-3">
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
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <input type="text" name="tujuan" id="tujuan" class="form-control form-control-sm" placeholder="Tujuan Pemeriksaan">
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
                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <button type="submit" id="btn-submit" class="btn btn-primary btn-sm w-100">Mulai Pemeriksaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Periksa Unit</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>{{ $row->departemen->nama_dept }}</td>
                        <td>{{ $row->tgl_pemeriksaan }}</td>
                        <td>{{ $row->status }}</td>
                        <td>
                            <a href="{{ url('/inspection/edit/'.$row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form method="POST" action="{{ url('/inspection/delete/'.$row->id) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" data-id="{{ $row->id }}" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                            <a href="{{ url('/inspection/detailInspection/'.$row->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $data->links() }}
    </div>
    {{-- @endif --}}
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        // Mengatur datepicker
        $("#datepicker").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        // Validasi saat form disubmit
        $("#form-pemeriksaan").on('submit', function(event) {
            // Mencegah submit form default
            event.preventDefault();

            // Mengambil nilai dari setiap input
            // const pemeriksa = $('select[name="pemeriksa"]').val();
            const unit = $('select[name="unit"]').val();
            const lokasi = $('select[name="lokasi"]').val();
            const tglPemeriksaan = $('input[name="tgl_pemeriksaan"]').val();

            // Menginisialisasi pesan peringatan
            let messages = [];

            // Memeriksa apakah ada input yang kosong
            // if (!pemeriksa) {
            //     messages.push('Pilih Pemeriksa tidak boleh kosong.');
            // }
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
            } else {
                // Jika semua inputan terisi, submit form
                this.submit();
            }
        });
    });
</script>
@endpush

