<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProviderProfile;
use App\Http\Requests\Api\Provider\SubmitProviderProfileRequest;
use App\Traits\ApiResponseTrait;

class ProviderProfileController extends Controller
{
    use ApiResponseTrait;

    public function show(Request $request)
    {
        $profile = $request->user()->providerProfile()->with('profession')->first();

        if (!$profile) {
            return $this->errorResponse('لم يتم تقديم طلب بعد.', 404);
        }

        return $this->successResponse($profile, 'تم جلب بيانات الطلب بنجاح.');
    }

    public function store(SubmitProviderProfileRequest $request)
    {
        $user = $request->user();
        
        $data = $request->validated();
        
        $files = ['profile_picture', 'id_front', 'id_back', 'police_clearance', 'commercial_register'];
        
        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $data[$fileKey] = $request->file($fileKey)->store('provider_docs', 'public');
            }
        }

        // If it's a new submission or re-submission after rejection
        $data['status'] = 'pending';
        
        $profile = ProviderProfile::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return $this->successResponse($profile, 'تم إرسال الطلب بنجاح وسيتم مراجعته خلال 24-48 ساعة.');
    }
}
