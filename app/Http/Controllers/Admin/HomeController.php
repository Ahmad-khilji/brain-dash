<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.index');
    }




    public function change()
    {
        return view('admin.pages.user.index');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => ['nullable', 'email', 'unique:users,email,' . Auth::id()],
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Current password is incorrect'], 422);
        }
        $updateData = ['password' => Hash::make($request->new_password)];

        if (!empty($request->email)) {
            $updateData['email'] = $request->email;
        }

        $user->update($updateData);

        return response()->json(['status' => true, 'message' => 'Profile updated successfully']);
    }
}
