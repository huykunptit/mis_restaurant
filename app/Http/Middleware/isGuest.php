<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isGuest
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
            
            return $next($request);
        }

        else{
           
            if(auth()->user()->hasRole('admin')){

                return redirect()
                    ->route('home.admin');
            }

            elseif(auth()->user()->hasRole('staff')){
          ;
                return redirect()
                    ->route('home.staff');
            }

            elseif(auth()->user()->hasRole('customer')){
       
                return redirect()
                    ->route('home.customer');
            }
        }

    }
}
