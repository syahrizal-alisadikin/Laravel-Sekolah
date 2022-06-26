@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kelas</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-hotel"></i> Kelas</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.kelas.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                    </div>
                                <input type="text" class="form-control" name="q"
                                       placeholder="cari berdasarkan nama kelas">
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
                            <tr class="text-center">
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">NAMA KELAS</th>
                                <th scope="col">JUMLAH SISWA</th>
                                <th scope="col">DESKRIPSI</th>
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($kelas as $no => $item)
                                <tr class="text-center">
                                    <th scope="row" style="text-align: center">{{ ++$no + ($kelas->currentPage()-1) * $kelas->perPage() }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->siswa_count  }}</td>
                                    <td>{{ $item->description ?? "-" }}</td>
                                    <td class="text-center">
                                            <a href="{{ route('admin.kelas.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>

                                            <a href="{{ route('admin.kelas.show', $item->id) }}" class="btn btn-sm btn-success">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                    </td>
                                </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="5">Tidak ada data</td>                        
                            </tr>
                                
                            @endforelse
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$kelas->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>


@stop