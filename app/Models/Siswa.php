<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Siswa extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
