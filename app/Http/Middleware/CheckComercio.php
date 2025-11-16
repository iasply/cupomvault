<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckComercio
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('comercio')) {
            return redirect()->route('comercio.login')->with('error', 'Você precisa estar logado.');
        }
        return $next($request);
    }
}
