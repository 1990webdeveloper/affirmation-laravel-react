<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\ValidateOldPassword;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user && $user->is_admin == 1 && auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard')->with('success', 'Login successfully!');
        }
        return redirect()->back()->with('error', 'Please check your email and password!');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function logout()
    {
        auth()->logout();
        session()->flush();
        return redirect()->route('login')->with('success', 'Logout successfully!');
    }
    public function changePassword()
    {
        $user = auth()->user();
        return view('auth.change-password',compact('user'));
    }

    public function submitChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', new ValidateOldPassword()],
            'new_password' => ['required', 'string', 'min:6'],
            'confirm_password' => ['same:new_password'],
        ]);
        $userInfo = User::findOrFail(auth()->user()->id);
        $status = $userInfo->update(['password' => Hash::make($request->new_password)]);

        auth()->logout();

        return redirect()->route('login')->with('success', 'Your password reset successfully!');
    }
}
