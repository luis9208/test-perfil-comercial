<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Permite el inicio de sesion
     *@param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $msg = '';
        $status = 200;
        try {
            if (!Auth::attempt($credentials)) {
                $msg = 'El usuario no es valido';
                $status = 401;
            }
            /**
             * @var User
             */
            $user = Auth::user();

            $token = $user->createToken('TokenPersonal');

            $msg = [
                'token' => $token->accessToken,
                'type' => 'Bearer Token',
                'user' => $user->id,
            ];
        } catch (\Throwable $th) {
            $msg = 'El usuario no existe';
            $status = 500;
        }

        return response()->json(['message' => $msg], $status);

    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'login'], 200);
    }
}
