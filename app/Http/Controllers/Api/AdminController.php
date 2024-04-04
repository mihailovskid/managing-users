<?php

namespace App\Http\Controllers\Api;

use App\Events\NewUserCreated;
use App\Http\Controllers\Controller;
use App\Mail\ActivationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;



class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function statusActivate(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->is_active = $request->status;
        $user->save();

        return response()->json(['success' => 'User status updated successfully']);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            $request->validate([
                'username'  => ['required', 'string', 'max:50'],
                'password'  => ['required'],
                'email'     => ['required', 'email']
            ]);

            $activationCode = Str::random(40);

            $user = User::create([
                'username'          => $request->input('username'),
                'password'          => Hash::make($request->input('password')),
                'email'             => $request->input('email'),
                'activation_code'   => $activationCode,
            ]);

            if ($user) {
                $activationLink = route('activate', ['email' => $user->email, 'code' => $activationCode]);

                Mail::to($user->email)->send(new ActivationEmail($activationLink));
                event(new NewUserCreated($user));

                return response(['success' => 'User successfully created! Activation email sent.'], 201);
            } else {
                Log::error('User creation failed');
                return response(['error' => 'Something went wrong!'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error in store method: ' . $e->getMessage());
            return response(['error' => 'Something went wrong!'], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'username'          => ['required', 'max:50'],
            'email'             => ['required', 'email'],
        ]);

        $params = [
            'username'             => $request->input('username'),
            'email'                => $request->input('email'),
        ];

        try {
            $updated = User::where('id', $request->input('user_id'))->update($params);

            if ($updated) {
                return response(['success' => 'User successfully updated!'], 200);
            } else {
                return response(['error' => 'Something went wrong during the update.'], 400);
            }
        } catch (\Exception $e) {
            return response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->input('user_id'));

        $removed = $user->delete();

        if ($removed) {
            return response(['success' => 'User successfully removed!'], 200);
        } else {
            return response(['error' => 'Something went wrong during the removal.'], 400);
        }
    }
}
