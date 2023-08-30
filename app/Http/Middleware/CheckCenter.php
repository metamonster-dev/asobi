<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCenter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userType = \App::make('helper')->getUsertType();
        if (in_array($userType, ['a','h'])) {
            $center = session()->get('center') ?? "";
            if ($center == "") \App::make('helper')->alert("교육원을 선택해주세요.","/");
        }
        return $next($request);
    }
}
