<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a user and API token after a valid registration.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate(
            $request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            ]
        );

        $user = User::create(
            [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
            ]
        );

        $token = $user->createToken('Token')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(auth('web')->attempt($credentials) ) {
            $user = auth('web')->user();
            $success['token'] = $user->createToken('Token')->accessToken;
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }
}
