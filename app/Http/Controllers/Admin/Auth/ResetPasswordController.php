<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\AdminResetPassword;
use App\Models\User;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    // Reset Password Form
    public function resetPasswordForm()
    {
        return view('admin.auth.reset_email');
    }

    // Reset Password Notification
    public function resetPasswordNotification(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:dn_users',
        ]);

        $token = Str::random(64);
        $existingToken = DB::table('dn_password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if ($existingToken) {
            // Update the existing token
            DB::table('dn_password_reset_tokens')
                ->where('email', $request->email)
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        } else {
            // No existing token found, insert a new one
            DB::table('dn_password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $user->notify(new AdminResetPassword($token, $user));

        return back()->with('success', 'Password reset link sent to your email!');
    }

    // New Password Form
    public function newPasswordForm($token)
    {
        return view('admin.auth.reset_password', compact('token'));
    }

    // New Password
    public function newPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $token = DB::table('dn_password_reset_tokens')
            ->where('token', $request->token)->first();

        if (!empty($token)) {
            $user = User::where('email', $token->email)
                ->update(['password' => Hash::make($request->password)]);
            DB::table('dn_password_reset_tokens')->where(['email' => $token->email])->delete();
            return redirect()->route('admin_auth.show_login')->with('success', 'Your password has been changed!');
        } else {
            return back()->withInput()->with('error', 'Invalid token!');
        }
    }
}
