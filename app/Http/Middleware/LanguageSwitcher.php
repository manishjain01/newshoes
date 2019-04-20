<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Session;
class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        App::setLocale(Session::has('locale') ? Session::get('locale'):Config::get('app.locale'));
        return $next($request);
    }
}
