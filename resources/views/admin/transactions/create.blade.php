@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Transactios</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-dollar-sign"></i> Tambah Transactios</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.transactions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Pilih</label>
                                <select name="select" class="form-control" onchange="myTransaction()" required id="select">
                                    <option value="siswa">Per Siswa</option>
                                    <option value="kelas"  @error('kelas_id') selected @enderror >Per Kelas</option>
                                </select>
                        </div>
                       

                       
                        <div class="form-group" id="siswa" @error('kelas_id') style="display: none" @enderror>
                            <label>Nama Siswa</label>
                                <select name="siswa_id" class="form-control" >
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                                @error('siswa_id')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                           
                        </div>
                       
                        <div class="form-group " id="kelas"  @error('kelas_id') style="display: block !important" @else style="display: none"  @enderror>
                            <label>KELAS</label>
                            <select name="kelas_id" class="form-control "  >
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            @error('kelas_id')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        

                       
                        <div class="form-group">
                            <label>Nama Pembayaran</label>
                            <select name="tagihan_id" class="form-control tagihan_id" id="tagihan_id">
                                <option value="">Pilih Pembayaran</option>
                                @foreach ($tagihan as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                            @error('tagihan_id')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group ">
                            <label>Nominal Pembayaran</label>
                            <input type="text"   placeholder="Masukkan Nominal Pembayaran" class="form-control" id="nominal">
                            <input type="hidden" name="nominal"  placeholder="Masukkan Nominal Pembayaran" class="form-control nominal">

                            @error('nominal')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Status Pembayaran</label>
                            <select name="status" class="form-select" id="">
                                <option value="PENDING" >PENDING</option>
                                <option value="SUCCESS" >SUCCESS</option>

                            </select>
                            @error('status')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                       
                       
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            SIMPAN</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
function myTransaction() {
  var transaction = document.getElementById("select").value;
//   console.log(transaction);
 if(transaction == "siswa"){
    console.log(transaction)

       $("#siswa").show();
       $("#kelas").hide();
    }else{
        console.log(transaction)
        $("#siswa").hide();
        $("#kelas").show();



    }
}

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
@endsection