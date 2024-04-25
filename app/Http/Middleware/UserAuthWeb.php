<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Session;

class UserAuthWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('user')->check()) {
            // The user is logged in...
            return $next($request);
        }
        else{
            Session::flash('toast', ['type' => 'warning', 'title' => 'Authentication Failed !', 'message' => 'Please login to continue !']);
            return redirect()->route('user.login');
        }
        //return $next($request);
    }
}
