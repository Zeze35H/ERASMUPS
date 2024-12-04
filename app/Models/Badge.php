<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'Badge';
  
    protected $fillable = [
      'type', 'level', 'min'
  ];
  
    public function users() {
        return $this->belongsToMany('App\Models\User');
    }

}
