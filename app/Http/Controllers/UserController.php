<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // make a login function for api
    public function login(Request $request)
    {
        // make a validation for request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // make a variable for email and password
        $email = $request->email;
        $password = $request->password;

        // make a variable for user
        $user = User::where('email', $email)->first();

        // make a condition if user is not found
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed, Email Not Found!'
            ], 401);
        }

        // make a condition if password is wrong
        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed, Wrong Password!'
            ], 401);
        }

        // make a condition if user is found
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        // return response using response formatter
        return ResponseFormatter::success([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 'Authenticated');
    }

    public function fetchUser()
    {
        $user = Auth::user();
        if ($user) {
            return ResponseFormatter::success(
                $user,
                'Data User Berhasil Diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data User Tidak Ada',
                404
            );
        }
    }
}