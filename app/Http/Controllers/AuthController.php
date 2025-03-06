<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Summary of register
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6'
            ]);

            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);

            // $token = $user->createToken('AuthToken')->accessToken;

            return $this->successResponse(['user' => $user], 'User registered successfully', 201);

        } catch (ValidationException $e) {
            return $this->failedResponse('Validation failed', $e->errors(), 422);

        } catch (Exception $e) {
            return $this->errorResponse('Something went wrong', 500);
        }
    }

    /**
     * Summary of login
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);

            if (!Auth::attempt($validated)) {
                return $this->failedResponse('Invalid credentials', [], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;

            return $this->successResponse(['user' => $user, 'token' => $token], 'User logged in successfully', 200);

        } catch (ValidationException $e) {
            return $this->failedResponse('Validation failed', $e->errors(), 422);

        } catch (Exception $e) {
            return $this->errorResponse('Something went wrong', 500);
        }

    }

    /**
     * Summary of logout
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();

            return $this->successResponse([], 'Logged out successfully', 200);

        } catch (Exception $e) {
            return $this->errorResponse('Something went wrong', 500);
        }

    }
}
