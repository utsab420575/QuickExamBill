<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    public function UserDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        $notification=array(
            "message"=>'Profile Logout Sucessfully',
            "alert-type"=>'info');
        return redirect()->route('login')->with($notification);
    }

    public function UserProfile(){
        $user = auth()->user();

        return view('user_profile.user_profile_view',compact('user'));

       /* if ($user->hasRole('teacher')) {
            return view('profile.teacher', compact('user'));
        } elseif ($user->hasRole('staff')) {
            return view('profile.staff', compact('user'));
        } else {
            return view('profile.basic', compact('user')); // Only email/phone
        }*/
    }
    public function UserProfileStore(Request $request)
    {
        Log::info('UserProfileStore called', ['user_id' => auth()->id()]);

        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'phone' => [
                'required',
                'regex:/^(\+8801|8801|01)[0-9]{9}$/',
                Rule::unique('users', 'phone')->ignore(auth()->id()),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(auth()->id()),
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Log::info('Validation passed', $request->only('name', 'phone', 'email'));

        $user = auth()->user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;



        if ($request->file('photo')) {
            $recive_image = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $recive_image->getClientOriginalExtension();

            $manager = new ImageManager(new Driver());
            $image = $manager->read($recive_image);
            $image->resize(300, 300);

            $path = public_path('upload/user_image/');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $image->toJpeg()->save($path . $name_gen);

            $save_url = 'upload/user_image/' . $name_gen; // ✅ fixed path
            $user->photo = $save_url;
        }

        $user->save();
        Log::info('User profile updated successfully', ['user_id' => $user->id]);

        return redirect()->route('dashboard');
    }
    public function UserPasswordChange(){
        return view('user_profile.change_password');
    }//End Method

    public function UserPasswordUpdate(Request $request){
        /// Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',

        ]);

        /// Match The Old Password
        if (!Hash::check($request->old_password, Auth::user()->password)) {

           /* $notification = array(
                'message' => 'Old Password Dones not Match!!',
                'alert-type' => 'error'
            );
            return back()->with($notification);*/
            return redirect()->back()->with('error', 'Old Password Not Match');

        }

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();


       /* $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );*/

        //return back()->with($notification);
        return redirect()->route('dashboard');

    }//End Method





}
