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
use App\Helpers\GlobalHelper;
use App\Helpers\BasicFunction;
use DB;

class SizeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $search = Input::get('search');
        if ($search) {
            $sizes = Size::sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('size', 'LIKE', "%$search%");
                    })
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $sizes = Size::sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }

        $pageTitle = "Size";
        $title = "Size";
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' =>'Size List', 'active' =>'admin.brands.index');
        setCurrentPage('admin.breastsize');

        return view('admin.size.index', compact('sizes', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $breadcrumb = array('pages' => $pages, 'actives' =>'Add Size', 'active' =>'admin.brands.index');

        return view('admin.size.create', compact('pages','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $validator = validator::make($request->all(), [

                    'size' => 'required|numeric',
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
        $breadcrumb = array('pages' => $pages, 'actives' =>'Edit Size', 'active' =>'admin.brands.index');
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
                    'size' => 'required|numeric'
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
