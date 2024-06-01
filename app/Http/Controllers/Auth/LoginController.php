<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display the login form.
     *
     * @return \Illuminate\View\View
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle the login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'identifier' => 'required',
            'password' => 'required',
        ]);

        $identifier = $request->identifier;
        $user = User::where('email', $identifier)->orWhere('phone', $identifier)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            auth()->login($user);
            
            if ($user->is_merchant) {
                $store = auth()->user()->stores()->first();
                if ($store) {
                    Session::put('current_store', $store->id);
                    if(!$store->is_setup_complete){
                        return redirect()->route('merchant.welcome');
                    }
                    return redirect()->route('store', $store->slug);
                } else {
                    //return redirect()->route('merchant.addStoreForm');
                    //->with('success', 'Welcome to O\'World');
                }
            }

            return redirect()->route('index')->with('success', 'Welcome to O\'World');
        }

        // Authentication failed
        return redirect()->back()->withInput($request->only('identifier'))->withErrors([
            'identifier' => 'Invalid email or phone number or password',
        ]);
    }

    /**
     * Handle the logout request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/');
    }
}
