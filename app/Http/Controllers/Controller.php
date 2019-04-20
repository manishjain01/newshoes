<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use HTML;
use View;
use App\Helpers\BasicFunction;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;




  public function __construct()
  {
    //its just a dummy data object.
 	  $admin_menus = BasicFunction::getAllList(); 

    // Sharing is caring
    	View::share('admin_menus', $admin_menus);
  }
    function InvalidUrl(){

    	if($this->getRouter()->getCurrentRoute()->getPrefix()=='/admin'){

			return  redirect()->action('Admin\PagesController@index')->with('alert-error',trans('admin.INVALID_URL'));
		}
	}
}
