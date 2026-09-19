<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Models\User;
use App\Models\OtpVerification;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\UpdateLocationRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(RegisterRequest $request)
    {
        // Check if OTP was verified within last 10 minutes
        $verification = OtpVerification::where('email', $request->email)
            ->whereNotNull('verified_at')
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return $this->errorResponse('لم يتم التحقق من البريد الإلكتروني أو انتهت صلاحية التحقق.', 400);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'phone' => $request->phone,
                'birthdate' => $request->birthdate,
                'privacy_agree' => $request->boolean('privacy_agree'),
                'email_verified_at' => now()
            ]);

            // Clear OTP
            $verification->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponse([
                'user' => $user,
                'token' => $token
            ], 'تم التسجيل بنجاح.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Registration Error: ' . $e->getMessage());
            return $this->errorResponse('حدث خطأ أثناء التسجيل.', 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('بيانات الدخول غير صحيحة.', 401);
        }

        // Single device policy: revoke all existing tokens
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'token' => $token
        ], 'تم تسجيل الدخول بنجاح.');
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        
        // Single device policy: revoke old token
        $user->currentAccessToken()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'token' => $token
        ], 'تم تحديث التوكن بنجاح.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return $this->successResponse(null, 'تم تسجيل الخروج بنجاح.');
    }

    public function updateLocation(UpdateLocationRequest $request)
    {
        $user = $request->user();
        
        $profile = $user->providerProfile;
        
        if ($profile) {
            $profile->update([
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
            ]);
            return $this->successResponse($profile, 'تم تحديث الموقع بنجاح.');
        }

        return $this->errorResponse('لا يوجد ملف شخصي لتحديث الموقع.', 404);
    }
}
