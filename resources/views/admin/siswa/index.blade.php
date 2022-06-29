@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Users</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-users"></i> Siswa</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.siswa.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                {{-- @can('users.create') --}}
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                    </div>
                                {{-- @endcan --}}
                                <input type="text" class="form-control" name="q"
                                       placeholder="cari berdasarkan nama siswa">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">NISN</th>
                                <th scope="col">NAMA</th>
                                <th scope="col">EMAIL</th>
                                <th scope="col">PHONE</th>
                                <th scope="col">KELAS</th>
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($siswa as $no => $item)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($siswa->currentPage()-1) * $siswa->perPage() }}</th>
                                    <td>{{ $item->nisn ?? "-" }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->kelas->name }}</td>
                                        
                                    <td class="text-center">
                                        {{-- @can('users.edit') --}}
                                            <a href="{{ route('admin.siswa.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        {{-- @endcan --}}
                                        
                                        {{-- @can('users.delete') --}}
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $item->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$siswa->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<script>
    //ajax delete
    function Delete(id)
        {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    //ajax delete
                    jQuery.ajax({
                        url: "/admin/siswa/"+id,
                        data:   {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }else{
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    return true;
                }
            })
        }
</script>
@stop