<?php

namespace App\Http\Middleware;

use Closure;

class CheckRequestMethod
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('put') || $request->isMethod('delete')) {
            // Adicione sua lógica de verificação aqui
            return response('Unauthorized.', 403);
        }

        return $next($request);
    }
}
