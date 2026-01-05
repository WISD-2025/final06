<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 未登入：導去登入頁
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 已登入但角色不符：403
        if (auth()->user()->role !== $role) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
