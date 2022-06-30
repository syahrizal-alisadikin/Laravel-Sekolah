@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Transaction</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-dollar-sign"></i> Edit Transaction</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Siswa</label>
                            <input type="text" name="name" value="{{ old('name',$transaction->siswa->name) }}" readonly class="form-control @error('name') is-invalid @enderror">

                           
                        </div>

                        <div class="form-group">
                            <label>Nama Pembayaran</label>
                            <select name="tagihan_id" class="form-control tagihan_id" id="tagihan_id">
                                <option value="">Pilih Pembayaran</option>
                                @foreach ($tagihan as $t)
                                <option value="{{ $t->id }}" {{ $t->id == $transaction->tagihan_id ? "selected" : "" }}>{{ $t->name }}</option>
                                @endforeach
                            </select>
                            @error('tagihan_id')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nominal Pembayaran</label>
                            <input type="text" readonly  value="{{ old('nominal',moneyFormat($transaction->nominal)) }}" id="nominal" placeholder="Masukkan Nominal Pembayaran" class="form-control @error('nominal') is-invalid @enderror">
                            <input type="hidden" name="nominal"  placeholder="Masukkan Nominal Pembayaran" value="{{ $transaction->nominal }}" class="form-control nominal">

                            @error('nominal')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                      

                      

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            UPDATE</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $("#tagihan_id").on("change",function(){
    var tagihan_id = $(this).val();
    var url = "{{ route('admin.pembayaran.getNominal', ':id') }}";
    url = url.replace(":id", tagihan_id);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function(data){
            const nominal = new Intl.NumberFormat('id-ID', {
                            maximumSignificantDigits: 5
                        }).format(data.nominal);
            $("#nominal").val(`RP ${nominal}`);
            $(".nominal").val(data.nominal);
        }
    });
});
</script>
@stop