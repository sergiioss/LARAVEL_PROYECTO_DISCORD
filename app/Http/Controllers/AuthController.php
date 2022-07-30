<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    const ROLE_USER = 1;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'steamusername' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
            'username' => $request->get('username'),
            'steamusername' => $request->get('steamusername'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->password)
        ]);

        $user->roles()->attach(self::ROLE_USER);

        return response()->json(compact('user'), 201);
    }

    public function login(Request $request)
    {

        /* El only te accede solo a los campos que tu le dices. */

        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }

    public function info()
    {
        return response()->json(auth()->user());
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatedUser(Request $request)
    {
        try {

            Log::info("Updated User");

            $validator = Validator::make($request->all(), [
                'username' => ['string'],
                'steamusername' => ['string'],
                'email' => ['string']

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 400);
            };

            $userEmail = auth()->user()->email;

            $user = User::query()
                ->where('email', $userEmail)
                ->get();

            if (!$user) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Error'
                    ]
                );
            }

            $username = $request->input('username');
            $steamusername = $request->input('steamusername');
            $email = $request->input('email');

            if (isset($username)) {
                $user = User::query()
                    ->where('email', $userEmail)
                    ->update(['users.username' => $username]);
            }

            if (isset($steamusername)) {
                $user = User::query()
                    ->where('email', $userEmail)
                    ->update(['users.steamusername' => $steamusername]);
            }

            if (isset($email)) {
                $user = User::query()
                    ->where('email', $userEmail)
                    ->update(['users.email' => $email]);
            }


            return response()->json([
                'success' => true,
                'message' => "User updated"
            ], 200);
        } catch (\Exception $exception) {
            Log::error('Error updated user' . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error updated user'
                ],
                500
            );
        }
    }
}
