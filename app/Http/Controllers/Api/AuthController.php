<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }



    public function register(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validateUser->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validateUser->errors()
            ], 422);
        }

        $user = $this->userService->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3
        ]);

        return response()->json([
            'token' => $this->userService->getToken($user),
            'user' => $this->userService->getUserData($user),
        ], 201);
    }

    public function login(Request $request)
    {

        $validateUser = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if ($validateUser->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validateUser->errors()
            ], 422);
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Credentials not mach',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'token' => $this->userService->getToken($user),
            'user' => $this->userService->getUserData($user),
        ], 201);
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'user' => $this->userService->getUserData($user),
        ], 201);

    }

}
