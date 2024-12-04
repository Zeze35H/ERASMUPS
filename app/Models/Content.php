<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $table = 'Content';

    public $timestamps  = false;

    protected $fillable = [
        'text', 'user_id',
    ];

    public function author()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function hasBeenReported()
    {
        return $this->belongsToMany('App\Models\User', 'Report', 'content_id', 'user_id');
    }

}
