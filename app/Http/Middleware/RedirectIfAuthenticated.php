<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // return redirect(RouteServiceProvider::HOME);
                $role = auth()->user()->getrole->name; 
                if($role=='Super Admin'){
                    return redirect('/super-admin');
                }elseif($role=='PM'){
                    return redirect('/website');
                }
                elseif($role=='Team Lead'){
                    return redirect('/website_list');
                }
                elseif($role=='Scrapper'){
                    return redirect('/website_list');
                }
                elseif($role=='PA'){
                    return redirect('/website_list');
                }
                elseif($role=='QC'){
                    return redirect('/website_list');
                }
                elseif($role=='QA'){
                    return redirect('/website_list');
                }
                elseif($role=='Client'){
                    return redirect('/website_list');
                }
                else{
                    return redirect('/login');
                }
            }
        }

        return $next($request);
    }
}
