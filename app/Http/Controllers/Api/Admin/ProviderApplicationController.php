<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProviderProfile;
use App\Http\Requests\Api\Admin\ReviewProviderApplicationRequest;
use App\Traits\ApiResponseTrait;

class ProviderApplicationController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        // Get applications (can filter by status e.g. pending)
        $status = $request->query('status', 'pending');
        
        $applications = ProviderProfile::with('user', 'profession')
            ->where('status', $status)
            ->paginate(15);
            
        return $this->successResponse($applications, 'تم جلب الطلبات بنجاح.');
    }

    public function show($id)
    {
        $application = ProviderProfile::with('user', 'profession')->find($id);

        if (!$application) {
            return $this->errorResponse('الطلب غير موجود.', 404);
        }

        return $this->successResponse($application, 'تم جلب تفاصيل الطلب بنجاح.');
    }

    public function review(ReviewProviderApplicationRequest $request, $id)
    {
        $application = ProviderProfile::find($id);

        if (!$application) {
            return $this->errorResponse('الطلب غير موجود.', 404);
        }

        $application->status = $request->status;
        
        if ($request->has('rejection_reason')) {
            $application->rejection_reason = $request->rejection_reason;
        }

        if ($request->has('field_statuses')) {
            $application->field_statuses = $request->field_statuses;
        }

        $application->save();

        // Optionally, send a notification or email to the provider here based on status

        return $this->successResponse($application, 'تم مراجعة الطلب وتحديث حالته بنجاح.');
    }
}
