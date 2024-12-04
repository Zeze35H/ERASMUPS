<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\Mod;
use App\Models\Notification;


class ErrorController extends Controller
{
    public function show404Page()
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

        return view('errors.404', ['loggedIn' => $loggedIn, 'notifications' => $notifications, 'mod' => $mod, 'admin' => $admin, 'idAuthUser' => $id_auth_user]);
    }

    public function show403Page()
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

        return view('errors.403', ['loggedIn' => $loggedIn, 'notifications' => $notifications, 'mod' => $mod, 'admin' => $admin, 'idAuthUser' => $id_auth_user]);
    }
}
