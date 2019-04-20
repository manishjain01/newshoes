<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cms;
use App\Contact;
use App\Helpers\GlobalHelper;
use App\Helpers\CommonHelpers;
use Validator;

class PagesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $pageTitle = trans('admin.DASHBOARD');
        $title = trans('admin.DASHBOARD');
        /*         * breadcrumb* */

        return view('front.pages.index', compact('pageTitle', 'title'));
    }
    
    public function contact()
    {
	$pageTitle = "Contact Us";
        $title = 'Contact Us';
        return view('front.pages.contact_us', compact('pageTitle', 'title'));
    }

    public function contact_post(Request $request)
	{
		$validator = validator::make($request->all(), [

                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255',
                    'subject' => 'required|max:255',
                    'message' => 'required',
                  ]);
        if ($validator->fails()) {
            return redirect()->action('Front\PagesController@contact')
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
       
        
       
        $user = Contact::create($input);


        return redirect()->action('Front\PagesController@contact')->with('alert-sucess', 'Thanks for your query. We will get back to you as soon as possible.');
	}

}
