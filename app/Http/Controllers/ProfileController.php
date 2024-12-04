<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Mod;
use App\Models\Admin;
use App\Models\FollowedTags;
use App\Models\Question;
use App\Models\Notification;
use App\Models\Tag;

class ProfileController extends Controller
{
    public $userModel;
    public $notificationModel;
    public $questionModel;
    public $tagsModel;

    public function __construct()
    {
        $this->userModel = new User;
        $this->notificationModel = new Notification;
        $this->questionModel = new Question;
        $this->tagsModel = new Tag;
    }
    public function showProfilePage($id)
    {
        // This user does not exist
        if (User::find($id) === null) return redirect('404');

        $loggedIn = Auth::check();
        $userquestions = [];
        $mod = false;
        $admin = false;
        $id_auth_user = null;
        if ($loggedIn === true) {
            $mod = Mod::find(Auth::user()->id) !== null;
            $admin = Admin::find(Auth::user()->id) !== null;
            $id_auth_user = Auth::user()->id;
        }

        $userModel = new User;
        $notificationModel = new Notification;
        $questionModel = new Question;

        if (Auth::check() === true) {

            $notificationsAux = Auth::user()->notification->sortByDesc("timestamp");
            $notifications = array();
            foreach ($notificationsAux as $notification) {
                $type = $notificationModel->getTypeNotification($notification);
                $types = array_merge(array($notification), array($type));
                $notifications = array_merge($notifications, array($types));
            }
        } else  $notifications = -1;

        $user = $userModel->getMyProfileInfo($id)[0];
        //$userquestions = $userModel->getUserQuestions($id) ? $userModel->getUserQuestions($id)[0] : null;
        //$allquestions = $questionModel->getAllQuestions($id);

        $userquestions = $userModel->getUserQuestions($id);

        $question_titles = [];
        for($i = 0; $i < count($userquestions); $i++)
        {
            $question_title_chars = str_split(strtolower($userquestions[$i]->title));
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
        

        $userLoggedIn = null;
        if (Auth::check() === true)
            $userLoggedIn = Auth::user()->username;

        return view('pages.user', ['loggedIn' => $loggedIn, 'mod' => $mod, 'admin' => $admin, 'notifications' => $notifications, 'userLoggedIn' => $userLoggedIn, 'question_titles' => $question_titles, 'userquestions' => $userquestions, 'user' => $user, 'idAuthUser' => $id_auth_user]);
    }

    public function followedTags(Request $request, $user_id)
    {
        $tagsArray = explode(" ", $request->all()['tags']);
        $numTags = count($tagsArray);

        $tagsModel = new Tag;
        $tags = $tagsModel->followedTags($numTags, $tagsArray);

        return json_encode(array("tags" => $tags));
    }

    public function unFollowedTags(Request $request, $user_id)
    {
        $tag = $request->all()['tag'];

        $tagsModel = new Tag;
        $tagsModel->unFollowedTags($tag);

        return json_encode(array("tag" => $tag));
    }
}
