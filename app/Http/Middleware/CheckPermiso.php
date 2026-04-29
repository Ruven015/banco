<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermiso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next, $permiso)
    {
        $user = auth()->user();

        if (!$user || !$user->tienePermiso($permiso)) {
            abort(403, 'No tienes permiso');
        }

        return $next($request);
    }
}
