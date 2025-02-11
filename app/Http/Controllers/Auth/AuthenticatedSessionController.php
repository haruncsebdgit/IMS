<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AccessLog;
use App\Models\Settings\Organogram;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
        /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Login username to be used by the controller.
     *
     * @var string
     */
    protected $username;
    protected $accessLog;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AccessLog $accessLog)
    {
        $this->redirectTo = config('app.locale') .'/admin/dashboard';
        //$this->middleware('guest')->except('logout');
        $this->accessLog = $accessLog;
    }
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request, AccessLog $accessLog)
    {
        return $this->checkAuthentication($request, $accessLog);

    }

    public function checkAuthentication(LoginRequest $request, AccessLog $accessLog)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $accessLog->saveAccesslog();

        return redirect()->intended($this->redirectTo);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        (new AccessLog())->updateAccesslog();
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


}
