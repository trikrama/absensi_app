{{-- @extends('layouts.admin.tabler')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar TTD</h4>
        <a href="{{ route('signatures.create') }}" class="btn btn-primary">Tambah TTD</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>TTD</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($signatures as $signature)
                        <tr>
                            <td>{{ $signature->name }}</td>
                            <td>{{ $signature->position ?? 'Tidak ada jabatan' }}</td>
                            <td class="text-center">
                                @if ($signature->image)
                                <a href="{{ asset('storage/uploads/ttd/' . $signature->image) }}" target="_blank" rel="noopener noreferrer">Lihat TTD</a>
    
                                @else
                                    <span class="text-muted">Tidak ada TTD</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('signatures.edit', $signature) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('signatures.destroy', $signature) }}" method="POST" class="d-inline" id="delete-form-{{ $signature->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $signature->id }}')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada data TTD.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menghapus TTD ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection --}}

@extends('layouts.admin.tabler')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar TTD</h4>
        <a href="{{ route('signatures.create') }}" class="btn btn-primary">Setting TTD</a>
    </div>

    @if ($signatures->isEmpty())
    <div class="alert alert-warning text-center">
        Tidak ada data TTD.
    </div>
    @else
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                @foreach ($signatures->chunk(2) as $pair)
                <div class="col-md-12 mb-4">
                    <div class="row">
                        <!-- TTD 1 -->
                        @if (isset($pair[0]))
                        <div class="col-md-6 d-flex flex-column align-items-center text-center border-end">
                            <h5>{{ $pair[0]->name }}</h5>
                            <p class="text-muted">{{ $pair[0]->position ?? 'Tidak ada jabatan' }}</p>
                            @if ($pair[0]->image)
                            <img src="{{ asset('storage/uploads/ttd/' . $pair[0]->image) }}" alt="TTD 1" class="img-thumbnail mb-2" style="max-width: 70%; max-height: 200px;">
                            @else
                            <span class="text-muted">Tidak ada TTD</span>
                            @endif
                        </div>
                        @endif

                        <!-- TTD 2 -->
                        @if (isset($pair[1]))
                        <div class="col-md-6 d-flex flex-column align-items-center text-center">
                            <h5>{{ $pair[1]->name }}</h5>
                            <p class="text-muted">{{ $pair[1]->position ?? 'Tidak ada jabatan' }}</p>
                            @if ($pair[1]->image)
                            <img src="{{ asset('storage/uploads/ttd/' . $pair[1]->image) }}" alt="TTD 2" class="img-thumbnail mb-2" style="max-width: 70%; max-height: 200px;">
                            @else
                            <span class="text-muted">Tidak ada TTD</span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
