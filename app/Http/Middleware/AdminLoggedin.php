<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminLoggedin
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
        if (!auth()->check()) {
            if ($request->ajax()) {
                return response()->json([
                    'error'     => true,
                    'message'   => 'Anda belum terautentikasi! Sistem akan mengarhkan anda ke halaman login.',
                    'code'      => 403,
                    'redirect'  => route('admin.main'),
                ], 403);
            } else {
                return redirect()->route('admin.login')->with('error', 'Anda belum terautentikasi!');
            }
        } else {
            return $next($request);
        }
    }
}
