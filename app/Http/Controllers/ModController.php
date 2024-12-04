<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Mod;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\Report;

class ModController extends Controller
{
    public $modModel;
    public $notificationModel;
    public $reportModel;


    public function __construct()
    {
        $this->modModel = new Mod;
        $this->notificationModel = new Notification;
        $this->reportModel = new Report;
    }

    public function showModAppeals()
    {
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
        $modModel = new Mod;

        if (Auth::check() === true) {

            $notificationsAux = Auth::user()->notification->sortByDesc("timestamp");
            $notifications = array();
            foreach ($notificationsAux as $notification) {
                $type = $notificationModel->getTypeNotification($notification);
                $types = array_merge(array($notification), array($type));
                $notifications = array_merge($notifications, array($types));
            }
        } else  $notifications = -1;

        // only a mod or admin have permissions to access this page
        // if ($mod === false && $admin === false) return back();
        $this->authorize('showModAppeals', Mod::class);

        $modApplications = $modModel->getModApplications();
        // $searchMod = $this->searchMod($id)?$this->searchMod($id)[0]:null;
        // $allMods = $this->getAllMods();

        $userLoggedIn = null;
        if (Auth::check() === true)
            $userLoggedIn = Auth::user()->username;

        return view('pages.modAppeals', ['loggedIn' => $loggedIn, 'mod' => $mod, 'notifications' => $notifications, 'admin' => $admin, 'userLoggedIn' => $userLoggedIn, 'modApplications' => $modApplications, /*'searchMod' => $searchMod, 'allMods' => $allMods, 'user' => $user,*/ 'idAuthUser' => $id_auth_user]);
    }

    public function showModsDashboard()
    {
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
        $modModel = new Mod;

        if (Auth::check() === true) {

            $notificationsAux = Auth::user()->notification->sortByDesc("timestamp");
            $notifications = array();
            foreach ($notificationsAux as $notification) {
                $type = $notificationModel->getTypeNotification($notification);
                $types = array_merge(array($notification), array($type));
                $notifications = array_merge($notifications, array($types));
            }
        } else  $notifications = -1;

        // only an admin have permissions to access this page
        // if ($admin === false) return back();
        $this->authorize('showModsDashboard', Admin::class);

        //$modApplications = $this->getModApplications();
        // $searchMod = $this->searchMod($id)?$this->searchMod($id)[0]:null;
        $allMods = $modModel->getAllMods();

        $userLoggedIn = null;
        if (Auth::check() === true)
            $userLoggedIn = Auth::user()->username;

        return view('pages.modDash', ['loggedIn' => $loggedIn, 'notifications' => $notifications, 'mod' => $mod, 'admin' => $admin, 'userLoggedIn' => $userLoggedIn, 'allMods' => $allMods, 'idAuthUser' => $id_auth_user]);
    }

    public function showReports()
    {
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
        $reportModel = new Report;

        if (Auth::check() === true) {

            $notificationsAux = Auth::user()->notification->sortByDesc("timestamp");
            $notifications = array();
            foreach ($notificationsAux as $notification) {
                $type = $notificationModel->getTypeNotification($notification);
                $types = array_merge(array($notification), array($type));
                $notifications = array_merge($notifications, array($types));
            }
        } else  $notifications = -1;

        // only a mod or admin have permissions to access this page
        //if ($mod === false && $admin === false) return back();
        $this->authorize('showReports', Mod::class);

        $reports = $reportModel->getPendingReports();
        // $searchMod = $this->searchMod($id)?$this->searchMod($id)[0]:null;
        // $allMods = $this->getAllMods();

        $question_titles = [];
        for($i = 0; $i < count($reports); $i++)
        {
            $title = DB::table('Question')->where('id', '=', $reports[$i]->question_id)->first('title')->title;
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
            $question_titles[$i] = $question_title;
        }

        $userLoggedIn = null;
        if (Auth::check() === true)
            $userLoggedIn = Auth::user()->username;

        return view('pages.reports', ['loggedIn' => $loggedIn, 'notifications' => $notifications, 'mod' => $mod, 'admin' => $admin, 'userLoggedIn' => $userLoggedIn, 'reports' => $reports, 'idAuthUser' => $id_auth_user, 'question_titles' => $question_titles]);
    }

    public function searchAppeals(Request $request)
    {

        $modModel = new Mod;

        $data = $request->all();
        $input = $data['input'];
        if ($input != "") {
            $select =  $modModel->searchAppeals($request);
        } else {
            $select = $modModel->getModApplications();
        }

        return json_encode($select);
    }

    public function searchModsOrUsers(Request $request){

        $modModel = new Mod;
        $mods = true;

        $data = $request->all();
        $input = $data['input'];
        if ($input != "") {
            $select =  $modModel->getMods($request);
            if(count($select) == 0)
            {
                $userModel = new User;
                $select = $userModel->getUsers($request);
                $mods = false;
            }
        } else {
            $select = $modModel->getAllMods();
        }

        return json_encode(
            array(
                'select' => $select,
                'mods' => $mods
            )
        );
    }

    public function treatReport(Request $request, $id)
    {
        $reportModel = new Report;
        return $reportModel->treatReport($request, $id);
    }

    public function treatAppeal(Request $request, $id)
    {
        $modModel = new Mod;
        return $modModel->treatAppeal($request, $id);
    }

    public function treatMod(Request $request, $id)
    {
        $modModel = new Mod;
        return $modModel->treatMod($request, $id);
    }
}
