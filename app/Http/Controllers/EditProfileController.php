<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Mod;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\UserImage;


class EditProfileController extends Controller
{
    public $modModel;
    public $notificationModel;
    public $userModel;


    public function __construct()
    {
        $this->modModel = new Mod;
        $this->notificationModel = new Notification;
        $this->userModel = new User;
    }

    public function showEditProfilePage($id)
    {
        // This user does not exist
        if (User::find($id) === null) return redirect('404');

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
        $userModel = new User;

        if (Auth::check() === true) {

            $notificationsAux = Auth::user()->notification->sortByDesc("timestamp");
            $notifications = array();
            foreach ($notificationsAux as $notification) {
                $type = $notificationModel->getTypeNotification($notification);
                $types = array_merge(array($notification), array($type));
                $notifications = array_merge($notifications, array($types));
            }
        } else  $notifications = -1;

        $user = $userModel->getEditMyProfileInfo($id)[0];

        $userLoggedIn = null;
        if (Auth::check() === true)
            $userLoggedIn = Auth::user()->username;

        return view('pages.user_edit', ['loggedIn' => $loggedIn, 'mod' => $mod, 'notifications' => $notifications, 'admin' => $admin, 'userLoggedIn' => $userLoggedIn, 'user' => $user, 'idAuthUser' => $id_auth_user, 'id' => $id]);
    }

    public function editMyProfileInfo(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        

        $valid = true;
        $password_exists = false;
        $failure_message = "";

        $current_password = $request->input('current_password');
        $new_password = $request->input('new_password');
        $confirm_password = $request->input('confirm_password');

    
        if ($current_password != "" && $new_password != "" && $confirm_password != "") {
            $password_exists = true;


            if(!Hash::check($current_password, $user->password)) {
                $valid = false;
                $failure_message = "Inserted password and current user password do not match.";
            }
            else if($new_password != $confirm_password)
            {
                $valid = false;
                $failure_message = "New password and Confirm password do not match.";
            }
        }

        if ($valid) // if validation hasn't failed (because of the password match), validate inserted data
        {
            $validator = validator($data);
            $valid = !$validator->fails();
            if(!$valid)
                $failure_message = "Inserted data is invalid.";
        }

        if($valid) // if validation hasn't failed (because of the data validation), check profile_image existance and extension
        {
            if ($request->has('user_path')) {
                // Get image file
                $image_ext = $request->file('user_path')->getClientOriginalExtension();

                print_r($image_ext);
                if(!($image_ext === "png" || $image_ext === "jpg" || $image_ext === "gif")){
                    $valid = false;
                    $failure_message = "Invalid image extension uploaded.";
                }
                    
            } 
        }

        if ($valid) // if valid, udpdate
        {
            DB::transaction(function () use (&$request, $id, $password_exists, $new_password) {

                DB::table('User')->where('id', '=', $id)->update([
                    'username' => $request->input('username'),
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'country' => $request->input('country'),
                    'bio' => $request->input('bio'),
                    'birthday' => $request->input('birthday')
                ]);

                if ($password_exists)
                    DB::table('User')->where('id', '=', $id)->update(['password' => bcrypt($new_password)]);

                if ($request->has('user_path')) {
                    // Get image file
                    $image = $request->file('user_path');

                    $originalFileName = 'raw_'.$id.'_'.time(). '.' . $image->getClientOriginalExtension();
                    $fileName = $id.'_'.time(). '.' . $image->getClientOriginalExtension();
                    
                    $image->move(public_path('images'), $originalFileName);
                    //move_uploaded_file($image, $originalFileName);

                    print_r("\n*\n*\n");
                    print_r(public_path('images'));

                    $original = null;
                    if($image->getClientOriginalExtension() === "jpeg" || $image->getClientOriginalExtension() === "jpg")
                        $original = imagecreatefromjpeg(public_path('images').'/'.$originalFileName);
                    else if($image->getClientOriginalExtension() === "png")
                        $original = imagecreatefrompng(public_path('images').'/'.$originalFileName);
                    else
                        $original = imagecreatefromgif(public_path('images').'/'.$originalFileName);

                    // Make a file path where image will be stored [ folder path + file name + file extension]
                    $filePath = 'images/' . $fileName;


                    $width = imagesx($original);     // width of the original image
                    $height = imagesy($original);    // height of the original image
                    $square = min($width, $height);  // size length of the maximum square

                    // Create and save a small square thumbnail
                    $squaredImage = imagecreatetruecolor(400, 400);
                    imagecopyresized($squaredImage, $original, 0, 0, ($width>$square)?($width-$square)/2:0, ($height>$square)?($height-$square)/2:0, 400, 400, $square, $square);
                    //imagejpeg($squaredImage, $squareFileName);
                    
                    // Upload image
                    //$file = $image->storeAs('images/', $fileName, 'public');
                    imagejpeg($squaredImage, public_path('images').'/'.$fileName);
                    //$squaredImage->move(public_path('images'), $fileName);
                    
                    // Set user profile image path in database to filePath
                    $userImage = UserImage::create(['path' => $filePath]);
                    DB::table('User')->where('id', '=', $id)->update(['profile_picture_id' => $userImage->id]);                
                }    
                
            });

            return redirect('user/' . $id . '/edit')->with('success', 'Your profile was successfully edited!');
        } 
        else // else, error
        {
            return redirect('user/' . $id . '/edit')->with('failure', 'Profile edit failed: ' . $failure_message);
        }
    }

    public function deleteMyAccount(Request $request, $id)
    {
        $userModel = new User;

        User::find($id);
        $num = $id;
        while ($userModel->userExists($num) != 0)
            $num = $num + 1;

        $userModel->deleteMyAccount($request, $id);

        Auth::logout();

        return redirect('login')->with('success', 'Your account was deleted successfully from our database!');
    }

    public function resetPicture(Request $request, $id)
    {
        try{
            DB::table('User')->where('id', '=', $id)->update(['profile_picture_id' => 1]);
            DB::commit();
            return json_encode(
                array(
                    "sucess" => true,
                    "message" => "Successfully reseted profile picture!"
                )
            );
        } catch(QueryException $e){
            DB::rollBack();
            return json_encode(
                array(
                    "sucess" => false,
                    "message" => "Profile picture reset failed."
                )
            );
        }
        
    }


    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:User',
            'email' => 'required|string|email|max:255|unique:User',
            'password' => 'sometimes|string|min:6|confirmed',
            'password_confirmation' => 'sometimes|string|min:6|confirmed',
            'country' => 'required|string',
            'birthday' => 'required|date|before:today',
        ]);
    }

    public function applyForMod($id)
    {
        $modModel = new Mod;
        $apply = $modModel->applyForMod($id);

        return redirect('user/' . $id . '/edit')->with($apply[0], $apply[1]);
    }
}
