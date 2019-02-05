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
        $token = $request->get('token');
        
        if(!$token) {

            return response()->json([
                'error' => 'Token not provided.'
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