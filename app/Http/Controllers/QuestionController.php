<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\Report;
use App\Models\Admin;
use App\Models\Mod;
use App\Models\Notification;

class QuestionController extends Controller
{
    public $questionModel;
    public $answerModel;
    public $commentModel;
    public $reportModel;
    public $notificationModel;


    public function __construct()
    {
        $this->questionModel = new Question;
        $this->answerModel = new Answer;
        $this->commentModel = new Comment;
        $this->notificationModel = new Notification;
        $this->reportModel = new Report;
    }

    public function showQuestionPage($id)
    {
        // This question does not exist
        if (Question::find($id) === null) return redirect('404');

        $loggedIn = Auth::check();
        $mod = false;
        $admin = false;
        $id_auth_user = null;
        if ($loggedIn === true) {
            $mod = Mod::find(Auth::user()->id) !== null;
            $admin = Admin::find(Auth::user()->id) !== null;
            $id_auth_user = Auth::user()->id;
        }

        $questionModel = new Question;
        $answerModel = new Answer;
        $commentModel = new Comment;
        $notificationModel = new Notification;

        $question = $questionModel->getQuestion($id)[0];
        $answers = $answerModel->getQuestionAnswers($id);
        $comments = array();

        foreach ($answers as $answer) {
            $comment = $commentModel->getAnswerComments($answer->id);
            $comments = array_merge($comments, $comment);
        }

        $userLoggedIn = null;
        $hasReportedList = [];
        if (Auth::check() === true) {
            $userLoggedIn = Auth::user()->username;
            $aux = Auth::user()->hasReported;

            for ($i = 0; $i < count($aux); $i++) {
                array_push($hasReportedList, $aux[$i]['id']);
            }
        }

        if (Auth::check() === true) {

            $notificationsAux = Auth::user()->notification->sortByDesc("timestamp");
            $notifications = array();
            foreach ($notificationsAux as $notification) {
                $type = $notificationModel->getTypeNotification($notification);
                $types = array_merge(array($notification), array($type));
                $notifications = array_merge($notifications, array($types));
            }   
        } else  $notifications = -1;

        //$question_title = implode("_", explode(" ", strtolower($question->title)));

        return view('pages.question', ['loggedIn' => $loggedIn, 'mod' => $mod, 'admin' => $admin, 'userLoggedIn' => $userLoggedIn, 'question' => $question, 'answers' => $answers, 'comments' => $comments, 'idAuthUser' => $id_auth_user, 'id' => $id, 'notifications' => $notifications, 'hasReportedList' => $hasReportedList]);
    }

    // ----

    public function showAddQuestionPage()
    {
        $notificationModel = new Notification;

        if (Auth::check()) {
            $mod = Mod::find(Auth::user()->id) !== null;
            $admin = Admin::find(Auth::user()->id) !== null;
            $id_auth_user = Auth::user()->id;

            $notificationsAux = Auth::user()->notification->sortByDesc("timestamp");
            $notifications = array();
            foreach ($notificationsAux as $notification) {
                $type = $notificationModel->getTypeNotification($notification);
                $types = array_merge(array($notification), array($type));
                $notifications = array_merge($notifications, array($types));
            }


            return view('pages.addQuestion', ['loggedIn' => true, 'notifications' => $notifications, 'mod' => $mod, 'admin' => $admin, 'idAuthUser' => $id_auth_user]);
        } else return view('auth.login');
    }

    public function addQuestion(Request $request)
    {

        $tags = trim($request->all()["tags"]);
        $numTags = 0;
        $tags_array = array();
        if ($tags !== "") {
            $tags_array = explode(" ", $tags);
            $numTags = count($tags_array);
            $data = array_merge($request->all(), ["tagsArray" => $tags_array, "numTags" => $numTags]);
        } else
            $data = array_merge($request->all(), ["tagsArray" => array(), "numTags" => $numTags]);

        $this->questionValidator($data)->validate();

        $questionModel = new Question;
        $id = $questionModel->addQuestion($request, $data, $numTags, $tags_array);

        //$title_clean = implode("_", explode(" ", strtolower($data['title'])));

        $question_title_chars = str_split(strtolower($data['title']));
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

        return redirect('question/' . $id .'/'. $question_title)->with('success', 'Your question was added successfully to our database!');
    }

    public function editQuestion(Request $request, $id)
    {
        $questionModel = new Question;
        return $questionModel->editQuestion($request, $id);
    }

    public function removeQuestion(Request $request, $id)
    {
        $questionModel = new Question;
        $message = $questionModel->removeQuestion($request, $id);
        return redirect('questions')->with('success', $message);
    }

    public function voteQuestions(Request $request, $id_content)
    {
        $user_id = Auth::user()->id;

        $questionModel = new Question;
        $questionModel->voteQuestions($request, $id_content);

        $question = $questionModel->getQuestion($id_content)[0];

        return json_encode(
            array(
                'id' => $id_content,
                'user_id' => $user_id,
                'value' => $question->votes,
                'score' => $question->score
            )
        );
    }

    public function removeQuestionsVote(Request $request, $id_content)
    {
        $user_id = Auth::user()->id;

        $questionModel = new Question;
        $questionModel->removeQuestionsVote($request, $id_content);

        $question = $questionModel->getQuestion($id_content)[0];

        return json_encode(
            array(
                'id' => $id_content,
                'user_id' => $user_id,
                'value' => $question->votes,
                'score' => $question->score
            )
        );
    }

    public function close($id)
    {
        $questionModel = new Question;
        $questionModel->close($id);

        return json_encode(array());
    }

    public function questionValidator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'numTags' => 'integer|max:10',
            'image.*' => 'image|mimes:jpg,jpeg,png|max:5048',
            'tagsArray.*' => 'string|max:25|distinct',
        ]);
    }
}
