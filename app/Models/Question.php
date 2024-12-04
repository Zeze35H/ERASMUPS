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
use App\Models\QuestionImage;
use App\Models\Tag;


class Question extends Model
{
  use HasFactory;

  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  protected $table = 'Question';

  protected $fillable = [
    'id', 'title',
  ];

  public function answers()
  {
    return $this->hasMany('App\Models\Answer');
  }

  public function images()
  {
    return $this->hasMany('App\Model\QuestionImage');
  }

  public function tags()
  {
    return $this->belongsToMany('App\Models\Tag', 'TaggedQuestion', 'question_id', 'tag_id');
  }

  public function content()
  {
    return $this->belongsTo('App\Models\Content', "id");
  }

  // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
  // $$$$$$$$$$$$$$ - AUXILIAR - $$$$$$$$$$$$$$$$
  // $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ 


  public function getQuestion($id)
  {

    $id_auth_user = 0;

    if (Auth::check()) {
      $id_auth_user = Auth::user()->id;
    }

    return DB::select(
      'SELECT "Question"."id", "username", "closed", "user_id", "deleted", "UserImage"."path" AS "user_path", "title",
                            "Content"."text" AS "text", date_trunc(\'second\', "created_at") AS "created_at", date_trunc(\'second\', "edited_at") AS "edited_at", "score",
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
                            , ?) AS "question_path",
                            (
                                SELECT "value" 
                                FROM "Vote"
                                WHERE "Vote"."content_id" = ?
                                AND "Vote"."user_id" = ?
                            ) AS "votes"
                        FROM "Content", "Question", "User", "UserImage"
                        WHERE "Content"."id" = ?
                        AND "Content"."id" = "Question"."id"
                        AND "Content"."user_id" = "User"."id"
                        AND "User"."profile_picture_id" = "UserImage"."id"',
      [' ', ' ', ' ', ' ', $id, $id_auth_user, $id]
    );
  }


  public function addQuestion(Request $request, $data, $numTags, $tags_array)
  {

    $id = null;
    DB::transaction(function () use (&$id, $request, $data, $numTags, $tags_array) {
      $content = Content::create([
        'text' => $data['text'],
        'user_id' => Auth::user()->id,
      ]);

      $question = Question::create([
        'id' => $content->id,
        'title' => $data['title'],
      ]);

      // insert tags related to the question
      if ($numTags !== 0) {
        foreach ($tags_array as $tag) {
          $tag1 = Tag::where('text', '=', $tag)->first();

          $newTag = null;
          if ($tag1 === null) $newTag = Tag::create(['text' => $tag]);
          else DB::table('Tag')->where('id', '=', $tag1->id)->update(['equalTagsCnt' => Tag::where('text', '=', $tag)->first()->equalTagsCnt + 1]);

          $id;
          if ($newTag === null) $id = Tag::where('text', '=', $tag)->first()->id;
          else $id = $newTag->id;

          DB::insert('insert into "TaggedQuestion"("tag_id", "question_id") values(?, ?)', [$id, $question->id]);
        }
      }

      // insert images related to question
      if ($request->image !== null) {
        $num = 0;
        foreach ($request->image as $image) {
          $imageName = time() . '-' . $num . '.' . $image->extension();
          $image->move(public_path('images'), $imageName);

          QuestionImage::create(['path' => 'images/' . $imageName, 'question_id' => $question->id]);
          $num = $num + 1;
        }
      }

      $id = $question->id;
    });

    return $id;
  }

  // EDIT FUNCTIONS

