<?php

namespace App\Http\Controllers;

use AuthHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('log')->only('index');
        // $this->middleware('subscribed')->except('store');
        $this->middleware('is_login_isec');
    }

    public function index(): View
    {
        AuthHelper::checksession(session()->all());
        
        $data = [
            'contents' => 'default',
            'link' => '',
        ];
        
        return view('template/template_first', $data);
    }
}
