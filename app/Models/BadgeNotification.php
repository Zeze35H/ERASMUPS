<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgeNotification extends Model
{
  use HasFactory;

  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = 'BadgeNotification';

  protected $fillable = [
    'badge_id',
];

  public function notification() {
    return $this->belongsTo('App\Models\Notification', "id");
  }

  public function badge() {
    return $this->belongsTo('App\Models\Badge', "badge_id");
  }

}