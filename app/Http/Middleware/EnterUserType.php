<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnterUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $types)
    {
        \App::make('helper')->checkUserType(explode('|', $types), "접근 권한이 없습니다.");
        return $next($request);
    }
}
