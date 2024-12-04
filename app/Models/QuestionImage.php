<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionImage extends Model
{
    use HasFactory;

    protected $table = "QuestionImage";

    public $timestamps  = false;

    protected $fillable = [
        'path', 'question_id',
    ];

    public function questionOwner() {
        return $this->belongsTo('App\Models\Question');
    }
}
