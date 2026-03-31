<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Hanya admin yang bisa mengakses halaman ini.');
    }
}
