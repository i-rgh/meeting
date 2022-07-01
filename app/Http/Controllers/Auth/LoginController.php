<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Login user  (create the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // can login with email|username
        $vartype = filter_var($request->email_username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::getUser($vartype, $request->email_username);

        if (!$user) {
            $response = ["message" => 'کاربری با این ایمیل پیدا نشد'];
            return response($response, 422);
        } 
            if (!Auth::attempt(array($vartype => $request->email_username, 'password' => $request->password))) {
                $response = ["message" => "رمز عبور صحیح نمی باشد"];
                return response($response, 422);
            } else {
                $token = auth()->user()->createToken(auth()->user()->emmail);
                return new LoginResource($token);
            }
        
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if (Auth::check()) {
            if (Auth::user()->AauthAcessToken()->delete()) {
                $response = ['message' => 'با موفقیت از حساب کاربری خود خارج شدید.'];
                return response($response, 200);
            }
        }
    }
}
