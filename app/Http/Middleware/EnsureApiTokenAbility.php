<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class EnsureApiTokenAbility {
    public function handle(Request $request, Closure $next): Response {
        $ability = match ($request->method()) {
            'GET', 'HEAD' => 'read', 'POST' => 'create', 'PUT', 'PATCH' => 'update', 'DELETE' => 'delete', default => null,
        };
        abort_if($ability === null, 405);
        abort_unless($request->user()?->tokenCan($ability), 403, 'This token does not have the required ability.');
        return $next($request);
    }
}
