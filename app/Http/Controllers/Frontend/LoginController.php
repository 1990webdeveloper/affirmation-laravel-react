<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordEmail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    public function loginSubmit(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|exists:users,email',
            'password' => ['required', 'string'],
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user->status == 1 && auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            session()->flash('success', 'Login successfully');
            return to_route('home');
        }
        session()->flash('error', 'Please check your email and password!');
        return back();
    }

    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    public function registerSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email:rfc,dns', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'confirm_password' => ['same:password']
        ]);
        $user = User::create([
            'name' => $request->name, 'email' => $request->email,
            'password' => Hash::make($request->password), 'status' => '1'
        ]);
        if ($user && auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $email = $request->email;
            Mail::to($email)->send(new WelcomeEmail($email));
            session()->flash('success', 'Register successfully');
            return redirect('/');
        }
        session()->flash('error', 'Something went wrong !');
        return back();
    }

    public function logout()
    {
        auth()->logout();
        session()->flush();
        session()->flash('success', 'Logout successfully !');
        return redirect()->route('customer.login');
    }

    /**
     * Show the forgot password screen.
     */
    public function forgotPassword()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email:rfc,dns|exists:users,email',
        ], [
            'email.exists' => 'The email could not found in our system. Please check your email address and try again.'
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::to($request->email)->send(new ForgotPasswordEmail($token));
        session()->flash('success', 'We have sent reset password link, please check you email !');
        return back();
    }

    /**
     * Show the password reset screen.
     * @param  string  $token
     */
    public function resetPassword($token)
    {
        $reset = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$reset) {
            abort(404);
        }

        return Inertia::render('Auth/ResetPassword', ['token' => $token]);
    }
    /**
     * Handle a password reset request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where(['token' => $request->token])
            ->first();

        if (!$updatePassword) {
            return back();
        }

        User::where('email', $updatePassword->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where(['email' => $updatePassword->email])->delete();
        session()->flash('success', 'Your password is reset successfully');
        return redirect('/login');
    }
}
