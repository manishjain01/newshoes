<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Validator;
//use App\Helpers\VisitorHelper;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('duration_greater_equal', function($attribute, $value, $parameters, $validator) {
            $duration_from = array_get($validator->getData(), $parameters[0], null);
            if(strtotime($duration_from) <= strtotime($value)){ 
                return true;
            }
           return false; 
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
       
    }
}
