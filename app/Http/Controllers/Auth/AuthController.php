<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller;
use App\Models\Users;

class AuthController extends Controller 
{

    private $request;

    protected function jwt(Users $user) {
        $payload = [
            'iss' => "jive-jwt", 
            'sub' => $user->id, 
            'iat' => time(),
            'exp' => time() + 60*60
        ];
        
        return JWT::encode($payload, env('JIVE_SECRET'));
    }


    public function __construct(Request $request) {
        $this->request = $request;
    }

    
    public function userAuthenticate(Users $user) {
        $this->validate($this->request, [
            'login'     => 'required',
            'password'  => 'required'
        ]);

        $login_type = filter_var($this->request->input('login'), FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';;

        if($login_type == 'email'){
            $user = Users::where('email', $this->request->input('login'))->first();
        }else{
            $user = Users::where('username', $this->request->input('login'))->first();
        }

        if (!$user) {
            
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);

        }

        if (Hash::check($this->request->input('password'), $user->password)) {
            return response()->json([
                'token' => $this->jwt($user)
            ], 200);
        }

        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    } 
}