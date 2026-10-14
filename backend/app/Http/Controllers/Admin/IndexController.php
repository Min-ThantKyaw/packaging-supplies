<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class IndexController extends Controller
{

    public function index(): View
    {
        return view('admin.index');
    }

    public function login(): View
    {
        return view('admin.login');
    }

}
