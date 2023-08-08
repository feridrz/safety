<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:4',
            'email' => 'required|email',
        ]);

        $cached_code = Cache::get($request->email);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->errorResponse('Invalid email.', 422);
        }

        if ($cached_code && $cached_code == $request->code) {
            $user->verified_at = Carbon::now();;
            $user->save();

            return $this->successResponse(null, 'User verified successfully.', 200);
        } else {
            return $this->errorResponse('Verification code is wrong.');
        }
    }
}
