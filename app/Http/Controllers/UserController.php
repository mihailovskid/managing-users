<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard');
    }

    public function activate($email, $code)
    {
        $user = User::where('email', $email)
            ->where('activation_code', $code)
            ->first();

        if ($user) {
            $user->is_active = 1;
            $user->activation_code = null;
            $user->save();

            if ($user->role_id == 1) {
                return redirect()->route('admin.dashboard')->with('success', 'Your account has been activated. You can now login.');
            } else {
                return redirect()->route('login')->with('success', 'Your account has been activated. You can now login.');
            }
        } else {
            abort(401);
        }
    }
}
