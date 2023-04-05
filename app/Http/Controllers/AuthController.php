<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

use App\Models\User;

class AuthController extends Controller
{
    public function index(): View
    {
        // $request->session()->flash('error', 'Password salah');

        return view('login');
    }

    public function check(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect("/")->with(["error" => $validator]);
        }

        // $request->session()->flash('error', 'Password salah');
        // var_dump($request->all());die();

        return redirect('/dashboard');
    }
}
