@extends('layouts.admin.tabler')

@section('content')
<title>Dashboard | HaloMutiara!</title>
<style>
	.bg-diagonal-gradient {
		background: linear-gradient(45deg, #effefd, #d9f7f5);
	}
</style>


<div class="container px-3 px-md-5 border-bottom pb-4">
  <p class="h6 text-success">Hi Molsyam,</p>
  <div class="d-flex flex-column flex-md-row justify-content-between">
    <div class="d-flex">
      <p class="font-weight-bold text-muted">Admin / Unit /</p>
      <a href="javascript:;" class="font-weight-bold text-success ml-1">Semua Unit</a>
    </div>
    <form class="d-flex mt-2 mt-md-0" method="POST" action="/admin/unit">@csrf
      <a href="{{ url('admin/unit/tambah') }}" class="btn btn-outline-success me-2">
        <i data-icon="tabler:plus" class="iconify"></i>
        Tambah Unit
      </a>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><i data-icon="iconamoon:search-bold" class="iconify"></i></span>
        </div>
        <input name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Cari Unit atau Kepala Unit..." aria-label="Search">
      </div>
      <button type="submit" class="btn btn-success ms-2">Cari</button>
    </form>
  </div>
</div>

<div class="container px-3 px-md-5 mt-4">
  <div class="overflow-auto">
    <table class="table table-bordered table-hover">
      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Kepala Unit</th>
          <th>No.Hp</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php $no = 1; @endphp
        @foreach ($data as $row)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $row->nama }}</td>
            <td>{{ $row->kepala_unit }}</td>
            <td>{{ $row->nohp }}</td>
            <td>
              <a href="{{ url('admin/unit/edit/'.$row->id) }}" class="btn btn-outline-success btn-sm">
                <i data-icon="tabler:edit" class="iconify"></i> Edit
              </a>
              <form method="POST" id="hapus_form" action="{{ url('admin/unit/delete/'.$row->id) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" id="btn-hapus" class="btn btn-outline-danger btn-sm">
                  <i data-icon="tabler:trash" class="iconify"></i> Hapus
                </button>
              </form>
              <a href="javascript:;" class="btn btn-outline-primary btn-sm">
                <i data-icon="tabler:eye" class="iconify"></i> Lihat
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-3">
    {{ $data->links() }}
  </div>
</div>



<script>
  $('#btn-hapus').on('click', function(){
		Swal.fire({
			title: "Anda Yakin?",
			text: "Anda Akan menghapus Data Unit ini",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya, Hapus Unit",
			cancelButtonText: "Batal"
		}).then((result) => {
      if (result.isConfirmed) {
        $('#hapus_form').submit();
      }
			return true;
		});
	})
</script>
@endsection