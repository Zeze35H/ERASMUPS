<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

use App\Models\User;
use App\Models\Content;
use App\Models\UserImage;

class Answer extends Model
{
  use HasFactory;

  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = 'Answer';

  protected $fillable = [
    'id', 'question_id',
  ];

  public function question()
  {
    return $this->hasOne('App\Models\Question');
  }

  public function comments()
  {
    return  $this->hasMany('App\Models\Comment');
  }

  public function content()
  {
    return $this->belongsTo('App\Models\Content', "id");
  }

  public function getQuestionAnswers($id)
  {

    $id_auth_user = 0;

    if (Auth::check()) {
      $id_auth_user = Auth::user()->id;
    }

    return DB::select(
      'SELECT "Answer"."question_id", "Answer"."id", "User"."username" AS "username", "user_id", "deleted", "UserImage"."path" AS "user_path",
                                "Content"."score" AS "score", "Answer"."selected" AS "selected",
                                "Content"."text" AS "text", date_trunc(\'second\', "created_at")  AS "created_at", date_trunc(\'second\', "edited_at") AS "edited_at",
                                (
                                SELECT "value" 
                                FROM "Vote"
                                WHERE "Vote"."content_id" = "Answer"."id"
                                AND "Vote"."user_id" = ?
                            ) AS "votes"
                            FROM "Content", "Answer", "User", "UserImage"
                            WHERE "Content"."user_id" = "User"."id"
                            AND "User"."profile_picture_id" = "UserImage"."id"
                            AND "Content"."id" = "Answer"."id" 
                            AND ? = "Answer"."question_id"
                            ORDER BY
                            CASE
                                WHEN "Answer"."selected" THEN 1
                                ELSE 2
                            END,
                            "Content"."score" DESC,
                            "Content"."created_at" ASC',
      [$id_auth_user, $id]
    );
  }

  public function getAnswer($id)
  {
    $id_auth_user = 0;

    if (Auth::check()) {
      $id_auth_user = Auth::user()->id;
    }

    return DB::select(
      'SELECT "Answer"."question_id", "Answer"."id", "User"."username" AS "username", "user_id", "deleted", "UserImage"."path" AS "user_path",
                                "Content"."score" AS "score", "Answer"."selected" AS "selected",
                                "Content"."text" AS "text", date_trunc(\'second\', "created_at")  AS "created_at", date_trunc(\'second\', "edited_at") AS "edited_at",
                                (
                                SELECT "value" 
                                FROM "Vote"
                                WHERE "Vote"."content_id" = "Answer"."id"
                                AND "Vote"."user_id" = ?
                            ) AS "votes"
                            FROM "Content", "Answer", "User", "UserImage"
                            WHERE "Content"."user_id" = "User"."id"
                            AND "User"."profile_picture_id" = "UserImage"."id"
                            AND "Content"."id" = "Answer"."id" 
                            AND ? = "Answer"."id"',
      [$id_auth_user, $id]
    );
  }

  public function addAnswer(Request $request, $id)
  {
    $data = $request->all();

    DB::transaction(function () use ($id, $data, &$content, &$answer) {
      $content = Content::create([
        'text' => $data['text_answer'],
        'user_id' => Auth::user()->id,
      ]);

      $answer = Answer::create([
        'id' => $content->id,
        'question_id' => $id,
      ]);
    });
  }

  public function editAnswer(Request $request, $id_answer)
  {
    $data = $request->all();
    $body = $data['text'];

    DB::table('Content')->where('id', $id_answer)->update(["text" => $body, "edited_at" => now()]);
  }

  public function answerExists($id_answer, $body)
  {
    return count(DB::select('SELECT "text" from "Content" where "id" = ? and "text" = ?', [$id_answer, $body])) > 0;
  }

  public function removeAnswer(Request $request, $id_answer)
  {
    DB::beginTransaction();
    try {
      Content::where('id', $id_answer)->delete();
      DB::commit();
      return json_encode(
        array(
          'success' => true,
          'answer_id' => $id_answer,
        )
      );
    } catch (QueryException $e) {
      DB::rollBack();

      $content = Content::where('id', $id_answer)->first();
      $owner = User::where('id', $content->user_id)->first();
      User::where('id', $content->user_id)->update(['num_questions' => $owner->num_answers - 1, 'num_votes' => $owner->num_votes - $content->score]);
      Content::where('id', $id_answer)->update(['user_id' => 1]);

      $anonymous = User::where('id', 1)->first();
      $anonymous_image = UserImage::where('id', $anonymous->profile_picture_id)->first();
      $type = explode('/', $anonymous_image->path)[0];
      $src = null;
      if ($type === "images")
        $src = asset($anonymous_image->path);
      else
        $src = $anonymous_image->path;

      return json_encode(
        array(
          'success' => false,
          'answer_id' => $id_answer,
          'username' => $anonymous->username,
          'src' => $src,
        )
      );
    }
  }

  public function voteAnswers(Request $request, $id_answer)
  {
    $user_id = Auth::user()->id;

    DB::insert('insert into "Vote"("user_id", "content_id", "value") values(?, ?, ?)', [$user_id, $id_answer, $request->all()['value']]);
  }

  public function removeAnswersVote(Request $request, $id_answer)
  {
    $user_id = Auth::user()->id;

    DB::delete('delete from "Vote" where "user_id" = ? and "content_id" = ? ', [$user_id, $id_answer]);
  }

}
