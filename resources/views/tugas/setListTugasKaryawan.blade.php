<div class="row mt-2">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIK</th>
                    <th>Nama Karyawan</th>
                    <th>Jabatan</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody id="loadsetlisttugaskaryawan"></tbody>
        </table>
    </div>
</div>

<script>
    $(function() {
        function loadsetlisttugaskaryawan() {
            var tugas_id = "{{ $tugas_id }}";
            console.log(tugas_id)
            $("#loadsetlisttugaskaryawan").load('/tugas/' + tugas_id +
                '/getsetlisttugaskaryawan');
        }

        loadsetlisttugaskaryawan();
    });
</script>
