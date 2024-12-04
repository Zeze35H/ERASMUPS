<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportNotification extends Model
{
  use HasFactory;

  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = 'ReportNotification';

  protected $fillable = [
    'report_id', 
];

  public function notification() {
    return $this->belongsTo('App\Models\Notification', "id");
  }

  public function report() {
    return $this->belongsTo('App\Models\Report', "report_id");
  }

}