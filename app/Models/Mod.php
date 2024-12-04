<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class Mod extends Model
{
    use HasFactory;

    protected $table = 'Mod';

    public $timestamps  = false;

    public function getModApplications()
    {
        return DB::select(
            'SELECT "ModApplication"."id" AS "idMod","ModApplication"."id",  "User"."username" AS "username", "UserImage"."path" AS "user_path",
        "User"."trust_level" AS "trust_level", "User"."country" AS "country"
        FROM "ModApplication", "User", "UserImage"
        WHERE "ModApplication"."user_id" = "User"."id"
        AND "ModApplication"."status" = ?
        AND "UserImage"."id" = "User"."profile_picture_id"
        AND "User"."deleted" = false
        ORDER BY "User"."trust_level" DESC, "ModApplication"."timestamp" DESC;',
            ['pending']
        );
    }

    public function searchAppeals(Request $request)
    {
        $data = $request->all();
        $input = $data['input'];

        return DB::select(
            'SELECT "User"."username" AS "username", "User"."id" AS "idUser", "ModApplication"."id" AS "idMod", "UserImage"."path" AS "user_path",
            "User"."trust_level" AS "trust_level", "User"."country" AS "country"
            FROM "ModApplication", "User", "UserImage"
            WHERE "ModApplication"."user_id" = "User"."id"
            AND "ModApplication"."status" = ?
            AND "UserImage"."id" = "User"."profile_picture_id"
            AND "User"."deleted" = false
            AND "User"."username" = ?',
            ['pending', $input]
        );
    }

    public function getAllMods()
    {
        return DB::select('SELECT "User"."id", "User"."username" AS "username", "UserImage"."path" AS "user_path",
        "User"."trust_level" AS "trust_level", "Mod"."num_interactions" AS "num_interactions"
        FROM "User", "Mod", "UserImage"
        WHERE "Mod"."id" = "User"."id" AND "Mod"."id" != (SELECT "id" FROM "Admin")
        AND "UserImage"."id" = "User"."profile_picture_id"
        AND "User"."deleted" = false
        ORDER BY "Mod"."num_interactions" DESC;');
    }

    public function getMods(Request $request)
    {
        $data = $request->all();
        $input = $data['input'];

        return DB::select('SELECT "User"."id", "User"."username" AS "username", "UserImage"."path" AS "user_path",
        "User"."trust_level" AS "trust_level", "Mod"."num_interactions" AS "num_interactions"
        FROM "User", "Mod", "UserImage"
        WHERE "Mod"."id" = "User"."id" AND "Mod"."id" != (SELECT "id" FROM "Admin")
        AND "UserImage"."id" = "User"."profile_picture_id"
        AND "User"."deleted" = false
        AND "User"."username" = ?',
        [$input]);
    }

    public function treatAppeal(Request $request, $id)
    {

        $action = $request->all()['action'];

        DB::beginTransaction();
        try {
            DB::table('ModApplication')->where('id', '=', $id)->update(['status' => $action]);
            DB::commit();

            $action_clean = "ERROR";
            if ($action == "accepted")
                $reason_clean = "Accepted.";
            else if ($action == "rejected")
                $reason_clean = "Rejected.";

            return json_encode(
                array(
                    'success' => true,
                    'message' => "Mod appeal handled with success! Action performed: " . $reason_clean,
                    'id' => $id,
                    'action' => $action
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
                    'message' => "Mod appeal handling failed. Error: " . $message_trim,
                    'id' => $id,
                    'action' => $action
                )
            );
        }
    }

    public function treatMod(Request $request, $id)
    {

        $action = $request->all()['action'];

        DB::beginTransaction();
        try {

            if ($action == "Demoted.")
                DB::table('Mod')->where('id', '=', $id)->delete();
            else if ($action == "Banned.") {
                $num = $id;
                while (count(DB::select('SELECT * FROM "User" WHERE "username" = ?', ['deleted' . $num])) != 0)
                    $num = $num + 1;

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
            }
            else if ($action == "Promoted.")
            {
                $user = DB::table('Mod')->insert(['id' => $id, 'num_interactions' => 0]);
            }

            DB::commit();

            return json_encode(
                array(
                    'success' => true,
                    'message' => "User/Mod handled with success! Action performed: " . $action,
                    'id' => $id,
                    'action' => $action
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
                    'message' => "User/Mod handling failed. Error: " . $message_trim,
                    'id' => $id,
                    'action' => $action
                )
            );
        }
    }


    public function applyForMod($id)
    {
        try {

            DB::insert('insert into "ModApplication"("user_id") values(?)', [$id]);
            DB::commit();

            return array('success', 'Successfuly applied for mod!');
        } catch (QueryException $e) {
            DB::rollBack();
            $message = $e->getMessage();
            $temp = explode("CONTEXT:", $message)[0];
            $message_trim = explode(":", $temp)[3];
            return array('failure', $message_trim);
        };
    }
}
