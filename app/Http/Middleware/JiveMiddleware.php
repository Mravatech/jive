<?php
namespace App\Http\Middleware;


use Closure;
use Exception;
use App\Models\Users;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;


class JiveMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('Authorization');
        
        if(!$token) {

            return response()->json([
                'status' => 401,
                'error' => 'Token required.'
            ], 401);
        }
        try {
            $credentials = JWT::decode($token, env('JIVE_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }
        $user = Users::find($credentials->sub);
        
        $request->auth = $user;
        return $next($request);
    }
}