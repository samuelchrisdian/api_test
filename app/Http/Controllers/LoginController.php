<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

class LoginController extends Controller
{
    public $response;
    public function __construct(){
        $this->response = new ResponseHelper();
    }
    
    public function login(Request $request){
		$credentials = $request->only('username', 'password');

		try {
			if(!$token = JWTAuth::attempt($credentials)){
                return $this->response->errorResponse('Invalid username and password');
			}
		} catch(JWTException $e){
            return $this->response->errorResponse('Generate Token Failed');
		}

        $data = [
			'token' => $token,
			'user'  => JWTAuth::user()
		];
        return $this->response->successResponseData('Authentication success', $data);
	}

	public function loginCheck(){
		try {
			if(!$user = JWTAuth::parseToken()->authenticate()){
				return $this->response->errorResponse('Invalid token!');
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
			return $this->response->errorResponse('Token expired!');
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
			return $this->response->errorResponse('Invalid token!');
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e){
			return $this->response->errorResponse('Token absent!');
		}

		return $this->response->successResponseData('Authentication success!', $user);
	}

    public function logout(Request $request)
    {
        if(JWTAuth::invalidate(JWTAuth::getToken())) {
            return $this->response->successResponse('You are logged out');
        } else {
            return $this->response->errorResponse('Logged out failed');
        }
    }
}