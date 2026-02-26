<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function Flasher\Toastr\Prime\toastr;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!in_array(Auth::user()->role_id, $roles)) {
            return redirect()->back()->with('error', 'Bạn không đủ quyền truy cập.Vui lòng quay lại trang chủ');
        }
        return $next($request);
    }
}
