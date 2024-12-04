<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $table = 'User';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password',
        'country', 'birthday', 'num_votes', 'num_questions',
        'num_comments', 'num_reports', 'num_answers', 'num_fav_answers',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function contents()
    {
        return $this->hasMany('App\Models\Content');
    }

    public function hasReported()
    {
        return $this->belongsToMany('App\Models\Content', 'Report', 'user_id', 'content_id');
    }

    public function getEmailForPasswordReset()
    {
        //DB::select('SELECT email FROM "User" WHERE "username" = ?', ['deleted' . $num]);
    }

    public function sendPasswordResetNotification($token)
    {
        /*         Mail::send('email.recover_password', ['token' => $token], function($message) use($request){

            $message->to($request->email);

            $message->subject('Reset Password');

        }); */
    }

    public function notification()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function getMyProfileInfo($id)
    {
        return DB::select(
            'SELECT "User"."id", "username", "name", "email", "trust_level",
                        "country", "bio", "erasmus_in_out", "birthday",
                        "num_votes", "num_questions", "num_comments",
                        "num_reports", "num_answers", "num_fav_answers",
                        "path",
                        COALESCE(
                        (
                            SELECT string_agg("type" || ? || "level", ?)
                            FROM "Badge", "EarnedBadge"
                            WHERE "EarnedBadge"."user_id" = "User"."id"
                            AND "EarnedBadge"."badge_id" = "Badge"."id"
                            GROUP BY "User"."id"
                        )
                        , ?) AS "badges",
                        COALESCE(
                            (SELECT string_agg("Tag"."text", ?)
                            FROM "Tag", "FollowedTags"
                            WHERE "FollowedTags"."user_id" = "User"."id"
                            AND "FollowedTags"."tag_id" = "Tag"."id"
                            GROUP BY "User"."id")
                        , ?) AS "tags",
                        COALESCE(
                            (SELECT string_agg("Content"."id"::text, ?)
                            FROM "Content", "Question"
                            WHERE "Content"."user_id" = "User"."id"
                            AND "Content"."id" = "Question"."id"
                            GROUP BY "User"."id")
                        , ?) AS "questions"
                    FROM "User", "UserImage"
                    WHERE "User"."profile_picture_id" = "UserImage"."id"
                    AND "User"."id" = ?',
            ["_", " ", "", " ", "", " ", "", $id]
        );
    }


    public function getUserQuestions($id)
    {
        return DB::select(
            'SELECT "Question"."id", "closed", "username", "user_id", "deleted", "UserImage"."path" AS "user_path", "title",
            "Content"."text" AS "text", "created_at"::DATE, "score",
            COALESCE(
            (
                SELECT string_agg("Tag"."text", ?)
                FROM "TaggedQuestion", "Tag"
                WHERE "TaggedQuestion"."question_id" = "Content"."id"
                AND "TaggedQuestion"."tag_id" = "Tag"."id"
                GROUP BY "title", "Content"."text"
            )
            , ?) AS "tags",
            COALESCE(
            (
                SELECT string_agg("QuestionImage"."path", ?)
                FROM "QuestionImage"
                WHERE "QuestionImage"."question_id" = "Content"."id"
                GROUP BY "title", "Content"."text"
            )
            , ?) AS "question_path"
        FROM "Content", "Question", "User", "UserImage"
        WHERE "Content"."user_id" = ?
        AND "Content"."id" = "Question"."id"
        AND "Content"."user_id" = "User"."id"
        AND "User"."profile_picture_id" = "UserImage"."id"',
            [' ', '', ' ', '', $id]
        );
    }

    public function getEditMyProfileInfo($id)
    {
        return DB::select('SELECT "username", "name", "email", "trust_level", "country", "bio", "birthday", "UserImage"."path" AS "user_path"
                    FROM "User", "UserImage"
                    WHERE "User"."profile_picture_id" = "UserImage"."id"
                    AND "User"."id" = ?', [$id]);
    }


    public function userExists($num)
    {
        return count(DB::select('SELECT * FROM "User" WHERE "username" = ?', ['deleted' . $num]));
    }

    public function deleteMyAccount(Request $request, $id)
    {
        User::find($id);
        $num = $id;

        DB::table('User')->where('id', $id)
            ->update([
                "username" => 'deleted' . $num,
                "email" => 'deleted' . $num,
                "name" => 'deleted' . $num,
                "password" => 'deleted' . $num,
                "trust_level" => 0,
                "country" => 'deleted' . $num,
                "bio" => NULL,
                "erasmus_in_out" => NULL,
                "profile_picture_id" => 1,
                "birthday" => '1990-01-01',
                "num_votes" => 0,
                "num_questions" => 0,
                "num_comments" => 0,
                "num_reports" => 0,
                "num_answers" => 0,
                "num_fav_answers" => 0,
                "deleted" => true,
            ]);

        Auth::logout();
    }

    public function getUsers(Request $request)
    {
        $data = $request->all();
        $input = $data['input'];

        return DB::select('SELECT "User"."id", "User"."username" AS "username", "UserImage"."path" AS "user_path",
            "User"."trust_level" AS "trust_level", 0 AS "num_interactions"
            FROM "User", "UserImage"
            WHERE "User"."id" != (SELECT "id" FROM "Admin")
            AND "UserImage"."id" = "User"."profile_picture_id"
            AND "User"."deleted" = false
            AND "User"."username" = ?',
            [$input]);
    }

}
