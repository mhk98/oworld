<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\ForgotPassword;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
      // Forgot Password Form
      public function forgotPasswordForm()
      {
          return view('auth.forgot_password');
      }
  
      // Forgot Password Notification
      public function forgotPasswordNotification(Request $request)
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
          $user->notify(new ForgotPassword($token, $user));
  
          return back()->with('success', 'Password reset link sent to your email!');
      }
  
      // Reset Password Form
      public function resetPasswordForm($token)
      {
          return view('auth.reset_password', compact('token'));
      }
  
      // Reset Password
      public function resetPassword(Request $request)
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
              return redirect()->route('auth.loginForm')->with('success', 'Your password has been changed!');
          } else {
              return back()->withInput()->with('error', 'Invalid token!');
          }
      }
}
