<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/posts/' . $value),
        );
    }

    public function category()
    {
        // Post Relasi ke 1 Category
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        // Post Relasi ke Banyak Tag
        return $this->belongsToMany(Tag::class);
    }

    protected function createdAt(): Attribute
    {   
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y'),
        );
    }
       
}
