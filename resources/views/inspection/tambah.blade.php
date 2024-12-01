@extends('layouts.admin')

@section('content')
<title>Dashboard | HaloMutiara!</title>
<style>
	.bg-diagonal-gradient {
		background: linear-gradient(45deg, #effefd, #d9f7f5);
	}
</style>

<div class="container-fluid border-bottom pb-4">
  <p class="text-muted">Hi Molsyam,</p>
  <div class="d-flex justify-content-between align-items-center">
    <div class="d-flex gap-2 align-items-center">
      <p class="fw-bold text-muted">Admin / Unit /</p>
      <a href="javascript:;" class="fw-bold text-decoration-none text-primary">Tambah Unit</a>
    </div>
  </div>
</div>

<form method="post" id="form-unit" action="{{ url('admin/unit/store') }}">@csrf
<div class="container mt-4">
  <div class="card p-4">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="mb-3">
          <label for="nama" class="form-label fw-semibold">Nama Unit</label>
          <input name="nama" id="nama" type="text" class="form-control" placeholder="Masukkan Nama Unit">
        </div>
        <div class="mb-3">
          <label for="kepala_unit" class="form-label fw-semibold">Nama Kepala Unit</label>
          <input name="kepala_unit" id="kepala_unit" type="text" class="form-control" placeholder="Masukkan Nama Kepala Unit">
        </div>
        <div class="mb-3">
          <label for="nohp" class="form-label fw-semibold">Nomor Hp K.Unit</label>
          <input name="nohp" id="nohp" type="text" class="form-control" placeholder="Masukkan No.Hp Kepala Unit">
        </div>
        <div class="text-center mt-4">
          <button type="button" id="btn-submit" class="btn btn-primary w-100">Tambahkan Unit</button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>

<script>
	$('#btn-submit').on('click', function () {

		if ($('#nama').val() == "") {
			toastr.warning('Silahkan masukkan nama unit');
			return false;
		}
		if ($('#kepala_unit').val() == "") {
			toastr.warning('Silahkan masukkan nama kepala unit');
			return false;
		}
		if ($('#nohp').val() == "") {
			toastr.warning('Silahkan masukkan No.Hp Kepala Unit');
			return false;
		}

		Swal.fire({
			title: "Anda Yakin?",
			text: "Anda akan menambahkan data Unit Baru",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya, Tambahkan",
			cancelButtonText: "Saya Periksa Kembali"
		}).then((result) => {
			if (result.isConfirmed) {
				$('#form-unit').submit();
			}
		});
	});
</script>
@endsection
