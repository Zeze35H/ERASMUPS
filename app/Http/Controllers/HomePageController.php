<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Models\Content;
use App\Models\Question;
use App\Models\Admin;
use App\Models\Mod;
use App\Models\Notification;


use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public $questionModel;
    public $notificationModel;

    public function __construct()
    {
        $this->questionModel = new Question;
        $this->notificationModel = new Notification;
    }

    public function home()
    {
        return redirect('aboutUs');
    }

    public function showAboutUsPage()
    {

        $id_auth_user = null;
        $loggedIn = Auth::check();
        $mod = false;
        $admin = false;
        $id_auth_user = null;
        if ($loggedIn === true) {
            $mod = Mod::find(Auth::user()->id) !== null;
            $admin = Admin::find(Auth::user()->id) !== null;
            $id_auth_user = Auth::user()->id;
        }

        $notificationModel = new Notification;

        if (Auth::check() === true) {

            $notificationsAux = Auth::user()->notification->sortByDesc("timestamp");
            $notifications = array();
            foreach ($notificationsAux as $notification) {
                $type = $notificationModel->getTypeNotification($notification);
                $types = array_merge(array($notification), array($type));
                $notifications = array_merge($notifications, array($types));
            }
        } else  $notifications = -1;

        return view('pages.aboutUs', ['loggedIn' => $loggedIn, 'notifications' => $notifications, 'mod' => $mod, 'admin' => $admin, 'idAuthUser' => $id_auth_user]);
    }

    public function showQuestionsPage()
    {

        $questionModel = new Question;
        $search = Request::get('search', '');
        $search_tag = Request::get('search_tag', '');
        $questions = [];
        if($search == "" && $search_tag == "")
            $questions = $questionModel->getQuestions();
        else if($search_tag != ""){
            $questionsTemp = $questionModel->searchQuestionsByTag($search_tag);
            //print("Questions: " + $questions + "\n\n");
            $i = 0;
            for ($x = 0; $x < count($questionsTemp); $x++){
                $tagsToBeFixed = explode(",\"tags\":\"",json_encode($questionsTemp[$x]));
                if(count($tagsToBeFixed) > 1){
                    $tagsFixed = explode("\"", $tagsToBeFixed[1])[0];
                    $words = explode(" ", $tagsFixed);
                    foreach($words as $word){
                        if(strtolower($word) == strtolower($search_tag)) {
                        $questions[$i] = $questionsTemp[$x];
                        $i++;
                        }
                    }
                }

            }
        }
        else {
            $words = explode(" ", $search);
            $processedSearch = count($words) === 1 ? $words[0] : implode(" | ", $words);
            //print_r($processedSearch);
            $questions = $questionModel->searchQuestions($processedSearch);
        }

        $question_titles = [];
        for($i = 0; $i < count($questions); $i++)
        {
            $question_title_chars = str_split(strtolower($questions[$i]->title));
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
            $question_titles[$i] = $question_title;
        }

        //$questions = $questionModel->getQuestions();
        $loggedIn = Auth::check();
        $mod = false;
        $admin = false;
        $id_auth_user = null;
        if ($loggedIn === true) {
            $mod = Mod::find(Auth::user()->id) !== null;
            $admin = Admin::find(Auth::user()->id) !== null;
            $id_auth_user = Auth::user()->id;
        }

        $notificationModel = new Notification;

        if (Auth::check() === true) {

            $notificationsAux = Auth::user()->notification->sortByDesc("timestamp");
            $notifications = array();
            foreach ($notificationsAux as $notification) {
                $type = $notificationModel->getTypeNotification($notification);
                $types = array_merge(array($notification), array($type));
                $notifications = array_merge($notifications, array($types));
            }
        } else  $notifications = -1;

        return view('pages.questions', ['questions' => $questions, 'question_titles' => $question_titles, 'loggedIn' => $loggedIn, 'notifications' => $notifications, 'mod' => $mod, 'admin' => $admin, 'idAuthUser' => $id_auth_user]);
    }

    public function searchQuestions($input)
    {
        $questionModel = new Question;

        if ($input != "") {
            $select = $questionModel->searchQuestions($input);
        } else {
            $select = $questionModel->getQuestions();
        }


        return $select;
    }

    public function applyForMod($id)
    {
        $modModel = new Mod;
        return $modModel->applyForMod($id);
    }
}
