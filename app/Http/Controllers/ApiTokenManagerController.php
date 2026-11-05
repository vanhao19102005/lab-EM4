<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ApiTokenManagerController extends Controller
{
    public function index(): View
    {
        return view('api.index');
    }
}
