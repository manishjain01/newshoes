<?php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Session;



class AdminMiddleware
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
   public function handle($request, Closure $next)
    {
     /* dd(Session::has('url.intended'));
       echo $uri = $request->path();
       
       die;*/

    //Visitor::recordActivity();
          $current_path =   $request->path();

         if($current_path=='admin/logout'){
            Session::put('url.intended', 'admin/dashboard');

         }else{
             Session::put('url.intended', $request->path());
         }
    
    
     
    if (!Auth::guard('admin')->check()) {
        return redirect()->route('admin.login')->with('alert-error', trans('admin.NOT_LOGIN'));
    }elseif (Auth::guard('admin')->user()->role_id != 1){
       
        return redirect()->route('admin.login')->with('alert-error', trans('admin.NOT_AUTHORITY'));
    }
    return $next($request);
    }

}
