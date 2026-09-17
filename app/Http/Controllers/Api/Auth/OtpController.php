<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Models\OtpVerification;
use App\Http\Requests\Api\Auth\SendOtpRequest;
use App\Http\Requests\Api\Auth\VerifyOtpRequest;
use App\Jobs\SendOtpEmailJob;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    use ApiResponseTrait;

    public function sendOtp(SendOtpRequest $request)
    {
        $email = $request->email;
        $otp = rand(100000, 999999);

        OtpVerification::updateOrCreate(
            ['email' => $email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10),
                'verified_at' => null
            ]
        );

        // Dispatch Job
        SendOtpEmailJob::dispatch($email, $otp);

        return $this->successResponse(null, 'تم إرسال رمز التحقق بنجاح إلى بريدك الإلكتروني.');
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $verification = OtpVerification::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$verification) {
            return $this->errorResponse('رمز التحقق غير صحيح.', 400);
        }

        if ($verification->expires_at < now()) {
            return $this->errorResponse('رمز التحقق منتهي الصلاحية.', 400);
        }

        $verification->update([
            'verified_at' => now(),
            'expires_at' => now()->addMinutes(10), // Give them 10 mins to complete registration
        ]);

        return $this->successResponse(null, 'تم التحقق من الرمز بنجاح.');
    }
}
