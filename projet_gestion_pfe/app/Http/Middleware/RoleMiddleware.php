<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response

    { if (!Auth::check()) {
        return redirect('login');
    }

    // Vérifie si l'utilisateur possède le rôle requis
    if (Auth::user()->role !== 'etudiant') {
        abort(403, 'Accès refusé');
    }

    return $next($request);
}

}
