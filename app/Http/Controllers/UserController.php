<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function UserDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
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
}
