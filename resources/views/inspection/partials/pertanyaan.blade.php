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
                            <input type="number" id="jawaban{{ $loop->index }}" name="details[{{ $instrument->id }}][jawaban]" class="form-control" min="0" max="100" required>
                        </div>
                        <div class="col-4">
                            <label for="keterangan{{ $loop->index }}" class="form-label">Keterangan:</label>
                            <textarea id="keterangan{{ $loop->index }}" name="details[{{ $instrument->id }}][keterangan]" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="details[{{ $instrument->id }}][id_instrumen]" value="{{ $instrument->id }}">
        @endforeach
    </div>
@endforeach
