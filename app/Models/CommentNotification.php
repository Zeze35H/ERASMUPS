<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentNotification extends Model
{
  use HasFactory;

  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = 'CommentNotification';

  protected $fillable = [
    'comment_id',
];

  public function notification() {
    return $this->belongsTo('App\Models\Notification', "id");
  }

  public function comment() {
    return $this->belongsTo('App\Models\Comment', "comment_id");
  }

}