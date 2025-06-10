<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está autenticado e se seu papel é 'admin'
        if (Auth::check() && Auth::user()->role == 'admin') {
            // Se for, permite que a requisição continue
            return $next($request);
        }

        // Se não for admin, nega o acesso e redireciona para a home
        return redirect('/')->with('error', 'Acesso não autorizado.');
    }
}