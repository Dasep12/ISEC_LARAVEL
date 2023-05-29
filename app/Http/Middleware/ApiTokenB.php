<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\GuardTour\Entities\api\AuthModels;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isEmpty;

class ApiTokenB
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $bearer =  $request->bearerToken();
        $token = "MZ3HPLlfEKRKhzmdUbqbuCZhI1POABxw4rFxO59GNdL7E1j";
        if ($bearer != $token) {
            return response()->json([
                "status" => false,
                "error" => "Invalid API key "
            ]);
        }

        return $next($request);
    }
}
