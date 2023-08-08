<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function checkEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255|unique:users',
        ];
        $validationResult = $this->validateInput($request, $rules);
        if ($validationResult !== null) {
            return $validationResult;
        }

        $token = Str::random(60);

        // by default this should last for 1 hour (60 minutes)
        Cache::put($token, $request->email, 60);

        return $this->successResponse([
            'status' => 'success',
            'message' => 'Email step passed. Proceed to password.',
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        $rules = [
            'password' => 'required|min:6',
            'token' => 'required',
        ];
        $validationResult = $this->validateInput($request, $rules);
        if ($validationResult !== null) {
            return $validationResult;
        }

        // get the email associated with the token
        $email = Cache::get($request->token);

        if (!$email) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired token.',
            ], 400);
        }


        try {
            User::create([
                'email' => $email,
                'password' => Hash::make($request->password),
            ]);

            $verification_code = random_int(1000, 9999);
            $mailResponse = Mail::to($email)->send(new VerificationCode($verification_code));

            if($mailResponse){
                Cache::put($email, $verification_code, 600);
                // clear the token from the cache
                Cache::forget($request->token);

                return $this->successResponse([],
                    'User registered successfully. Please check your email to verify your account, You have 10 minutes to verify',
                    201);
            } else{
                dd('server error');
            }


        } catch (\Illuminate\Database\QueryException $e) {
            // If two users passed email validation in concurrent scenario with same email
            // Error code 23000 represents a unique constraint violation in MySQL.
            if ($e->getCode() == 23000) {
                return $this->errorResponse('The email is already registered.');
            }

            throw $e;
        }
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        // Attempt to log in the user with the provided credentials
        if (! $token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Login or Password Incorrect', [], 401);
        }

        if (!auth()->user()->verified_at) {
            return $this->errorResponse('Please Verify Email', [], 401);
        }

        return $this->respondWithToken($token);
    }

    public function refresh()
    {
        if (!$token = JWTAuth::getToken()) {
            return $this->errorResponse('Token not provided', [], 401);
        }

        try {
            $token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $e) {
            return $this->errorResponse('Token is Invalid', [], 400);
        } catch (JWTException $e) {
            return $this->errorResponse('Token not provided', [], 401);
        }

        return $this->successResponse(compact('token'));
    }

}

