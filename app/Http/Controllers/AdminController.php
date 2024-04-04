<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showIndexPage()
    {
        return view('admin/dashboard');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
            'message'   => 'List of all ussers'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/create');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = User::find($request->input('user_id'));

        return response()->json([
            'user' => $user,
            'message' => 'Single requested vehicle'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('admin/edit');
    }
}
