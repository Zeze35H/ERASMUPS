<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Tag extends Model
{
  use HasFactory;

  public $timestamps  = false;

  protected $table = 'Tag';

  protected $fillable = [
    'text',
  ];

  public function questions()
  {
    return $this->belongsToMany('App\Models\Question', 'TaggedQuestion', 'tag_id', 'question_id');
  }

  public function followedTags($numTags, $tags_array)
  {
    $ret = array();
    if ($numTags !== 0) {
      foreach ($tags_array as $tag) {

        $tag1 = Tag::where('text', '=', $tag)->first();

        $newTag = null;

        if ($tag1 === null) {
          $newTag = Tag::create(['text' => $tag]);
          DB::table('Tag')->where('id', '=', $newTag->id)->update(['equalTagsCnt' => 0]);
          DB::insert('INSERT INTO "FollowedTags" ("user_id", "tag_id") VALUES(?, ?)', [Auth::user()->id, $newTag->id]);
        } else {
          if (count(DB::select('SELECT * FROM "FollowedTags" WHERE "user_id" = ? AND "tag_id" = ?', [Auth::user()->id, $tag1->id])) !== 0)
            continue;
          else DB::insert('INSERT INTO "FollowedTags" ("user_id", "tag_id") VALUES(?, ?)', [Auth::user()->id, $tag1->id]);
        }

        array_push($ret, $tag);
      }
    }

    return $ret;
  }

  public function unFollowedTags($tag)
  {
    $tagId = $this->findTagId($tag);
    DB::delete('DELETE FROM "FollowedTags" WHERE "user_id" = ? AND "tag_id" = ?', [Auth::user()->id, $tagId]);
  }

  public function findTagId($tag) {
    return DB::select('SELECT "id" FROM "Tag" WHERE "text" = ?', [$tag])[0]->id;
  }
}
