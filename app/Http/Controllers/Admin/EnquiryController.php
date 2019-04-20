<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Config;
use Validator;
use Input;
use App\Size;
use App\Contact;
use App\Helpers\GlobalHelper;
use App\Helpers\BasicFunction;
use DB;

class EnquiryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
		
	
        $search = Input::get('search');
        if ($search) {
            $enquirys = Contact::sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('name', 'LIKE', "%$search%");
                    })
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $enquirys = Contact::sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
           
        }

        $pageTitle = "Enquiry";
        $title = "Enquiry";
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'active' => 'Client');
        setCurrentPage('admin.enquiry');

        return view('admin.enquiry.index', compact('enquirys', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create() {

        return view('admin.size.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $validator = validator::make($request->all(), [

                    'size' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\SizeController@create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();

        $plan = Size::create($input);
        return redirect()->action('Admin\SizeController@index', getCurrentPage('admin.size'))->with('alert-sucess', 'Size Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if ($id == '') {
            return $this->InvalidUrl();
        }
        $plan = Size::find($id);


        if (empty($plan)) {
            return $this->InvalidUrl();
        }
        $pageTitle = "Size";
        $title = "Size";

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.size.index';
        $breadcrumb = array('pages' => $pages, 'active' => 'Edit Plans');
        return view('admin.size.edit', compact('pageTitle', 'title', 'breadcrumb', 'plan'));
    }

    public function update(Request $request, $id) {


        if ($id == '') {
            return $this->InvalidUrl();
        }
        $plan = Size::findOrFail($id);
        if (empty($plan)) {
            return $this->InvalidUrl();
        }

        $validator = validator::make($request->all(), [
                    'size' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\SizeController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        //pr($input);exit;

        $plan->fill($input)->save();
        return redirect()->back()->with('alert-sucess', 'Size Update Successfully');
    }

    public function destroy($id) {
        $plan = Size::find($id)->delete();
        return redirect()->action('Admin\SizeController@index');
    }

}
