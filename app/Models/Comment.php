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

class Comment extends Model
{
  use HasFactory;

  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = 'Comment';

  protected $fillable = [
    'id', 'answer_id',
  ];

  public function answer()
  {
    return $this->hasOne('App\Models\Answer');
  }

  public function content()
  {
    return $this->belongsTo('App\Models\Content', "id");
  }

  public function getAnswerComments($id)
  {
    $id_auth_user = 0;

    if (Auth::check()) {
      $id_auth_user = Auth::user()->id;
    }
    return DB::select(
      'SELECT "Comment"."answer_id", "Comment"."id", "User"."username" AS "username", "user_id", "deleted", "UserImage"."path" AS "user_path",
                            "Content"."score" AS "score", "Content"."text" AS "text",
                            date_trunc(\'second\', "created_at") AS "created_at", date_trunc(\'second\', "edited_at") AS "edited_at",
                            (
                                SELECT "value" 
                                FROM "Vote"
                                WHERE "Vote"."content_id" = "Comment"."id"
                                AND "Vote"."user_id" = ?
                            ) AS "votes"
                            FROM "Content", "Comment", "User", "UserImage"
                            WHERE "Content"."user_id" = "User"."id"
                            AND "User"."profile_picture_id" = "UserImage"."id"
                            AND ? = "Comment"."answer_id"
                            AND "Content"."id" = "Comment"."id"
                            ORDER BY "Content"."created_at" ASC',
      [$id_auth_user, $id]
    );
  }

  public function getComment($id)
  {
    $id_auth_user = 0;

    if (Auth::check()) {
      $id_auth_user = Auth::user()->id;
    }
    return DB::select(
      'SELECT "Comment"."answer_id", "Comment"."id", "User"."username" AS "username", "user_id", "deleted", "UserImage"."path" AS "user_path",
                            "Content"."score" AS "score", "Content"."text" AS "text",
                            date_trunc(\'second\', "created_at") AS "created_at", date_trunc(\'second\', "edited_at") AS "edited_at",
                            (
                                SELECT "value" 
                                FROM "Vote"
                                WHERE "Vote"."content_id" = "Comment"."id"
                                AND "Vote"."user_id" = ?
                            ) AS "votes"
                            FROM "Content", "Comment", "User", "UserImage"
                            WHERE "Content"."user_id" = "User"."id"
                            AND "User"."profile_picture_id" = "UserImage"."id"
                            AND ? = "Comment"."id"
                            AND "Content"."id" = "Comment"."id"',
      [$id_auth_user, $id]
    );
  }

  public function commentExists($id_comment, $body)
  {
    return count(DB::select('SELECT "text" from "Content" where "id" = ? and "text" = ?', [$id_comment, $body])) > 0;
  }

  public function editComment($id_comment, $body)
  {
    DB::table('Content')->where('id', $id_comment)->update(["text" => $body, "edited_at" => now()]);
  }

  public function removeComment(Request $request, $id_comment)
  {
    DB::beginTransaction();
    try {
      Content::where('id', $id_comment)->delete();
      DB::commit();
      return json_encode(
        array(
          'success' => true,
          'comment_id' => $id_comment,
        )
      );
    } catch (QueryException $e) {
      DB::rollBack();

      $content = Content::where('id', $id_comment)->first();
      $owner = User::where('id', $content->user_id)->first();
      User::where('id', $content->user_id)->update(['num_questions' => $owner->num_answers - 1, 'num_votes' => $owner->num_votes - $content->score]);
      Content::where('id', $id_comment)->update(['user_id' => 1]);

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
          'comment_id' => $id_comment,
          'username' => $anonymous->username,
          'src' => $src,
        )
      );
    }
  }

  public function addComment($id_question, $id_answer, Request $request)
  {
    $data = $request->all();

    $var = array_keys($data)[2];

    DB::transaction(function () use ($id_answer, $data, $var) {
      $content = Content::create([
        'text' => $data[$var],
        'user_id' => Auth::user()->id,
      ]);

      $comment = Comment::create([
        'id' => $content->id,
        'answer_id' => $id_answer,
      ]);
    });
  }

  // VOTING

  public function voteComments(Request $request, $id_comment)
  {
    $user_id = Auth::user()->id;

    DB::insert('insert into "Vote"("user_id", "content_id", "value") values(?, ?, ?)', [$user_id, $id_comment, $request->all()['value']]);
  }

  public function removeCommentsVote(Request $request, $id_comment)
  {
    $user_id = Auth::user()->id;

    DB::delete('delete from "Vote" where "user_id" = ? and "content_id" = ? ', [$user_id, $id_comment]);
  }
}
