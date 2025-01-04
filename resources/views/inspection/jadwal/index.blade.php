@extends('layouts.admin.tabler')

@section('content')
<title>Pemeriksaan</title>

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
            <a href="javascript:;" class="font-weight-bold text-lg text-info hover:text-teal-500">Pemeriksaan</a>
        </div>
    </div>
</div>


<div class="container-fluid px-4">
    <!-- Header Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary">Jadwal Pemeriksaan</h3>
        <div>
            <a href="{{ url('/instrument') }}" class="btn btn-warning btn-sm me-2">Tambah Instrument</a>
            <a href="{{ url('/inspection/create') }}" class="btn btn-success btn-sm">Tambah Laporan</a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Filter Jadwal Pemeriksaan</h5>
            <form method="GET" action="{{ url('inspection/jadwal') }}" id="form-filter">
                @csrf
                <div class="row">
                    <!-- Filter Tanggal -->
                    <div class="col-md-4 mb-3">
                        <label for="tanggal_dari" class="form-label">Tanggal Dari:</label>
                        <input type="date" class="form-control" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tanggal_sampai" class="form-label">Tanggal Sampai:</label>
                        <input type="date" class="form-control" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                    </div>

                    <!-- Filter Koordinator -->
                    <div class="col-md-4 mb-3">
                        <label for="koordinator" class="form-label">Koordinator:</label>
                        <select class="form-control" name="koordinator">
                            <option value="">Pilih Koordinator</option>
                            @foreach ($data_user as $user)
                                <option value="{{ $user->id }}" {{ request('koordinator') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Jadwal Pemeriksaan</h5>
            <table class="table table-striped">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Koordinator</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Jumlah Personel</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @php $no = 1; @endphp
                    @foreach ($data as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->tgl_pemeriksaan }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>{{ $row->waktu_mulai }}</td>
                        <td>{{ $row->lokasi }}</td>
                        <td>{{ $row->jml_personel }}</td>
                        <td>
                            <a href="{{ route('inspection.edit', $row->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                            <form method="POST" action="{{ route('inspection.delete', $row->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm me-1">Hapus</button>
                            </form>
                            <a href="{{ url('/inspection/detail_kunjungan/'.$row->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>
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