  public function editQuestion(Request $request, $id)
  { 
    $data = $request->all();
    $title = $request->has("title") ? $data['title'] : null;
    $body = $request->has("text") ? $data['text'] : null;
    $isMod = $request->has("isMod") ? $data['isMod'] : null;

    $tags = $data['tags'];

    $tagsArray = explode(" ", $tags);
    $textsOld = [];
    $oldTagsTexts = DB::select('SELECT "text" from "Tag","TaggedQuestion" where "Tag"."id" = "TaggedQuestion"."tag_id" and "TaggedQuestion"."question_id" = ?', [$id]);

    // if (
    //   ($title !== null && $body != null && count(DB::select('SELECT "text" from "Content" where "id" = ? and "text" = ?', [$id, $body])) > 0
    //     && count(DB::select('SELECT "title" from "Question" where "id" = ? and "title" = ?', [$id, $title])) > 0
    //     && $textsOld === $oldTagsTexts) || ($title === null && $body === null && $textsOld === $oldTagsTexts)
    // )
    //   return json_encode(array_merge(array($this->getQuestion($id)[0]), array("edited" => false)));


    //Check if title and body exists if not a mod editing others tags
    if ($title !== null && $body !== null) {
      DB::table('Content')->where('id', $id)->update(["text" => $body, "edited_at" => now()]);
      DB::table('Question')->where('id', $id)->update(["title" => $title]);
    } 
    else if($isMod !== null){

    }
    else 
      return json_encode(array_merge(array($this->getQuestion($id)[0]), array("edited" => "empty")));

    $tagsArrayTemp = $tagsArray;
    for ($i = 0; $i < count($tagsArrayTemp); $i++) {
      $tagsArrayTemp[$i] = strtolower($tagsArrayTemp[$i]);
    }
    //Check if no tags are duplicate
    if(count($tagsArrayTemp) !== count(array_unique($tagsArrayTemp)))
      return json_encode(array_merge(array($this->getQuestion($id)[0]), array("edited" => "duplicate")));

    DB::delete('Delete From "TaggedQuestion" where "question_id" = ?', [$id]);
    $array = DB::select('Select * From "TaggedQuestion" where "question_id" = ?', [$id]);

    //Delete old Tags
    $oldTagsTexts = DB::select('SELECT "text" from "Tag","TaggedQuestion" where "Tag"."id" = "TaggedQuestion"."tag_id" and "TaggedQuestion"."question_id" = ?', [$id]);
    foreach ($oldTagsTexts as $oldText) {
      $tag1 = Tag::where('text', '=', $oldText)->first();

      if ($tag1->equalTagsCnt > 1) {
        DB::table('Tag')->where('text', $oldText)->update(['equalTagsCnt' => $tag1->equalTagsCnt - 1]);
      } else {
        DB::table('Tag')->where('text', $oldText)->delete();
      }
    }
    if ($tags === "")
      return json_encode(array_merge(array($this->getQuestion($id)[0]), array("edited" => true)));

    //Add Tags
    $numTags = count($tagsArray);
    foreach ($tagsArray as $tag) {
      $tag1 = Tag::where('text', '=', $tag)->first();

      $newTag = null;
      if ($tag1 === null) $newTag = Tag::create(['text' => $tag]);
      else DB::table('Tag')->where('id', '=', $tag1->id)->update(['equalTagsCnt' => Tag::where('text', '=', $tag)->first()->equalTagsCnt + 1]);

      $tag_id = null;
      if ($newTag === null) $tag_id = Tag::where('text', '=', $tag)->first()->id;
      else $tag_id = $newTag->id;

      DB::insert('insert into "TaggedQuestion"("tag_id", "question_id") values(?, ?)', [$tag_id, $id]);
    }

    return json_encode(array_merge(array($this->getQuestion($id)[0]), array("edited" => true)));
  }


  // REMOVE FUNCTIONS

  public function removeQuestion(Request $request, $id)
  {
    DB::beginTransaction();
    try {
      Content::where('id', $id)->delete();
      DB::commit();
      return 'Your question was deleted!';
    } catch (QueryException $e) {
      DB::rollBack();

      $content = Content::where('id', $id)->first();
      $owner = User::where('id', $content->user_id)->first();
      User::where('id', $content->user_id)->update(['num_questions' => $owner->num_questions - 1, 'num_votes' => $owner->num_votes - $content->score]);
      Content::where('id', $id)->update(['user_id' => 1]);

      return 'Removed ownership from question.';
    }
  }


  public function close($id)
  {
    Content::where('id', $id)->update(['closed' => true]);
  }

  // VOTING FUNCTIONS

