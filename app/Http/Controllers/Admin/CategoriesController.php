<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Config;
use Validator;
use Input;
use App\Category;
use App\Helpers\GlobalHelper;
use App\Helpers\BasicFunction;
use DB;

class CategoriesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $search = Input::get('search');
        if ($search) {
            $categories = Category::sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('cat_name', 'LIKE', "%$search%");
                    })
                            ->where('parent_id', '0')
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $categories = Category::sortable(['created_at' => 'desc'])->where('parent_id', '0')
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }

        $pageTitle = "Categories List";
        $title = "Categories List";
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' =>'Categories List', 'active' =>'admin.categories.index');
        setCurrentPage('admin.category');

        return view('admin.categories.index', compact('categories', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $breadcrumb = array('pages' => $pages, 'actives' =>'Create Category', 'active' =>'admin.categories.index');

        return view('admin.categories.create',compact('pages','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $cmsObj = new Category();
        $validator = validator::make($request->all(), [

                    'cat_name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\CategoriesController@create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $input['slug'] = BasicFunction::getUniqueSlug($cmsObj, $request->cat_name);
        //echo "<pre>"; print_r($input); exit;
        $category = Category::create($input);
        return redirect()->action('Admin\CategoriesController@index', getCurrentPage('admin.categories'))->with('alert-sucess', 'Category Added Successfully');
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
        $category = Category::find($id);


        if (empty($category)) {
            return $this->InvalidUrl();
        }
        $pageTitle = "Category";
        $title = "Edit Category";

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages['Categories List'] = 'admin.categories.index';
        $breadcrumb = array('pages' => $pages, 'actives' =>'Edit Category', 'active' =>'admin.categories.index');
        return view('admin.categories.edit', compact('category', 'pageTitle', 'title', 'breadcrumb'));
    }

    public function update(Request $request, $id) {
        if ($id == '') {
            return $this->InvalidUrl();
        }
        $categories = Category::findOrFail($id);
        if (empty($categories)) {
            return $this->InvalidUrl();
        }

        $validator = validator::make($request->all(), [
                    'cat_name' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\CategoriesController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $categories->fill($input)->save();
        return redirect()->back()->with('alert-sucess', 'Category Update Successfully');
    }

    public function destroy($id) {
        $categories = Category::find($id)->delete();
        return redirect()->action('Admin\CategoriesController@index');
    }
    public function subindex_delete($id, $slug) {
        $categories = Category::find($id)->delete();
        return redirect()->action('Admin\CategoriesController@subindex', $slug);
    }

    public function subindex($slug) {
        $search = Input::get('search');
        $maincategory = Category::Select('cat_name','id')->where('slug', $slug)->where('parent_id', '=', '0')->get()->first();
        if ($search) {
            $categories = Category::sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('cat_name', 'LIKE', "%$search%");
                    })
                    ->where('parent_id', '=', $maincategory->id)
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $categories = Category::sortable(['created_at' => 'desc'])
                    ->where('parent_id', '=', $maincategory->id)
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }
        
       
        $pageTitle = "Sub Categories List";
        $title = "Sub Categories List";
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages['Categories List'] = 'admin.categories.index';


        $breadcrumb = array('pages' => $pages, 'actives' =>'Sub Categories List', 'active' =>'admin.categories.index');
        setCurrentPage('admin.category');

        return view('admin.categories.subindex', compact('categories', 'pageTitle', 'title', 'breadcrumb','maincategory','slug'));
    }
    
    public function addsubcategory($slug) {

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' =>'Add Sub Category', 'active' =>'admin.categories.index');

        return view('admin.categories.addsubcategory',compact('slug','pages','breadcrumb'));
    }
    
    public function addsubcategory_store(Request $request, $slug) {        
        $cmsObj = new Category();
        $validator = validator::make($request->all(), [
                    'cat_name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\CategoriesController@addsubcategory', $slug)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $maincategory_id = Category::Select('id')->where('slug', $slug)->get()->first();
        $input['parent_id'] = $maincategory_id->id;
        $input['slug'] = BasicFunction::getUniqueSlug($cmsObj, $request->cat_name);
        //echo "<pre>"; print_r($input); exit;
        $category = Category::create($input);
        return redirect()->action('Admin\CategoriesController@subindex',$slug)->with('alert-sucess', 'Category Added Successfully');
    }
    
    public function editsubcategory($slug, $mainslug) {
        
        if ($slug == '') {
            return $this->InvalidUrl();
        }
        $category = Category::where('slug', $slug)->get()->first();

        if (empty($category)) {
            return $this->InvalidUrl();
        }
        $pageTitle = "Edit Sub Category";
        $title = "Edit Sub Category";

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages['Categories List'] = 'admin.categories.index';
        $breadcrumb = array('pages' => $pages, 'actives' =>'Edit Sub Category', 'active' =>'admin.categories.index');
        return view('admin.categories.editsubcategory', compact('category', 'pageTitle', 'title', 'breadcrumb','mainslug'));
    }
    
    public function editsubcategory_update(Request $request, $slug, $mainslug) {
        if ($slug == '') {
            return $this->InvalidUrl();
        }
        $categories = Category::where('slug', $slug)->get()->first();
        if (empty($categories)) {
            return $this->InvalidUrl();
        }

        $validator = validator::make($request->all(), [
                    'cat_name' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\CategoriesController@editsubcategory', [$slug,$mainslug])
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $categories->fill($input)->save();
        return redirect()->back()->with('alert-sucess', 'Sub Category Update Successfully');
    }
     public function subsubindex($subslug = null) {
         //echo $subslug;exit;
        $search = Input::get('search');
        $subcategory = Category::Select('cat_name','id','parent_id')->where('slug', $subslug)->get()->first();
        //pr($subcategory);exit;
        $maincategory = Category::Select('cat_name','id','slug')->where('id', $subcategory->parent_id)->get()->first();
        //pr($maincategory);exit;
        $slug = $maincategory->slug;
        if ($search) {
            $categories = Category::sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('cat_name', 'LIKE', "%$search%");
                    })
                    ->where('parent_id', '=', $subcategory->id)
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $categories = Category::sortable(['created_at' => 'desc'])
                    ->where('parent_id', '=', $subcategory->id)
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }
        
       
        $pageTitle = "Sub Sub Categories List";
        $title = "Sub Sub Categories List";
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' =>'Sub Sub Categories', 'active' =>'admin.categories.index');
        setCurrentPage('admin.category');
        
        return view('admin.categories.subsubindex', compact('categories', 'pageTitle', 'title', 'breadcrumb','subcategory','slug','maincategory','subslug'));
    }
    
    public function addsubsubcategory($slug, $subslug) {

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $breadcrumb = array('pages' => $pages, 'active' =>'admin.categories.index');
        return view('admin.categories.addsubsubcategory',compact('slug', 'subslug','pages','breadcrumb'));
    }
      public function addsubsubcategory_store(Request $request, $slug, $subslug) {  
         
        $cmsObj = new Category();
        $validator = validator::make($request->all(), [
                    'cat_name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\CategoriesController@addsubsubcategory', $slug, $subslug)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $maincategory_id = Category::Select('id')->where('slug', $subslug)->get()->first();
        $input['parent_id'] = $maincategory_id->id;
        $input['slug'] = BasicFunction::getUniqueSlug($cmsObj, $request->cat_name);
        //echo "<pre>"; print_r($input); exit;
        $category = Category::create($input);
        
        
        return redirect()->action('Admin\CategoriesController@subsubindex',$subslug)->with('alert-sucess', 'Sub Sub Category Added Successfully');
    }
  
     public function editsubsubcategory($slug, $mainslug, $subslug) {
        
        if ($subslug == '') {
            return $this->InvalidUrl();
        }
        $category = Category::where('slug', $slug)->get()->first();
//pr($category);exit;
        if (empty($category)) {
            return $this->InvalidUrl();
        }
        $pageTitle = "Edit Sub Sub Category";
        $title = "Edit Sub Sub Category";

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.categories.index';
        $breadcrumb = array('pages' => $pages, 'active' =>'admin.categories.index');
        return view('admin.categories.editsubsubcategory', compact('category', 'pageTitle', 'title', 'breadcrumb','mainslug', 'subslug'));
    }
    
    public function editsubsubcategory_update(Request $request, $slug, $mainslug, $subslug) {
        if ($subslug == '') {
            return $this->InvalidUrl();
        }
        $categories = Category::where('slug', $subslug)->get()->first();
        
        if (empty($categories)) {
            return $this->InvalidUrl();
        }

        $validator = validator::make($request->all(), [
                    'cat_name' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\CategoriesController@editsubsubcategory', [$slug,$mainslug,$subslug])
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $categories->fill($input)->save();
        return redirect()->back()->with('alert-sucess', 'Sub Sub Category Update Successfully');
    }
   
    public function status_change($id, $status) {
        if (empty($id)) {
            return $this->InvalidUrl();
        }
        if ($status == 1) {
            $new_status = 0;
        } else {
            $new_status = 1;
        }
        $user = Category::where('id', '=', $id)->first();
        $user->status = $new_status;
        $user->save();
        return redirect()->back()->with('alert-sucess', 'Category Status Change Successfully.');
    }
    
}
