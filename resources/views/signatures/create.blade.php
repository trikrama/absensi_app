{{-- @extends('layouts.admin.tabler')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4>Tambah TTD</h4>
                </div>
                <div class="card-body">
                    <div>
                        
                        <form action="{{ route('signatures.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <!-- Nama -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Penandatangan</label>
                                <input type="text" name="name" id="name" class="form-control" required
                                placeholder="Masukkan nama penandatangan">
                            </div>

                            <!-- Jabatan -->
                            <div class="mb-3">
                                <label for="position" class="form-label">Jabatan</label>
                                <input type="text" name="position" id="position" class="form-control"
                                    placeholder="Masukkan jabatan (opsional)">
                            </div>
                            
                            <!-- Upload TTD -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload TTD (opsional)</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                <small class="text-muted">Format file: JPG, PNG. Maksimal ukuran: 2MB.</small>
                            </div>

                            <!-- Buttons -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-4">Simpan</button>
                                <a href="{{ route('signatures.index') }}" class="btn btn-secondary px-4">Batal</a>
                            </div>
                        </form>
                    </div>

                    <div>
                        <form action="{{ route('signatures.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Penandatangan</label>
                                <input type="text" name="name" id="name" class="form-control" required
                                placeholder="Masukkan nama penandatangan">
                            </div>
                            
                            <!-- Jabatan -->
                            <div class="mb-3">
                                <label for="position" class="form-label">Jabatan</label>
                                <input type="text" name="position" id="position" class="form-control"
                                placeholder="Masukkan jabatan (opsional)">
                            </div>

                            <!-- Upload TTD -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload TTD (opsional)</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                <small class="text-muted">Format file: JPG, PNG. Maksimal ukuran: 2MB.</small>
                            </div>
                            
                            <!-- Buttons -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-4">Simpan</button>
                                <a href="{{ route('signatures.index') }}" class="btn btn-secondary px-4">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.admin.tabler')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4>Kelola TTD</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('signatures.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Form TTD 1 -->
                            <div class="col-md-6 border-end">
                                <h5 class="text-center">Form TTD 1</h5>
                                <div class="mb-3">
                                    <label for="name_1" class="form-label">Nama Penandatangan 1</label>
                                    <input type="text" name="name_1" id="name_1" class="form-control" 
                                        placeholder="Masukkan nama penandatangan 1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="position_1" class="form-label">Jabatan 1</label>
                                    <input type="text" name="position_1" id="position_1" class="form-control" 
                                        placeholder="Masukkan jabatan 1 (opsional)">
                                </div>
                                <div class="mb-3">
                                    <label for="image_1" class="form-label">Upload TTD 1</label>
                                    <input type="file" name="image_1" id="image_1" class="form-control" accept="image/*">
                                </div>
                            </div>

                            <!-- Form TTD 2 -->
                            <div class="col-md-6">
                                <h5 class="text-center">Form TTD 2</h5>
                                <div class="mb-3">
                                    <label for="name_2" class="form-label">Nama Penandatangan 2</label>
                                    <input type="text" name="name_2" id="name_2" class="form-control" 
                                        placeholder="Masukkan nama penandatangan 2">
                                </div>
                                <div class="mb-3">
                                    <label for="position_2" class="form-label">Jabatan 2</label>
                                    <input type="text" name="position_2" id="position_2" class="form-control" 
                                        placeholder="Masukkan jabatan 2 (opsional)">
                                </div>
                                <div class="mb-3">
                                    <label for="image_2" class="form-label">Upload TTD 2</label>
                                    <input type="file" name="image_2" id="image_2" class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success px-4">Simpan</button>
                            <a href="{{ route('signatures.index') }}" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
