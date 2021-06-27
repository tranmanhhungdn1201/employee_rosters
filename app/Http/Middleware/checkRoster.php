<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Traits\RosterTrait;

class checkRoster
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
        $this->checkRosterById($request->id);
        return $next($request);
    }
}
