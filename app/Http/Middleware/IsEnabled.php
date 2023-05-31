<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->enabled) {
            session()->flash('error', __('Your account has been suspended.'));
            auth()->logout();

            return redirect()->route('auth.get_login');
        }

        return $next($request);
    }
}
