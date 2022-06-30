@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kelas {{ $kela->name }}</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-hotel"></i> Kelas {{ $kela->name }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.kelas.show',$kela->id) }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                    </div>
                                <input type="text" class="form-control" value="{{ request()->q }}" name="q"
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
                            <tr class="text-center">
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">NAMA KELAS</th>
                                <th scope="col">EMAIL</th>
                                <th scope="col">PHONE</th>
                                <th scope="col">STATUS</th>
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($siswa as $no => $item)
                                <tr class="text-center">
                                    <th scope="row" style="text-align: center">{{ ++$no + ($siswa->currentPage()-1) * $siswa->perPage() }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email  }}</td>
                                    <td>{{ $item->phone ?? "-" }}</td>
                                    <td>{!! $item->status == "aktif" ? "<span  class='badge badge-success'>Aktif</span>" :  "<span  class='badge badge-info'>Tidak Aktif</span>" !!}</td>
                                    <td class="text-center">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>

                                           
                                    </td>
                                </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="6">Tidak ada data</td>                        
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


@stop