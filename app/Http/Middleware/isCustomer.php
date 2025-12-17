<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isCustomer
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

        else{

            if(auth()->user()->hasRole('admin')){
                return redirect()
                    ->route('home.admin');
            }

            elseif(auth()->user()->hasRole('staff')){
                return redirect()
                    ->route('home.staff');
            }

            elseif(auth()->user()->hasRole('customer')){
                return $next($request);
            }
        }
    }
}
