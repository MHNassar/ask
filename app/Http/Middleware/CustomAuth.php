<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($token = $request->header('token')) {
            $check = User::where('token', $token)->get();
            if ($check->count() > 0) {
                return $next($request);
            }
        }
        return response()->json(['error' => 'Unauthorized.'], 401);
    }
}
