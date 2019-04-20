<?php

namespace App\Http\Controllers\Admin;

use Hash;
use DB;
use Config;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Menu;
use App\Helpers\BasicFunction;
use Validator;
use Input;
use App\Cms;

class MenuController     extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        


        $admin_menu_list = Menu::where('parent_id', '=', 0)->sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        

        /*         * breadcrumb* */
          $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
  
            $breadcrumb = array('pages' => $pages, 'active' => trans('admin.MENUS'));

            $pageTitle = trans('admin.MENUS');
            $title = trans('admin.MENUS');
       
          setCurrentPage('admin.menu');


        return view('admin.menu.index', compact('admin_menu_list', 'pageTitle', 'title', 'breadcrumb'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function childMenu($parent_id) {

        


        $admin_menu_list = Menu::where('parent_id', '=', $parent_id)->sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        

        /*         * breadcrumb* */
          $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
  
              $pages[trans('admin.MENUS')] = 'admin.menus.index';
    
            $admin_menu = Menu::find($parent_id);
           




            if (empty($admin_menu)) {
                return $this->InvalidUrl();
            }
      
            $breadcrumb = array('pages' => $pages, 'active' => ucfirst($admin_menu->name)."'s ".trans('admin.MENUS'));

            $pageTitle = trans('admin.MENUS');
            $title = trans('admin.MENUS');
       
        setCurrentPage('admin.child_menu');


        return view('admin.menu.child_menu', compact('admin_menu_list', 'pageTitle', 'title', 'breadcrumb','parent_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$parent_id = null) {




            $cmslist = Cms::orderBy('title')->lists('title', 'slug')->toArray();
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.MENUS')] = 'admin.menus.index';
        $pageTitle =trans('admin.ADD_MENU');
        $title = trans('admin.ADD_MENU');
        if ($parent_id != 0) {
            $admin_menu = Menu::find($parent_id);
            $pages[ucfirst($admin_menu->name)] = array('admin.menus.child_menu', array('id' => $parent_id));




            if (empty($admin_menu)) {
                return $this->InvalidUrl();
            }
                $pageTitle = ucfirst($admin_menu->name)."'s ".trans('admin.ADD_MENU');
                     $title = ucfirst($admin_menu->name)."'s ".trans('admin.ADD_MENU');
        }

     
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.ADD_MENU'));




        return view('admin.menu.create', compact('pageTitle', 'title', 'breadcrumb', 'parent_id','cmslist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $parent_id = null) {

        $admin_menuObj = new Menu();
        $validationRule = array(
            'name' => 'required|max:255',
            'menu_order' => 'required|numeric',
            'type' => 'required',
            'position' => 'required',
            

        );

        $input = $request->all();

        if(isset($input['type']) && $input['type']==1){
                 $validationRule['slug'] = 'required';
        }    
        

        $validator = validator::make($request->all(), $validationRule);
        if ($validator->fails()) {
            //  dd($validator);
            return redirect()->action('Admin\MenuController@create', $parent_id)
                            ->withErrors($validator)
                            ->withInput();
        }





        if ($parent_id==null) {
            $input['parent_id'] = 0;
        }else{
            $input['parent_id'] = $parent_id;

        }
        if($input['type']==1){

            $input['route']  ='';
            $input['parameter']  ='';
        }else{

            $input['slug']  ='';
        }

        if(!empty($input['position'])){
                $input['position']  =   implode(',', $input['position']);

        }else{
                $input['position']='';
        }

  
        $admin_menu = $admin_menuObj->create($input);

        $getCurrentPage['id'] = $parent_id;


if ($parent_id==null) {

        $getCurrentPage = $getCurrentPage + getCurrentPage('admin.menu');
     
        return redirect()->action('Admin\MenuController@index', $getCurrentPage)->with('alert-sucess', trans('admin.MENUS_ADD_SUCCESSFULLY'));

        }else{
         $getCurrentPage = $getCurrentPage + getCurrentPage('admin.child_menu');
     
        return redirect()->action('Admin\MenuController@childMenu', $getCurrentPage)->with('alert-sucess', trans('admin.MENUS_ADD_SUCCESSFULLY'));


        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $parent_id = null) {


        if ($id == '') {
            return $this->InvalidUrl();
        }
        $menus = Menu::find($id);
        if (empty($menus)) {
            return $this->InvalidUrl();
        }
        $cmslist = Cms::orderBy('title')->lists('title', 'slug')->toArray();;;
        $pageTitle = trans('admin.EDIT_MENU');
        $title = trans('admin.EDIT_MENU');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.MENUS')] = 'admin.menus.index';
      if ($parent_id != 0) {
            $admin_menu = Menu::find($parent_id);
            $pages[ucfirst($admin_menu->name)] = array('admin.menus.child_menu', array('id' => $parent_id));




            if (empty($admin_menu)) {
                return $this->InvalidUrl();
            }
              
        }


        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.EDIT_MENU'));

        return view('admin.menu.edit', compact('menus', 'pageTitle', 'title', 'breadcrumb', 'parent_id','cmslist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $parent_id = null) {


            $validationRule = array(
            'name' => 'required|max:255',
            'menu_order' => 'required|numeric',
            'type' => 'required',
            'position' => 'required',
            

        );

        $input = $request->all();

        if(isset($input['type']) && $input['type']==1){
                 $validationRule['slug'] = 'required';
        } 

        
        

        $validator = validator::make($request->all(), $validationRule);

        if ($validator->fails()) {
            return redirect()->action('Admin\MenuController@edit', array('id' => $id, 'parent_id' => $parent_id))
                            ->withErrors($validator)
                            ->withInput();
        }



        $admin_menu = Menu::findOrFail($id);
        $input = $request->all();
       

        if($input['type']==1){

            $input['route']  ='';
            $input['parameter']  ='';
        }else{

            $input['slug']  ='';
        }

        if(!empty($input['position'])){
                $input['position']  =   implode(',', $input['position']);

        }else{
                $input['position']='';
        }
        $admin_menu->fill($input)->save();

        $getCurrentPage['id'] = $parent_id;
        

if ($parent_id==null) {

        $getCurrentPage = $getCurrentPage + getCurrentPage('admin.menu');
     
        return redirect()->action('Admin\MenuController@index', $getCurrentPage)->with('alert-sucess', trans('admin.MENUS_UPDATE_SUCCESSFULLY'));

        }else{
         $getCurrentPage = $getCurrentPage + getCurrentPage('admin.child_menu');
     
        return redirect()->action('Admin\MenuController@childMenu', $getCurrentPage)->with('alert-sucess', trans('admin.MENUS_UPDATE_SUCCESSFULLY'));


        }
      
    }

    /**
     * Function To chnage Status of cms pages
     *
     * @param  int  $id id of cms pages
     * @param  int  $status 1/0 (current status of cms page i.e active or inactive)
     * @return \Illuminate\Http\Response
     */
    public function status_change($id, $status, $parent_id = null) {

        if (empty($id)) {
            return $this->InvalidUrl();
        }
        if ($status == 1) {

            $new_status = 0;
        } else {
            $new_status = 1;
        }
        $admin_menu = Menu::where('id', '=', $id)->first();
        $admin_menu->status = $new_status;
        $admin_menu->save();
        $getCurrentPage['id'] = $parent_id;
        

if ($parent_id==null) {

        $getCurrentPage = $getCurrentPage + getCurrentPage('admin.menu');
     
        return redirect()->action('Admin\MenuController@index', $getCurrentPage)->with('alert-sucess', trans('admin.MENUS_CHANGE_STATUS_SUCCESSFULLY'));

        }else{
         $getCurrentPage = $getCurrentPage + getCurrentPage('admin.child_menu');
     
        return redirect()->action('Admin\MenuController@childMenu', $getCurrentPage)->with('alert-sucess', trans('admin.MENUS_CHANGE_STATUS_SUCCESSFULLY'));


        }

    
    }

}
