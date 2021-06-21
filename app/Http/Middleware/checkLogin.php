<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Traits\RosterTrait;

class checkLogin
{
    use RosterTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::check())
        {
            $this->checkAllRoster();
            return $next($request);
        }
        return redirect()->route('login');
    }
}
