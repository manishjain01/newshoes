<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Config;
use Validator;
use Input;
use App\Brand;
use App\Helpers\GlobalHelper;
use App\Helpers\BasicFunction;
use DB;

class BrandController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $search = Input::get('search');
        if ($search) {
            $brands = Brand::sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('brand_name', 'LIKE', "%$search%");
                    })
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $brands = Brand::sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }

        $pageTitle = "Brand";
        $title = "Brand";
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' =>'Brand Page', 'active' =>'admin.brands.index');
        setCurrentPage('admin.brands');

        return view('admin.brands.index', compact('brands', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $breadcrumb = array('pages' => $pages, 'actives' =>'Brand Page', 'active' =>'admin.brands.index');

        return view('admin.brands.create', compact('pages','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $validator = validator::make($request->all(), [

                    'brand_name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\BrandController@create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();

        $plan = Brand::create($input);
        return redirect()->action('Admin\BrandController@index', getCurrentPage('admin.brand'))->with('alert-sucess', 'Brand Added Successfully');
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
        $brand = Brand::find($id);


        if (empty($brand)) {
            return $this->InvalidUrl();
        }
        $pageTitle = "Brand";
        $title = "Brand";

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.brands.index';
        $breadcrumb = array('pages' => $pages, 'actives' =>'Brand Page', 'active' =>'admin.brands.index');
        return view('admin.brands.edit', compact('pageTitle', 'title', 'breadcrumb', 'brand'));
    }

    public function update(Request $request, $id) {


        if ($id == '') {
            return $this->InvalidUrl();
        }
        $brand = Brand::findOrFail($id);
        if (empty($brand)) {
            return $this->InvalidUrl();
        }

        $validator = validator::make($request->all(), [
                    'brand_name' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\BrandController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        //pr($input);exit;

        $brand->fill($input)->save();
        return redirect()->back()->with('alert-sucess', 'Brand Update Successfully');
    }

    public function destroy($id) {
        $brand = Brand::find($id)->delete();
        return redirect()->action('Admin\BrandController@index');
    }

}
