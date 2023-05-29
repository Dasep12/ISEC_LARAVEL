<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthIsec
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(session("log_key") !== "isLoginIsec") {
            session()->flush();
            return redirect("/");
            // ->with(["error" => 'Sesi berakhir.']);
        }

        return $next($request);
    }
}
