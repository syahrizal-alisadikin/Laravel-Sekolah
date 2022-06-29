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
                    <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <select name="select" class="form-control" onchange="myTransaction()" required id="select">
                                <option value="">Pilih Transaksi</option>
                                <option value="siswa">Per Siswa</option>
                                <option value="kelas">Per Kelas</option>
                            </select>
                        </div>
                       

                        <div id="siswa" style="display: none">
                            <div class="form-group">
                                <label>Nama Siswa</label>
                                <select name="siswa_id" class="form-control" id="">
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
    
                            <div class="form-group">
                                <label>Nominal Pembayaran</label>
                                <input type="text"   placeholder="Masukkan Nominal Pembayaran" class="form-control" id="nominal">
                                <input type="hidden" name="nominal"  placeholder="Masukkan Nominal Pembayaran" class="form-control nominal">
    
                                @error('nominal')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                          
    
                           
                        </div>

                        <div id="kelas" style="display: none">
                            <div class="form-group">
                                <label>Nama Kelas</label>
                                <select name="kelas_id" class="form-control" id="">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                    @endforeach
                                @error('kelas_id')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label>Nama Pembayaran</label>
                                <select name="tagihan_id" class="form-control tagihan_id" >
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
                            </div> --}}
    
                            <div class="form-group">
                                <label>Nominal Pembayaran</label>
                                <input type="text"   placeholder="Masukkan Nominal Pembayaran" class="form-control" id="nominal">
                                <input type="hidden" name="nominal"  placeholder="Masukkan Nominal Pembayaran" class="form-control nominal">
    
                                @error('nominal')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                          
    
                          
                        </div>

                      

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
<script>
    var editor_config = {
        selector: "textarea.content",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
    };

    tinymce.init(editor_config);

</script>
<script>
function myTransaction() {
  var transaction = document.getElementById("select").value;
//   console.log(transaction);
  if(transaction == ""){
    $("#kelas").hide();
       $("#siswa").hide();
       $(".tagihan_id").empty();

  }else if(transaction == "siswa"){
       $("#siswa").show();
       $("#kelas").hide();
        $("#tagihan_id").val("");
    }else{
        $("#kelas").show();
       $("#siswa").hide();
       $("#tagihan_id").val("");



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