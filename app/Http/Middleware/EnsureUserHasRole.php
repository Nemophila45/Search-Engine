<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Ensure the authenticated user has one of the required roles.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            abort(403, 'Silakan login untuk mengakses halaman ini.');
        }

        $user = Auth::user();
        $requiredRoles = collect($roles)
            ->filter()
            ->map(fn (string $role) => UserRole::tryFrom($role))
            ->filter()
            ->all();

        if ($requiredRoles === [] || $user?->hasAnyRole(...$requiredRoles)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki hak akses untuk role ini.');
    }
}

