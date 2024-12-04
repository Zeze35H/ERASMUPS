<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class FollowedTags extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'FollowedTags';
  
    protected $fillable = [
      'tag_id', 'user_id'
  ];

  public function user()
  {
    return $this->hasOne('App\Models\Answer');
  }

  public function tag()
  {
    return $this->hasOne('App\Models\Answer');
  }

}