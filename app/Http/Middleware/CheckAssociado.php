<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAssociado
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('associado')) {
            return redirect()->route('associado.login')->with('error', 'Você precisa estar logado.');
        }
        return $next($request);
    }
}
