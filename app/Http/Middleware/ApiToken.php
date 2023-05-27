<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\GuardTour\Entities\api\AuthModels;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isEmpty;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $request->header('X-API-KEY');
        if ($request->header('X-API-KEY') != AuthModels::getToken($request->header('X-API-KEY'))) {
            return response()->json([
                "status" => false,
                "error" => "Invalid API key "
            ]);
        }

        return $next($request);
    }
}
