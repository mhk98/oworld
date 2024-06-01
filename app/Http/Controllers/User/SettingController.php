<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\FileUpload;

class SettingController extends Controller
{
    public function settingForm()
    {
        $user = User::find(auth()->user()->id);
        return view('user.setting', compact('user'));
    }

    public function updateSetting(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $this->validate($request, [
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email|unique:dn_users,email,' . $user->id,
            'phone' => 'nullable|unique:dn_users,phone,' . $user->id
        ]);

        if ($request->hasFile('profile_picture')) {
            $profilePictureFile = FileUpload::uploadOriginalFile($request->file('profile_picture'));
            $user->profile_picture = $profilePictureFile;
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        $user->save();

        return redirect()->route('user.settingForm')->with('success', 'Settings updated successfully!');
    }
}
