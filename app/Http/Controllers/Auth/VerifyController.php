<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use App\Notifications\EmailVerificationNotification;
use Notification;

class VerifyController extends Controller
{
    /**
     * Verify the user's account based on the token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyAccount($token)
    {
        $verification = UserVerify::where('token', $token)->first();
        if (!$verification) {
            return redirect()->route('index')->with('message', 'Sorry, we couldn\'t verify your email. Please try again or contact support.');
        }

        $user = $verification->user;
        if (empty($user->email_verified_at)) {
            $user->update(['email_verified_at' => now()]);
            if ($user->is_merchant) {
                return redirect()->route('index')->with('success', 'Your email has been verified successfully.');
            }
            return redirect()->route('index')->with('success', 'Your email has been verified successfully.');
        } else {
            if ($user->is_merchant) {
                return redirect()->route('index')->with('success', 'Your email is already verified.');
            }
            return redirect()->route('index')->with('success', 'Your email is already verified.');
        }
    }

    /**
     * Resend email verification link.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerificationEmail()
    {
        $user = auth()->user();
        if (!empty($user->email_verified_at)) {
            return redirect()->route('user.settingForm')->with('success', 'Your email is already verified.');
        }

        $token = Str::random(64);
        $verification = UserVerify::updateOrCreate(
            ['user_id' => $user->id],
            ['token' => $token]
        );
        Notification::route('mail', $user->email)->notify(new EmailVerificationNotification($token));

        return redirect()->route('user.settingForm')->with('success', 'A new verification link has been sent to your email.');
    }
}
