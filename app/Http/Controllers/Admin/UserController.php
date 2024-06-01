<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status
        ];
        
        $users = User::orderBy('id', 'desc')
            ->where(function ($query) use ($filters) {
                if ($filters['name']) {
                    $query->where(function ($subquery) use ($filters) {
                        $subquery->where('first_name', 'like', '%' . $filters['name'] . '%')
                            ->orWhere('last_name', 'like', '%' . $filters['name'] . '%');
                    });
                }
                if ($filters['email']) {
                    $query->where('email', '=', $filters['email']);
                }
                if ($filters['role'] && $filters['role'] != 'All') {
                    if ($filters['role'] == 'merchant') {
                        $query->where('is_merchant', '=', true);
                    }
                    if ($filters['role'] == 'admin') {
                        $query->where('is_admin', '=', true);
                    }
                    if ($filters['role'] == 'user') {
                        $query->where('is_admin', '!=', true)->where('is_merchant', '!=', true);
                    }
                }
                if ($filters['status'] && $filters['status'] != 'All') {
                    $query->where('status', '=', $filters['status']);
                }
            })->paginate(100);        

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:dn_users,email',
            'phone' => 'required|unique:dn_users,phone',
            'password' => 'required|confirmed|min:8',
            'birth_day' => 'required|numeric',
            'birth_month' => 'required|numeric',
            'birth_year' => 'required|numeric',
            'role' => 'required',
            'status' => 'required'
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
            'is_merchant' => $request->role == 'merchant' ? true : false,
            'business_type' => $request->role == 'merchant' ? $request->business_type : null,
            'is_admin' => $request->role == 'admin' ? true : false,
            'status' => $request->status
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:dn_users,email,' . $id,
            'phone' => 'required|unique:dn_users,phone,' . $id,
            'password' => 'nullable|confirmed|min:8',
            'birth_day' => 'required|numeric',
            'birth_month' => 'required|numeric',
            'birth_year' => 'required|numeric',
            'role' => 'required',
            'status' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'birth_day' => $request->birth_day,
            'birth_month' => $request->birth_month,
            'birth_year' => $request->birth_year,
            'is_merchant' => $request->role == 'merchant',
            'business_type' => $request->role == 'merchant' ? $request->business_type : null,
            'is_admin' => $request->role == 'admin',
            'status' => $request->status
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}
