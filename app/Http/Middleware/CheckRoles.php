<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
		$all_roles = explode('|', $role);
		$hasPerm = false;
		foreach ($all_roles as $r) {
			if ($request->user()->hasRole($r)) {
				$hasPerm = true;
			}
		}

		if (!$hasPerm) {
			abort(401, 'This action is unauthorized.');
		}
        return $next($request);
    }
}
