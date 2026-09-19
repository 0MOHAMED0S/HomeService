<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role !== 'provider') {
            return response()->json([
                'status' => 'Error',
                'message' => 'عذراً، هذا الإجراء مخصص لمقدمي الخدمات فقط.',
                'data' => null
            ], 403);
        }

        return $next($request);
    }
}
