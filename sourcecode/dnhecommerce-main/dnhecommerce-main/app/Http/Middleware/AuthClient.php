<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->session()->get('id_customer')) {
            return redirect()->route('client.auth.login');
        }

        return $next($request);
    }
}