  public function voteQuestions(Request $request, $id_content)
  {
    $user_id = Auth::user()->id;

    DB::insert('insert into "Vote"("user_id", "content_id", "value") values(?, ?, ?)', [$user_id, $id_content,  $request->all()['value']]);
  }

  public function removeQuestionsVote(Request $request, $id_content)
  {
    $user_id = Auth::user()->id;

    DB::delete('delete from "Vote" where "user_id" = ? and "content_id" = ? ', [$user_id, $id_content]);
  }

  public function getAllQuestions($id)
  {
    return DB::select(
      'SELECT "Question"."id", "title", "Content"."text", "created_at", "score",
                                (
                                    SELECT string_agg("Tag"."text", ?)
                                    FROM "TaggedQuestion", "Tag"
                                    WHERE "TaggedQuestion"."question_id" = "Content"."id"
                                    AND "TaggedQuestion"."tag_id" = "Tag"."id"
                                    GROUP BY "title", "Content"."text"
                                )  AS "tags"
                            FROM "Content", "Question"
                            WHERE "Content"."id" = "Question"."id"
                            AND "Content"."visible" = true
                            AND "Content"."id" = ?
                            ORDER BY "Content"."created_at" DESC, "Content"."score" DESC',
      [' ', $id]
    );
  }


  public function getQuestions()
  {
    return DB::select(
      'SELECT "Question"."id", "title", "Content"."text", "created_at", "score",
                              (
                                  SELECT string_agg("Tag"."text", ?)
                                  FROM "TaggedQuestion", "Tag"
                                  WHERE "TaggedQuestion"."question_id" = "Content"."id"
                                  AND "TaggedQuestion"."tag_id" = "Tag"."id"
                                  GROUP BY "title", "Content"."text"
                              )  AS "tags"
                          FROM "Content", "Question"
                          WHERE "Content"."id" = "Question"."id"
                          AND "Content"."visible" = true
                          ORDER BY "Content"."created_at" DESC, "Content"."score" DESC',
      [' ']
    );
  }

  public function searchQuestions($input)
  {

    return DB::select(
      'SELECT "Question"."id", "title", "Content"."text", "Content"."created_at", "score",
              COALESCE(
                  (
                      SELECT string_agg("Tag"."text", ?)
                      FROM "TaggedQuestion", "Tag"
                      WHERE "TaggedQuestion"."question_id" = "Content"."id"
                      AND "TaggedQuestion"."tag_id" = "Tag"."id"
                      GROUP BY "title", "Content"."text"
                  )
                  , ?)  AS "tags"
              FROM "Content", "Question",
              (
                  SELECT "big_search"."id", ts_rank("search", to_tsquery(?, ?)) AS "rank"
                  FROM "big_search"
                  WHERE "search" @@ to_tsquery(?, ?)
              ) AS "search_results"
              WHERE "Content"."id" = "Question"."id"
              AND "Content"."id" = "search_results"."id"
              AND "Content"."visible" = true
              ORDER BY "search_results"."rank" DESC, "created_at" DESC, "score" DESC',
      [' ', '', 'simple', $input, 'simple', $input]
    );
  }

  public function searchQuestionsByTag($tag){
    return DB::select(
      'SELECT "Question"."id", "title", "Content"."text", "Content"."created_at", "score",
              COALESCE(
                  (
                      SELECT string_agg("Tag"."text", ?)
                      FROM "TaggedQuestion", "Tag"
                      WHERE "TaggedQuestion"."question_id" = "Content"."id"
                      AND "TaggedQuestion"."tag_id" = "Tag"."id"
                      GROUP BY "title", "Content"."text"
                  )
                  , ?)  AS "tags"
              FROM "Content", "Question",
              (
                  SELECT "big_search"."id", ts_rank("search", to_tsquery(?, ?)) AS "rank"
                  FROM "big_search"
                  WHERE "search" @@ to_tsquery(?, ?)
              ) AS "search_results"
              WHERE "Content"."id" = "Question"."id"
              AND "Content"."id" = "search_results"."id"
              AND "Content"."visible" = true
              ORDER BY "search_results"."rank" DESC, "created_at" DESC, "score" DESC',
      [' ', '', 'simple', $tag, 'simple', $tag]
    );
  }
}
