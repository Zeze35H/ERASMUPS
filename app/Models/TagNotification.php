<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagNotification extends Model
{
  use HasFactory;

  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = 'TagNotification';

  protected $fillable = [
    'tag_id', 'question_id' 
];

  public function notification() {
    return $this->belongsTo('App\Models\Notification', "id");
  }

  public function tag() {
    return $this->belongsTo('App\Models\Tag', "tag_id");
  }

  public function question() {
    return $this->belongsTo('App\Models\Question', "question_id");
  }


}