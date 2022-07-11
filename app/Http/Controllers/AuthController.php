<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
    * Register new users. It has  laravel validations for name email and password.
    *
    * @param Request
    * @return json
    */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $data['password'] = Hash::make($request->password);
        $data['corporacion_id'] = $request->corporacion_id;

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response([ 'user' => $user, 'token' => $token]);
    }

    /**
     * Login existing users. It has  laravel validations for name email and password.
     *
     * @param Request
     * @return json
     */
    public function login(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            //return response(['error_message' => 'Incorrect Details.
            //Please try again']);
            //return response(['message' => 'El usuario no existe.'], 422);
            return response([
                'errors' => [
                    'userNotFound' => 'El usuario no existe o la contraseña no es correcta.'

                ]
            ], 422);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token]);

    }
}
