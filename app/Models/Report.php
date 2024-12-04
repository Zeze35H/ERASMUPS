<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class Report extends Model
{
  use HasFactory;

  public $timestamps  = false;

  protected $table = 'Report';

  protected $fillable = [
    'user_id', 'content_id', 'question_id',
    'mod_id', 'status',
    'timestamp', 'reason',
  ];

  public function treatReport(Request $request, $id)
  {

    $reason = $request->all()['reason'];

    DB::beginTransaction();
    try {
      DB::select('call treat_report(?,?,?)', [$id, $reason, Auth::user()->id]);
      DB::commit();
      $reason_clean = "ERROR";
      if ($reason == "delete_content")
        $reason_clean = "Delete content.";
      else if ($reason == "ban_author")
        $reason_clean = "Ban author.";
      else if ($reason == "ignore_report")
        $reason_clean = "Ignore report.";
      return json_encode(
        array(
          'success' => true,
          'message' => "Report treated with success! Action performed: " . $reason_clean,
          'id' => $id,
          'reason' => $reason
        )
      );
    } catch (QueryException $e) {
      DB::rollBack();

      $message = $e->getMessage();
      $temp = explode("CONTEXT:", $message)[0];
      $message_trim = explode(":", $temp)[3];

      return json_encode(
        array(
          'success' => false,
          'message' => $message_trim,
          'id' => $id,
          'reason' => $reason
        )
      );
    }
  }

  public function getPendingReports()
  {
    return DB::select(
      'SELECT "U1"."username" as "reported_by_username", "Report"."user_id" as "reported_by_id", "UI1"."path" as "reported_by_user_path", "U1"."trust_level" as "reported_by_trust_level",
              "U2"."username" as "reported_username", "Content"."user_id" as "reported_id",  "UI2"."path" as "reported_user_path", "U2"."trust_level" as "reported_trust_level",
        "Report"."id", "Report"."timestamp"::DATE, "Report"."status", "Report"."content_id", "Report"."question_id", "Report"."reason"
         FROM "Report", "User" as "U1", "UserImage" as "UI1", "User" as "U2", "UserImage" as "UI2", "Content"
         WHERE "Report"."user_id" = "U1"."id" and "U1"."profile_picture_id"="UI1"."id"
         and "Content"."user_id" ="U2"."id" and "U2"."profile_picture_id"="UI2"."id"
         and "Report"."user_id" != ? and "Content"."user_id" != ?
         and "Report"."content_id"="Content"."id" and "Report"."status"=?
         ORDER BY "Report"."timestamp" DESC;',
      [Auth::user()->id, Auth::user()->id, 'pending']
    );
  }

  public function reportContent(Request $request, $id_content)
  {

    try {
      $reason = $request->all()['message'];
      $id_question = $request->all()['id_question']; 
      $user_id = Auth::user()->id;
      Report::create([
        'user_id' => $user_id,
        'content_id' => $id_content,
        'question_id' => $id_question,
        'reason' => $reason
      ]);

      DB::commit();

      return json_encode(
        array(
          'success' => true,
          'message' => "Report made successfuly"
        )
      );
    } catch (QueryException $e) {
      DB::rollBack();
      return json_encode(
        array(
          'success' => false,
          'message' => $e->getMessage() . "\n" . $reason
        )
      );
    }
  }
}
