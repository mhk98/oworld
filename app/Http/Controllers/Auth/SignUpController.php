<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Notifications\EmailVerificationNotification;
use App\Rules\PhoneValidation;
use App\Models\UserVerify;
use Notification;

class SignUpController extends Controller
{

    /**
     * Check the availability of an email address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmailAvailability(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user) {
            return 'not_available';
        }
        return 'available';
    }

    /**
     * Check the availability of a phone number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPhoneAvailability(Request $request)
    {
        $phone = $request->phone;
        $user = User::where('phone', $phone)->first();
        if ($user) {
            return 'not_available';
        }
        return 'available';
    }

    // SignUp Form
    public function signUpForm()
    {
        $categoriesOrder = [
            'Food',
            'Fashion',
            'Beauty',
            'Home & Living',
            'Travel',
            'Events & Entertainment',
            'Tech & Electronics',
            'Health & Wellness',
            'Groceries',
            'Education & Work',
            'Business services',
            'Automotive',
            'Social services'
        ];

        $categories = Category::whereIn('title', $categoriesOrder)
            ->where('status', 'active')
            ->orderByRaw('FIELD(title, "' . implode('","', $categoriesOrder) . '")')
            ->get();

        return view('auth.signup', compact('categories'));
    }

    // SignUp User
    public function signUpUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:dn_users',
            'phone' => ['required', 'string', new PhoneValidation, 'unique:dn_users'],
            'password' => 'required|string|min:8|confirmed',
            'birth_day' => 'required|numeric',
            'birth_month' => 'required|numeric',
            'birth_year' => 'required|numeric',
            'accept_terms_and_conditions' => 'required'
        ], [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'phone.required' => 'Please enter your phone number.',
            'phone.unique' => 'This phone number is already registered.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'birth_day.required' => 'Please enter your birth day.',
            'birth_day.numeric' => 'Birth day must be a number.',
            'birth_month.required' => 'Please enter your birth month.',
            'birth_month.numeric' => 'Birth month must be a number.',
            'birth_year.required' => 'Please enter your birth year.',
            'birth_year.numeric' => 'Birth year must be a number.'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'birth_day' => $request->birth_day,
            'birth_month' => $request->birth_month,
            'birth_year' => $request->birth_year,
            'gender' => $request->gender,
            'is_merchant' => false,
            'is_admin' => false,
            'status' => 'active'
        ]);


        // Email Verification Notification
        $token = Str::random(64);
        $verification = UserVerify::updateOrCreate(
            ['user_id' => $user->id],
            ['token' => $token]
        );
        Notification::route('mail', $user->email)->notify(new EmailVerificationNotification($token));


        // Auto Login
        Auth::login($user);

        return redirect()->route('index')->with('info', 'Check your email, we have sent a verification link.');
    }

    // SignUp Merchant
    public function signUpMerchant(Request $request)
    {
        $request->validate([
            'merchant_first_name' => 'required|string',
            'merchant_last_name' => 'required|string',
            'merchant_email' => 'required|email|unique:dn_users,email',
            'merchant_phone' => ['required', 'string', new PhoneValidation, 'unique:dn_users,phone'],
            'merchant_birth_day' => 'required|numeric',
            'merchant_birth_month' => 'required|numeric',
            'merchant_birth_year' => 'required|numeric',
            'merchant_password' => 'required|string|min:8|same:merchant_password_confirmation',
            'business_type' => 'required|string',
            'business_name' => 'required|string',
            'category_id' => 'required',
            'address' => 'required',
            'area' => 'required',
            'accept_terms_and_conditions' => 'required'
        ], [
            'merchant_first_name.required' => 'The first name field is required.',
            'merchant_last_name.required' => 'The last name field is required.',
            'merchant_email.required' => 'The email field is required.',
            'merchant_email.email' => 'Please enter a valid email address.',
            'merchant_email.unique' => 'This email address is already in use.',
            'merchant_phone.required' => 'The phone number field is required.',
            'merchant_phone.unique' => 'This phone number is already in use.',
            'merchant_birth_day.required' => 'The birth day field is required.',
            'merchant_birth_month.required' => 'The birth month field is required.',
            'merchant_birth_year.required' => 'The birth year field is required.',
            'merchant_password.required' => 'The password field is required.',
            'merchant_password.min' => 'Password must be at least 8 characters long.',
            'merchant_password.same' => 'The password and confirmation must match.',
            'business_type.required' => 'The business type field is required.',
            'business_name.required' => 'The business name field is required.',
           'category_id.required' => 'The category field is required.',
            'address.required' => 'The address field is required.',
            'area.required' => 'The area field is required.',
            'accept_terms_and_conditions.required' => 'You must accept the terms and conditions.'
        ]);

        $merchant = User::create([
            'first_name' => $request->merchant_first_name,
            'last_name' => $request->merchant_last_name,
            'email' => $request->merchant_email,
            'phone' => $request->merchant_phone,
            'password' => Hash::make($request->merchant_password),
            'birth_day' => $request->merchant_birth_day,
            'birth_month' => $request->merchant_birth_month,
            'birth_year' => $request->merchant_birth_year,
            'gender' => $request->merchant_gender,
            'is_merchant' => true,
            'is_admin' => false,
            'status' => 'active'
        ]);

        // Create Store for the Merchant
        $store = Store::create([
            'slug' => Str::slug($request->business_name) . '-' . mt_rand(10000000, 99999999),
            'business_name' => $request->business_name,
            'store_type' => $request->store_type,
            'business_type' => $request->business_type,
            'merchant_id' => $merchant->id,
            'email' => $request->merchant_email,
            'phone' => $request->merchant_phone,
            'facebook' => $request->facebook,
            'status' => 'pending'
        ]);

        // Store Category
       if ($request->has('category_id')) {
          $store->mainCategories()->attach($request->category_id);
       }

        if ($request->has('store_type') && in_array('physical', $request->store_type)) {
            // Store Areas
            if ($request->has('area')) {
                foreach ($request->area as $areaName) {
                    $store->areas()->create([
                        'area' => $areaName,
                        'address' => $request->input('address.' . $areaName)
                    ]);
                }
            }
        }


        if ($request->has('store_type') && in_array('online', $request->store_type)) {
            // Store Delivery Areas
            if ($request->has('delivery_area')) {
                foreach ($request->delivery_area as $deliveryAreaName) {
                    if ($deliveryAreaName != 'all') {
                        $store->deliveryAreas()->create([
                            'area' => $deliveryAreaName
                        ]);
                    }
                }
            }
        }

        // Auto Login
        Auth::login($merchant);
        Session::put('current_store', $store->id);

        return response()->json(['success' => true], 200);
    }
}
