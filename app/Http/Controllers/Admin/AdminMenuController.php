<?php

namespace App\Http\Controllers\Admin;

use Hash;
use DB;
use Config;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminMenu;
use App\Helpers\BasicFunction;
use Validator;
use Input;

class AdminMenuController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        


        $admin_menu_list = AdminMenu::where('parent_id', '=', 0)->sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        

        /*         * breadcrumb* */
          $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
  
            $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.ADMIN_MENUS'), 'active' =>'admin.adminmenus.index');

            $pageTitle = trans('admin.ADMIN_MENUS');
            $title = trans('admin.ADMIN_MENUS');
       
          setCurrentPage('admin.admin_menu');


        return view('admin.admin_menu.index', compact('admin_menu_list', 'pageTitle', 'title', 'breadcrumb'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function childMenu($parent_id) {

        


        $admin_menu_list = AdminMenu::where('parent_id', '=', $parent_id)->sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        

        /*         * breadcrumb* */
          $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
  
              $pages[trans('admin.ADMIN_MENUS')] = 'admin.adminmenus.index';
    
            $admin_menu = AdminMenu::find($parent_id);
           




            if (empty($admin_menu)) {
                return $this->InvalidUrl();
            }
      
            $breadcrumb = array('pages' => $pages, 'actives' => ucfirst($admin_menu->name)."'s ".trans('admin.MENUS'), 'active' =>'admin.adminmenus.index');

            $pageTitle = trans('admin.ADMIN_MENUS');
            $title = trans('admin.ADMIN_MENUS');
       
        setCurrentPage('admin.child_admin_menu');


        return view('admin.admin_menu.child_menu', compact('admin_menu_list', 'pageTitle', 'title', 'breadcrumb','parent_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($parent_id = null) {
   
        /*         * breadcrumb* */



        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.ADMIN_MENUS')] = 'admin.adminmenus.index';
        $pageTitle =trans('admin.ADD_MENU');
        $title = trans('admin.ADD_MENU');
        if ($parent_id != 0) {
            $admin_menu = AdminMenu::find($parent_id);
            $pages[ucfirst($admin_menu->name)] = array('admin.adminmenus.child_menu', array('id' => $parent_id));




            if (empty($admin_menu)) {
                return $this->InvalidUrl();
            }
                $pageTitle = ucfirst($admin_menu->name)."'s ".trans('admin.ADD_MENU');
                     $title = ucfirst($admin_menu->name)."'s ".trans('admin.ADD_MENU');
        }

     
        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.ADD_MENU'), 'active' =>'admin.adminmenus.index');




        return view('admin.admin_menu.create', compact('pageTitle', 'title', 'breadcrumb', 'parent_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $parent_id = null) {

        $admin_menuObj = new AdminMenu();
        $validationRule = array(
            'name' => 'required|max:255',
            'menu_order' => 'required|numeric',
            
            'icon' => 'required',
            'image' => 'image|mimes:'.Config::get('global.image_mime_type').'|max:'.Config::get('global.file_max_size')

        );

        $input = $request->all();

        if(isset($input['is_deshboard']) && $input['is_deshboard']==1){
          $validationRule['image'] ='required|image|mimes:'.Config::get('global.image_mime_type').'|max:'.Config::get('global.file_max_size') ;          
         
        }    
        

        $validator = validator::make($request->all(), $validationRule);
        if ($validator->fails()) {
            //  dd($validator);
            return redirect()->action('Admin\AdminMenuController@create', $parent_id)
                            ->withErrors($validator)
                            ->withInput();
        }


       if ($request->hasFile('image')) {
            $name = BasicFunction::uploadImage(Input::file('image'), MENU_IMAGES_UPLOAD_DIRECTROY_PATH, 'blog_image_');
            $input['image'] = $name;
        }


        if ($parent_id==null) {
            $input['parent_id'] = 0;
        }else{
            $input['parent_id'] = $parent_id;

        }
        

        $admin_menu = $admin_menuObj->create($input);

        $getCurrentPage['id'] = $parent_id;


if ($parent_id==null) {

        $getCurrentPage = $getCurrentPage + getCurrentPage('admin.admin_menu');
     
        return redirect()->action('Admin\AdminMenuController@index', $getCurrentPage)->with('alert-sucess', trans('admin.ADMIN_MENUS_ADD_SUCCESSFULLY'));

        }else{
         $getCurrentPage = $getCurrentPage + getCurrentPage('admin.child_admin_menu');
     
        return redirect()->action('Admin\AdminMenuController@childMenu', $getCurrentPage)->with('alert-sucess', trans('admin.ADMIN_MENUS_ADD_SUCCESSFULLY'));


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
        $adminmenus = AdminMenu::find($id);
        if (empty($adminmenus)) {
            return $this->InvalidUrl();
        }

        $pageTitle = trans('admin.EDIT_MENU');
        $title = trans('admin.EDIT_MENU');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.ADMIN_MENUS')] = 'admin.adminmenus.index';
      if ($parent_id != 0) {
            $admin_menu = AdminMenu::find($parent_id);
            $pages[ucfirst($admin_menu->name)] = array('admin.adminmenus.child_menu', array('id' => $parent_id));




            if (empty($admin_menu)) {
                return $this->InvalidUrl();
            }
              
        }


        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.EDIT_MENU'), 'active' =>'admin.adminmenus.index');

        return view('admin.admin_menu.edit', compact('adminmenus', 'pageTitle', 'title', 'breadcrumb', 'parent_id'));
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
            
            'icon' => 'required',
            'image' => 'image|mimes:'.Config::get('global.image_mime_type').'|max:'.Config::get('global.file_max_size')
        );

        $input = $request->all();

        
        

        $validator = validator::make($request->all(), $validationRule);

        if ($validator->fails()) {
            return redirect()->action('Admin\AdminMenuController@edit', array('id' => $id, 'parent_id' => $parent_id))
                            ->withErrors($validator)
                            ->withInput();
        }



        $admin_menu = AdminMenu::findOrFail($id);
        $input = $request->all();
       
        if ($request->hasFile('image')) {
            $name = BasicFunction::uploadImage(Input::file('image'), MENU_IMAGES_UPLOAD_DIRECTROY_PATH, 'blog_image_',true, $admin_menu->image);
            $input['image'] = $name;
        }else{

             $input['image'] = $admin_menu->image;
        }


        $admin_menu->fill($input)->save();

        $getCurrentPage['id'] = $parent_id;
        

if ($parent_id==null) {

        $getCurrentPage = $getCurrentPage + getCurrentPage('admin.admin_menu');
     
        return redirect()->action('Admin\AdminMenuController@index', $getCurrentPage)->with('alert-sucess', trans('admin.ADMIN_MENUS_UPDATE_SUCCESSFULLY'));

        }else{
         $getCurrentPage = $getCurrentPage + getCurrentPage('admin.child_admin_menu');
     
        return redirect()->action('Admin\AdminMenuController@childMenu', $getCurrentPage)->with('alert-sucess', trans('admin.ADMIN_MENUS_UPDATE_SUCCESSFULLY'));


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
        $admin_menu = AdminMenu::where('id', '=', $id)->first();
        $admin_menu->status = $new_status;
        $admin_menu->save();
        $getCurrentPage['id'] = $parent_id;
        

if ($parent_id==null) {

        $getCurrentPage = $getCurrentPage + getCurrentPage('admin.admin_menu');
     
        return redirect()->action('Admin\AdminMenuController@index', $getCurrentPage)->with('alert-sucess', trans('admin.ADMIN_MENUS_CHANGE_STATUS_SUCCESSFULLY'));

        }else{
         $getCurrentPage = $getCurrentPage + getCurrentPage('admin.child_admin_menu');
     
        return redirect()->action('Admin\AdminMenuController@childMenu', $getCurrentPage)->with('alert-sucess', trans('admin.ADMIN_MENUS_CHANGE_STATUS_SUCCESSFULLY'));


        }

    
    }

}
