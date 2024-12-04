<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Answer;

class AnswerController extends Controller
{
    public function addAnswer(Request $request, $id)
    {
        $data = $request->all();

        $this->answerValidator($data)->validate();

        $answerModel = new Answer;
        $answerModel->addAnswer($request, $id);

        $title = DB::table('Question')->where('id', '=', $id)->first('title')->title;
        
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

        return redirect('question/' . $id .'/'. $question_title)->with('success', 'Your answer was added sucessfully to our database!');
    }

    public function editAnswer(Request $request, $id_answer)
    {
        $data = $request->all();
        $body = $data['text'];

        $answerModel = new Answer;

        if ($answerModel->answerExists($id_answer, $body))
            return json_encode(array_merge(array($answerModel->getAnswer($id_answer)[0]), array("edited" => false)));

        $answerModel->editAnswer($request, $id_answer);

        return json_encode(array_merge(array($answerModel->getAnswer($id_answer)[0]), array("edited" => true)));
    }

    public function removeAnswer(Request $request, $id_answer)
    {
        $answerModel = new Answer;
        return $answerModel->removeAnswer($request, $id_answer);
    }

    public function voteAnswers(Request $request, $id_answer)
    {
        $user_id = Auth::user()->id;

        $answerModel = new Answer;
        $answerModel->voteAnswers($request, $id_answer);

        $answer = $answerModel->getAnswer($id_answer)[0];

        return json_encode(
            array(
                'id_answer' => $id_answer,
                'user_id' => $user_id,
                'value' => $answer->votes,
                'score' => $answer->score
            )
        );
    }

    public function removeAnswersVote(Request $request, $id_answer)
    {
        $user_id = Auth::user()->id;

        $answerModel = new Answer;
        $answerModel->removeAnswersVote($request, $id_answer);

        $answer = $answerModel->getAnswer($id_answer)[0];

        return json_encode(
            array(
                'id_answer' => $id_answer,
                'user_id' => $user_id,
                'value' => $answer->votes,
                'score' => $answer->score
            )
        );
    }

    public function selectFavAnswer($id_answer)
    {
        Answer::where('id', $id_answer)->update(['selected' => true]);

        return json_encode(array('id' => $id_answer,));
    }

    public function removeFavAnswer($id_answer)
    {
        Answer::where('id', $id_answer)->update(['selected' => false]);

        return json_encode(array('id' => $id_answer,));
    }

    public function answerValidator(array $data)
    {
        return Validator::make($data, [
            'text_answer' => 'required|string',
        ]);
    }
}
