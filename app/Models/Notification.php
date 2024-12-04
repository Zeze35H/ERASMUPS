<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\AnswerNotification;
use App\Models\CommentNotification;
use App\Models\FavAnswerNotification;
use App\Models\ReportNotification;
use App\Models\ModNotification;
use App\Models\BadgeNotification;
use App\Models\TagNotification;

class Notification extends Model
{
  use HasFactory;

  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = 'Notification';

  protected $fillable = [
    'id', 'text', 'timestamp', 'user_id'
  ];

  public function user()
  {
    return $this->belongsTo('App\Models\User', "user_id");
  }

  // NOTIFICATIONS

  public function getTypeNotification($notification)
  {

    if (AnswerNotification::find($notification->id) || CommentNotification::find($notification->id) || FavAnswerNotification::find($notification->id) || TagNotification::find($notification->id))
    {
      $question_id = null;

      if (AnswerNotification::find($notification->id))
        $question_id = Answer::find(AnswerNotification::find($notification->id)->answer_id)->question_id;
      else if (CommentNotification::find($notification->id))
        $question_id = Answer::find(Comment::find(CommentNotification::find($notification->id)->comment_id)->answer_id)->question_id;
      else if (FavAnswerNotification::find($notification->id))
        $question_id = Answer::find(FavAnswerNotification::find($notification->id)->answer_id)->question_id;
      else if (TagNotification::find($notification->id))
        $question_id = TagNotification::find($notification->id)->question_id;

      $title = DB::table('Question')->where('id', '=', $question_id)->first('title')->title;
        
      $question_title_chars = str_split(strtolower($title));
      $question_title = "";
      for($j = 0; $j < count($question_title_chars); $j++)
      {
          if($question_title_chars[$j] == " ")
              $question_title = $question_title . '_';
          else if(strpos("abcdefghijklmnopqrstuvwxyz0123456789-._~:/?#[]@!$&'()*+,;=", $question_title_chars[$j]) === false)
              $question_title = $question_title . strval(ord($question_title_chars[$j]));         
          else
              $question_title = $question_title . strval($question_title_chars[$j]);
      }

      if (AnswerNotification::find($notification->id))
        return array("Answer", 'question/' . $question_id . '/' . $question_title .'#content_' . AnswerNotification::find($notification->id)->answer_id);
      else if (CommentNotification::find($notification->id))
        return array("Comment", 'question/' . $question_id . '/' . $question_title .'#content_' . CommentNotification::find($notification->id)->comment_id);
      else if (FavAnswerNotification::find($notification->id))
        return array("Favourite Answer", 'question/' . $question_id . '/' . $question_title .'#content_' . FavAnswerNotification::find($notification->id)->answer_id);
      else if (TagNotification::find($notification->id))
        return array("Tag", 'question/' . $question_id . '/' . $question_title .'#content_' . TagNotification::find($notification->id)->question_id);

    }
    else
    {
      if (BadgeNotification::find($notification->id))
        return array("Badge", 'user/' . Auth::user()->id);
      else if (ReportNotification::find($notification->id))
        return array("Report", 'question/');
      else if (ModNotification::find($notification->id))
        return array("Mod", 'question/');
      else
        return 0;
    }
    
    


    
    
  }
}
