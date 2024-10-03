<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Rules\ValidateOldPassword;

class ProfileController extends Controller
{
    public function index()
    {
        return Inertia::render('User/Profile', ['user' => auth()->user()]);
    }

    public function dashboard()
    {
        //
    }

    public function changePassword()
    {
        return Inertia::render('User/ChangePassword', ['user' => auth()->user()]);
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
        session()->flash('success', 'Your password is changed');
        return redirect('/');
    }
}
