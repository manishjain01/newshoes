<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Banner;
use App\EmailTemplate;
use App\Helpers\EmailHelper;
use App\Helpers\CommonHelpers;
Use DB;
use Validator;
use Config;
use Input;
use App\Helpers\BasicFunction;
use Mail;
use Crypt;
use Image;
use Session;

class BannerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $search = trim(Input::get('title'));
        //pr($search);exit;
        if ($search) {

            
            //echo "afda";exit;
            $banners = Banner::sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('title', 'LIKE', "%$search%");
                    })
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $banners = Banner::sortable(['created_at' => 'desc'])
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }



        $pageTitle = 'Banner List';
        $title = 'Banner List';

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.banner.index';
        //$breadcrumb = array('pages' => $pages, 'active' => trans('admin.EDIT_USER'));
        $breadcrumb = array('pages' => $pages, 'active' =>'admin.banner.index');
        return view('admin.banner.index', compact('banners', 'pageTitle', 'title', 'breadcrumb', 'user'));
    }

    public function create() {

        $pageTitle = trans('admin.ADD_USER');
        $title = trans('admin.ADD_USER');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.banner.index';

        $user = Auth::user();
        $breadcrumb = array('pages' => $pages, 'active' =>'admin.banner.index');

        return view('admin.banner.create', compact('pageTitle', 'title', 'breadcrumb'));
    }

    public function store(Request $request) {

        $validator = validator::make($request->all(), [
                    'title' => 'required|max:255',
                    'image' => 'required|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size').'|image|dimensions:max_width=1900,max_height=800,min_width=1200,min_height=700',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\BannerController@create')
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $request->all();

        $file = $input['image'];
        if (!empty($file)) {
            $destinationPath = 'public/uploads/banner/';
            $fileName = time() . '_' . $file->getClientOriginalName();
            $input['image'] = $fileName;
            /* Image::make($attachment_name->getRealPath())->resize('100', '100')->save($destinationPath.'thumbnails/'.$fileName); */
            $file->move($destinationPath, $fileName);
        }
        //pr($input);exit;


        $banner = Banner::create($input);

        return redirect()->action('Admin\BannerController@index')->with('alert-sucess', trans('admin.USER_ADD_SUCCESSFULLY'));
    }

    public function show($id) {
        //$user = User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {

        $user = LoginUser();

        /* if (empty($auth)) {
          return redirect()->action('Front\HomesController@index');
          } */

        $banner = Banner::find($id);
        if (empty($banner)) {
            return $this->InvalidUrl();
        }

        $pageTitle = 'Edit Banner';
        $title = 'Edit Banner';
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages['Banner'] = 'admin.banner.index';
        $breadcrumb = array('pages' => $pages, 'actives' =>'Edit Banner', 'active' =>'admin.banner.index');


        return view('admin.banner.edit', compact('pageTitle', 'title', 'breadcrumb', 'banner', 'user'));
    }

    public function update(Request $request, $id) {

        if ($id == '') {
            return $this->InvalidUrl();
        }
        $banner = Banner::findOrFail($id);

        //pr($product_color);exit;
        if (empty($banner)) {
            return $this->InvalidUrl();
        }

        $validator = validator::make($request->all(), [
                    'title' => 'required|max:255' . $id,
                    'image' => 'mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size').'|image|dimensions:max_width=1900,max_height=800,min_width=1200,min_height=700',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\BannerController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $request->all();


        
        
        if(!empty($input['image'])){
            $file = $input['image'];
            $destinationPath = 'public/uploads/banner/';
            $fileName = time() . '_' . $file->getClientOriginalName();
            $input['image'] = $fileName;
            /* Image::make($attachment_name->getRealPath())->resize('100', '100')->save($destinationPath.'thumbnails/'.$fileName); */
            $file->move($destinationPath, $fileName);
        }


        //$input['slug'] = BasicFunction::getUniqueSlug($productsObj, $input['title']);
        $banner->fill($input)->save();

        return redirect()->back()->with('alert-sucess', 'Banner Update Successfully.');
    }

    public function destroy($id) {

        $user = Banner::find($id)->delete();

        //pr($imageName);exit;
        if (!empty($imageName)) {
            foreach ($imageName as $image) {
                $destinationPath = 'public/uploads/banner/';
                BasicFunction::UnlinkImage($destinationPath, $image->image);
            }
            $image = Productimage::where('id', $id)->delete();
        }
        return redirect()->action('Admin\BannerController@index');
    }

    public function getsubcategory($id) {
        if (empty($id)) {
            return $this->InvalidUrl();
        }
        $subCategory = DB::table('categories')->where('parent_id', '=', $id)->orderBy('cat_name', 'asc')->pluck('cat_name', 'id');
        echo json_encode($subCategory);
        exit;
    }

}
