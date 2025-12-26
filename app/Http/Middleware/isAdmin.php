<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is not logged in
        if(!auth()->user()){
            return redirect()
                ->route('login')
                ->with('error', 'You cannot access the previous page. Please log-in');
        }

        if (auth()->user()->hasRole('admin')) {
            return $next($request);
        }

        if (auth()->user()->hasRole('employee')) {
            return redirect()->route('home.staff');
        }

        if (auth()->user()->hasRole('customer')) {
            return redirect()->route('home.customer');
        }

        return abort(403);
    }
}
