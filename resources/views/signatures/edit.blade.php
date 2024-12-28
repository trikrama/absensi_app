@extends('layouts.admin.tabler')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Edit TTD</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('signatures.update', $signature) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Penandatangan</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ $signature->name }}" required>
                        </div>

                        <!-- Jabatan -->
                        <div class="mb-3">
                            <label for="position" class="form-label">Jabatan</label>
                            <input type="text" name="position" id="position" class="form-control" 
                                   value="{{ $signature->position }}">
                        </div>

                        <!-- Upload TTD -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload TTD Baru (opsional)</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <small class="text-muted">Jika tidak diisi, TTD yang lama tetap digunakan.</small>
                        </div>

                        <!-- TTD Preview -->
                        @if ($signature->image)
                        <div class="mb-3">
                            <label class="form-label">Preview TTD Saat Ini</label>
                            <div class="border p-2 text-center">
                                <img src="{{ asset('storage/uploads/ttd/' . $signature->image) }}" alt="TTD" class="img-fluid" 
                                     style="max-height: 150px;">
                            </div>
                        </div>
                        @endif

                        <!-- Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-4">Update</button>
                            <a href="{{ route('signatures.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
