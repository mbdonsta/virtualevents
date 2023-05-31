<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Role;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function getRegister(): View
    {
        return view('auth.register');
    }

    public function postRegister(UserRegisterRequest $request): RedirectResponse
    {
        $attributes = $request->validated();
        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['role_id'] = Role::EVENT_MANAGER_ROLE_ID;
        $user = (new UserService)->create($attributes);

        return redirect()->route('auth.register_success');
    }

    public function success(): View
    {
        return view('auth.register-success');
    }
}
