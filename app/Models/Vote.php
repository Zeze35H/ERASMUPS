<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'Vote';
  
    protected $fillable = [
        'user_id', 'content_id', 'value',
  ];
  

}