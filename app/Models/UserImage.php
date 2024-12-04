<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;

    protected $table = "UserImage";

    public $timestamps  = false;

    protected $fillable = [
        'path',
    ];
}
