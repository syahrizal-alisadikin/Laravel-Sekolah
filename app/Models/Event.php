<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Event extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ["id"];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/events/' . $value),
        );
    }
}
