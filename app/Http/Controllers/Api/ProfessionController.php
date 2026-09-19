<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $professions = Profession::paginate($perPage);

        return $this->successResponse($professions, 'تم جلب المهن بنجاح.');
    }
}
