<?php

namespace empratur256\JWT\Middleware;



use App\User;
use Closure;
use empratur256\JWT\JWT;
use Exception;
use empratur256\JWT\ExpiredException;

class JWTMiddleware
{

	public function __construct()
	{

	}

    public function handle($request, Closure $next, $guard = null)
    {

        $token = $this->getToken($request);

        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);

        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);

        }
          $auth = User::find($credentials->sub);

        if($auth->logout >= $credentials->logout) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'This Token Logout.'
            ], 500);

        }
        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $auth;
        return $next($request);
    }


    protected function getToken($request){
        $token = $request->get('token');
        if(is_null($token)){
            $token = $request->header('authorization');
        }

        if(!$token) {
            return false;
        }
        return trim(str_ireplace('bearer', '', $token));
    }

}
