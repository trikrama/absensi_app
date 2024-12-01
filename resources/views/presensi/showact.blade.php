@if ($dataizin->doc_sid != null)
<div class="row">
    <div class="col-12 text-center my-3">
        @php
            $docsid = Storage::url('/uploads/sid/'.$dataizin->doc_sid);
        @endphp
        <!-- Trigger modal with image -->
        <img src="{{ url($docsid) }}" alt="Document Image" width="300px" class="img-thumbnail" data-toggle="modal" data-target="#imageModal" style="cursor: pointer;">
    </div>
</div>

<!-- Modal to display the image in full-screen -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body d-flex justify-content-center align-items-center">
                <img src="{{ url($docsid) }}" alt="Document Image" class="img-fluid rounded" style="max-height: 180vh;">
            </div>
        </div>
    </div>
</div>
@endif

<!-- Action Buttons -->
<ul class="action-button-list list-unstyled d-flex justify-content-center mt-4">
    <li class="mx-2">
        @if ($dataizin->status == "i")
        <a href="/izinabsen/{{ $dataizin->kode_izin }}/edit" class="btn btn-outline-primary btn-sm">
            <ion-icon name="create-outline"></ion-icon> Edit
        </a>
        @elseif ($dataizin->status == "s")
        <a href="/izinsakit/{{ $dataizin->kode_izin }}/edit" class="btn btn-outline-warning btn-sm">
            <ion-icon name="create-outline"></ion-icon> Edit
        </a>
        @elseif ($dataizin->status == "c")
        <a href="/izincuti/{{ $dataizin->kode_izin }}/edit" class="btn btn-outline-info btn-sm">
            <ion-icon name="create-outline"></ion-icon> Edit
        </a>
        @endif
    </li>
    <li class="mx-2">
        <a href="#" id="deletebutton" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteConfirm">
            <ion-icon name="trash-outline"></ion-icon> Delete
        </a>
    </li>
</ul>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirm" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="hapuspengajuan" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#deletebutton").click(function(e) {
            $("#hapuspengajuan").attr('href', '/izin/' + '{{ $dataizin->kode_izin }}/delete');
        });
    });
</script>
