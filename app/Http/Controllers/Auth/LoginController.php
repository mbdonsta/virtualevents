<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function getLogin(Request $request): View
    {
        $locale = $request->lang;

        if ($request->lang && in_array($request->lang, config('app.locales'))) {
            session('lang', $request->lang);
            App::setLocale($request->lang);
        }

        return view('auth.login');
    }

    public function postLogin(UserLoginRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        if (Auth::attempt($attributes)) {
            $request->session()->regenerate();

            if (Auth::user()->isDisabled()) {
                Auth::logout();

                return back()->withInput()
                    ->withErrors([
                        'invalid-login' => __('Your account has been suspended.')
                    ]);
            }

            if (Auth::user()->isParticipant()) {
                return redirect()->route('frontend.account.event_invitations');
            }

            return redirect()->route('backend.events.index');
        }

        return back()->withInput()
            ->withErrors([
                'invalid-login' => __('Your provided sign in credentials are invalid.')
            ]);
    }

    public function logout(): RedirectResponse
    {
        $redirect = auth()->user()->isParticipant() ? 'https://streamie.eu' : route('get_login');
        Auth::logout();

        return redirect($redirect);
    }
}
