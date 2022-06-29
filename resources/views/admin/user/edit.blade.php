@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit User</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-unlock"></i> Edit User</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>NAMA USER</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                placeholder="Masukkan Nama User"
                                class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>EMAIL</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                placeholder="Masukkan Email" class="form-control @error('email') is-invalid @enderror">

                            @error('email')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PASSWORD</label>
                                    <input type="password" name="password" value="{{ old('password') }}"
                                        placeholder="Masukkan Password"
                                        class="form-control @error('password') is-invalid @enderror">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PASSWORD</label>
                                    <input type="password" name="password_confirmation"
                                        value="{{ old('password_confirmation') }}"
                                        placeholder="Masukkan Konfirmasi Password" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">ROLE</label> <br>
                           
                           <select name="roles" class="form-control" id="">
                            <option value="ADMIN" {{ $user->roles == "ADMIN" ? "selected" : "" }}>ADMIN</option>
                            <option value="USER" {{ $user->roles == "USER" ? "selected" : "" }}>USER</option>
                           </select>
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
@stop