<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if ($request->ajax()) {
                return response()->json([
                    'error'     => true,
                    'message'   => 'Anda sudah terautentikasi! Sistem akan mengarahkan anda ke panel administrator!',
                    'code'      => 403,
                    'redirect'  => route('admin.main'),
                ], 403);
            } else {
                return redirect()->route('admin.main')->with('error', 'Anda sudah terautentikasi!');
            }
        } else {
            return $next($request);
        }
    }
}
