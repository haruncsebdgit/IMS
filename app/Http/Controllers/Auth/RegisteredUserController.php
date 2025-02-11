<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en'  => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $users = DB::table('users')->get();

        Auth::login($user = User::create([
            'name_en' => $request->name_en,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]));

        if (null != $user) {
            if ($users->isEmpty()) {
                updateUserMeta($user->id, '_role', ['administrator']);
            } else {
                updateUserMeta($user->id, '_role', ['subscriber']);
            }
        }

        event(new Registered($user));

        return redirect(config('app.locale') . '/admin/dashboard');
    }
}
