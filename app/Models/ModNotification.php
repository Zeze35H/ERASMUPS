<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModNotification extends Model
{
  use HasFactory;

  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = 'ModNotification';

  protected $fillable = [
     
];

  public function notification() {
    return $this->belongsTo('App\Models\Notification', "id");
  }

}