<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Session;

class IsAdmin
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
        if (Auth::check()){
            if (Auth::user()->role == 'admin') {
                return $next($request);
            }
            else {
                Auth::logout();
                Session::flash('alert-danger', 'User Type Not Found');
                return redirect('/login');
            }
        }
        else {
            Auth::logout();
            Session::flash('alert-danger', 'Something Went Wrong');
            return redirect('/login');
        }
    }
}
