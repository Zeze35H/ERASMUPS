<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


use App\Models\Comment;

class CommentController extends Controller
{
    public function addComment($id_answer, Request $request)
    {
        $data = $request->all();

        $var = array_keys($data)[1];

        $this->commentValidator($data, $var)->validate();

        $id_question = $request->all()['id_question'];

        $commentModel = new Comment;
        $commentModel->addComment($id_question, $id_answer, $request);

        $title = DB::table('Question')->where('id', '=', $id_question)->first('title')->title;
        
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

        return redirect('question/' . $id_question .'/'. $question_title)->with('success', 'Your comment was added sucessfully to our database!');
    }

    public function editComment(Request $request, $id_comment)
    {
        $data = $request->all();
        $body = $data['text'];

        $commentModel = new Comment;

        if ($commentModel->commentExists($id_comment, $body))
            return json_encode(array_merge(array($commentModel->getComment($id_comment)[0]), array("edited" => false)));

        $commentModel->editComment($id_comment, $body);
        return json_encode(array_merge(array($commentModel->getComment($id_comment)[0]), array("edited" => true)));
    }

    public function removeComment(Request $request, $id_comment)
    {
        $commentModel = new Comment;
        return $commentModel->removeComment($request, $id_comment);
    }

    public function voteComments(Request $request, $id_comment)
    {
        $user_id = Auth::user()->id;

        $commentModel = new Comment;
        $commentModel->voteComments($request, $id_comment);
        $comment = $commentModel->getComment($id_comment)[0];

        return json_encode(
            array(
                'id_comment' => $id_comment,
                'user_id' => $user_id,
                'value' => $comment->votes,
                'score' => $comment->score
            )
        );
    }

    public function removeCommentsVote(Request $request, $id_comment)
    {
        $user_id = Auth::user()->id;

        $commentModel = new Comment;
        $commentModel->removeCommentsVote($request, $id_comment);
        $comment = $commentModel->getComment($id_comment)[0];

        return json_encode(
            array(
                'id_comment' => $id_comment,
                'user_id' => $user_id,
                'value' => $comment->votes,
                'score' => $comment->score
            )
        );
    }

    public function commentValidator(array $data, $var)
    {
        return Validator::make($data, [
            $var => 'required|string',
        ]);
    }
}
