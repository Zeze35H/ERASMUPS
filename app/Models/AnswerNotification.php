<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerNotification extends Model
{
  use HasFactory;

  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = 'AnswerNotification';

  protected $fillable = [
    'answer_id',
];

  public function notification() {
    return $this->belongsTo('App\Models\Notification', "id");
  }

  public function answer() {
    return $this->belongsTo('App\Models\Answer', "answer_id");
  }

}