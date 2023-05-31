<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function homepage(): RedirectResponse
    {
        return redirect()->route('get_login');
    }
}
