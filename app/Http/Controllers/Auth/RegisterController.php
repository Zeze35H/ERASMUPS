<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/questions';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:User',
            'email' => 'required|string|email|max:255|unique:User',
            'password' => 'required|string|min:6|confirmed',
            'country' => 'required|string',
            'birthday' => 'required|date|before:today',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if(!array_key_exists("in_out",$data)) {
            return User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'country' => $data['country'],
                'birthday' => $data['birthday'],
                'num_votes' => 0,
                'num_questions' => 0,
                'num_comments' => 0,
                'num_reports' => 0,
                'num_answers' => 0,
                'num_fav_answers' => 0,
            ]);
        }
        else {
            $in_out = $data["in_out"] === "in";

            return User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'country' => $data['country'],
                'birthday' => $data['birthday'],
                "erasmus_in_out" => $in_out,
                'num_votes' => 0,
                'num_questions' => 0,
                'num_comments' => 0,
                'num_reports' => 0,
                'num_answers' => 0,
                'num_fav_answers' => 0,
            ]);
        }
    }

    // NOTIFICATIONS
public function getTypeNotification($notification)
{
    if(AnswerNotification::find($notification->id))
        return array("Answer", 'question/' . Answer::find(AnswerNotification::find($notification->id)->answer_id)->question_id); 
    else if(CommentNotification::find($notification->id))
        return array("Comment", 'question/' . Answer::find(Comment::find(CommentNotification::find($notification->id)->comment_id)->answer_id)->question_id); 
    else if(FavAnswerNotification::find($notification->id))
        return array("Favourite Answer", 'question/' . Answer::find(FavAnswerNotification::find($notification->id)->answer_id)->question_id); 
    else if(BadgeNotification::find($notification->id))
        return array("Badge", 'user/' . Auth::user()->id); 
    else if(ReportNotification::find($notification->id))
        return array("Report", 'question/'); 
    else if(ModNotification::find($notification->id))
        return array("Mod", 'question/'); 
    else if(TagNotification::find($notification->id))
        return array("Tag", 'question/'); 
    else return 0;

}

public function getNotification() {

    if (Auth::check()) {
        $id_auth_user = Auth::user()->id;

        return DB::select('SELECT "text", date_trunc(\'second\', "timestamp") AS "timestamp"
        FROM "Notification" 
        WHERE "user_id" = ?
        ORDER BY "timestamp" DESC',
        [$id_auth_user]);
    }
    else {
        return -1;
    }
}
}
