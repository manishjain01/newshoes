<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Config;
use Validator;
use Input;
use App\Color;
use App\Helpers\GlobalHelper;
use App\Helpers\BasicFunction;
use DB;

class ColorsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $search = Input::get('search');
        if ($search) {
            $colors = Color::sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('color_name', 'LIKE', "%$search%");
                    })
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $colors = Color::sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }

        $pageTitle = "Color List";
        $title = "Color List";
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' =>'Color List','active' =>'admin.colors.index');
        setCurrentPage('admin.colors');

        return view('admin.colors.index', compact('colors', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'active' =>'admin.colors.index');

        return view('admin.colors.create', compact('pages','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $validator = validator::make($request->all(), [

                    'color_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'color_picker' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\ColorsController@create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $colorsObj = new Color();
        $input['slug'] = BasicFunction::getUniqueSlug($colorsObj, $input['color_name']);

        //echo "<pre>"; print_r($input); exit;
        $plan = Color::create($input);
        return redirect()->action('Admin\ColorsController@index', getCurrentPage('admin.colors'))->with('alert-sucess', 'Color Added Successfully');
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
        $plan = Color::find($id);


        if (empty($plan)) {
            return $this->InvalidUrl();
        }
        $pageTitle = "Edit Color";
        $title = "Edit Color";

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.colors.index';
        $breadcrumb = array('pages' => $pages, 'actives' =>'Color List','active' =>'admin.colors.index');
        return view('admin.colors.edit', compact('pageTitle', 'title', 'breadcrumb', 'plan'));
    }

    public function update(Request $request, $id) {
        if ($id == '') {
            return $this->InvalidUrl();
        }
        $plan = Color::findOrFail($id);
        if (empty($plan)) {
            return $this->InvalidUrl();
        }

        $validator = validator::make($request->all(), [
                    'color_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'color_picker' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\ColorsController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $colorsObj = new Color();
        $input['slug'] = BasicFunction::getUniqueSlug($colorsObj, $input['color_name']);
        $plan->fill($input)->save();
        return redirect()->back()->with('alert-sucess', 'Color Update Successfully');
    }

    public function destroy($id) {
        $plan = Color::find($id)->delete();
        return redirect()->action('Admin\ColorsController@index');
    }

}
