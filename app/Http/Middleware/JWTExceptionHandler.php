<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTExceptionHandler
{
    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::getToken();
            if ($token && !JWTAuth::check($token))
            {
                throw new TokenInvalidException('Token is invalid :from JWTExceptionHandler');
            }
        }
        catch (TokenInvalidException $e)
        {
            return response()->json(['error' => 'Invalid token :from JWTExceptionHandler'], Response::HTTP_UNAUTHORIZED);
        }

    return $next($request);
    }
}
