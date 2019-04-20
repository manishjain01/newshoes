<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cms;
use App\Helpers\BasicFunction;
use Validator;

class CmsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $cmslist = Cms::sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        $pageTitle = trans('admin.CMS_PAGES');
        $title = trans('admin.CMS_PAGES');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.CMS_PAGES'), 'active' =>'admin.cms.index');
        setCurrentPage('admin.cms');

        return view('admin.cms.index', compact('cmslist', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $pageTitle = trans('admin.CMS_PAGES');
        $title = trans('admin.CMS_PAGES');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.CMS_PAGES')] = 'admin.cms.index';


        $breadcrumb = array('pages' => $pages,  'actives' => trans('admin.CMS_PAGES'), 'active' =>'admin.cms.index');

        return view('admin.cms.create', compact('pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $cmsObj = new Cms();


        $validator = validator::make($request->all(), [
                    'title' => 'required|max:255',
                    'description' => 'required',
                    'meta_title' => 'required',
                    'meta_keywords' => 'required',
                    'meta_description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\CmsController@create')
                            ->withErrors($validator)
                            ->withInput();
        }


        $input = $request->all();
        $input['slug'] = BasicFunction::getUniqueSlug($cmsObj, $request->title);

        $cms = $cmsObj->create($input);
        return redirect()->action('Admin\CmsController@index', getCurrentPage('admin.cms'))->with('alert-sucess', trans('admin.CMSPAGES_ADD_SUCCESSFULLY'));
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
        $cms = Cms::find($id);
        if (empty($cms)) {
            return $this->InvalidUrl();
        }

        $pageTitle = trans('admin.CMS_PAGES');
        $title = trans('admin.CMS_PAGES');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.CMS_PAGES')] = 'admin.cms.index';


        $breadcrumb = array('pages' => $pages,  'actives' => trans('admin.CMS_PAGES'), 'active' =>'admin.cms.index');

        return view('admin.cms.edit', compact('cms', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {


        $validator = validator::make($request->all(), [
                    'title' => 'required|max:255',
                    'description' => 'required',
                    'meta_title' => 'required',
                    'meta_keywords' => 'required',
                    'meta_description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\CmsController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }



        $cms = Cms::findOrFail($id);
        $input = $request->all();
        $cms->fill($input)->save();
        return redirect()->action('Admin\CmsController@index', getCurrentPage('admin.cms'))->with('alert-sucess', trans('admin.CMSPAGES_UPDATE_SUCCESSFULLY'));
    }

    /**
     * Function To chnage Status of cms pages
     *
     * @param  int  $id id of cms pages
     * @param  int  $status 1/0 (current status of cms page i.e active or inactive)
     * @return \Illuminate\Http\Response
     */
    public function status_change($id, $status) {

        if (empty($id)) {
            return $this->InvalidUrl();
        }
        if ($status == 1) {

            $new_status = 0;
        } else {
            $new_status = 1;
        }
        $cms = Cms::where('id', '=', $id)->first();
        $cms->status = $new_status;
        $cms->save();
        return redirect()->action('Admin\CmsController@index', getCurrentPage('admin.cms'))->with('alert-sucess', trans('admin.CMSPAGES_CHANGE_STATUS_SUCCESSFULLY'));
    }
    
    public function destroy($id) {
        $plan = Cms::find($id)->delete();
        return redirect()->action('Admin\CmsController@index');
    }

}
