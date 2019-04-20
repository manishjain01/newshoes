<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Config;
use Validator;
use Input;
use App\Pincode;
use App\Helpers\GlobalHelper;
use App\Helpers\BasicFunction;
use DB;

class PincodeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $search = Input::get('search');
        if ($search) {
            $sizes = Pincode::sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('pincode', 'LIKE', "%$search%");
                    })
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $sizes = Pincode::sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }

        $pageTitle = "Pincode";
        $title = "Pincode";
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';

        $breadcrumb = array('pages' => $pages, 'actives' =>'Pincode List', 'active' =>'admin.pincode.index');
        setCurrentPage('admin.pincode');

        return view('admin.pincode.index', compact('sizes', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';

        $breadcrumb = array('pages' => $pages, 'actives' =>'Add Pincode', 'active' =>'admin.pincode.index');

        return view('admin.pincode.create', compact('pages','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $validator = validator::make($request->all(), [

                    'pincode' => 'required|digits:6|integer|unique:pincode',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\PincodeController@create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();

        $plan = Pincode::create($input);
        return redirect()->action('Admin\PincodeController@index', getCurrentPage('admin.pincode'))->with('alert-sucess', 'Pincode Added Successfully');
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
        $plan = Pincode::find($id);


        if (empty($plan)) {
            return $this->InvalidUrl();
        }
        $pageTitle = "Pincode";
        $title = "Pincode";

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages['Pincode List'] = 'admin.pincode.index';
        $breadcrumb = array('pages' => $pages, 'actives' =>'Edit Pincode', 'active' =>'admin.pincode.index');
        return view('admin.pincode.edit', compact('pageTitle', 'title', 'breadcrumb', 'plan'));
    }

    public function update(Request $request, $id) {


        if ($id == '') {
            return $this->InvalidUrl();
        }
        $plan = Pincode::findOrFail($id);
        if (empty($plan)) {
            return $this->InvalidUrl();
        }

        $validator = validator::make($request->all(), [
                    'pincode' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\PincodeController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        //pr($input);exit;

        $plan->fill($input)->save();
        return redirect()->back()->with('alert-sucess', 'Pincode Update Successfully');
    }

    public function destroy($id) {
        $plan = Pincode::find($id)->delete();
        return redirect()->action('Admin\PincodeController@index');
    }

}
