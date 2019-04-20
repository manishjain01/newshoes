<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Productcolor;
use App\Brand;
use App\Cart;
use Calendar;
use App\EmailTemplate;
use App\Productimage;
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

class ProductsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $search = trim(Input::get('product_title'));
        if ($search) {

            //pr(trim($search));exit;
            //echo "afda";exit;
            $prodcuts = Product::with('product_color', 'product_category', 'product_subcategory')
                    ->sortable(['created_at' => 'desc'])
                    ->whereHas('product_category', function($query) use($search) {
                        $query->where('cat_name', 'like', '%' . $search . '%');
                    })->orwhereHas('product_subcategory', function($query) use($search) {
                        $query->where('cat_name', 'like', '%' . $search . '%');
                    })->orWhere('product_title', 'LIKE', '%' . $search . '%')
                            ->orwhere('product_code', 'LIKE', "%$search%")
                                ->orwhere('price', 'LIKE', "%$search%")
                            ->paginate(Configure('CONFIG_PAGE_LIMIT'));
//pr($prodcuts);exit;
            /*$prodcuts = Product::with('product_color', 'product_category', 'product_subcategory')
                    ->sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('product_title', 'LIKE', "%$search%")
                                ->orwhere('product_code', 'LIKE', "%$search%")
                                ->orwhere('price', 'LIKE', "%$search%");
                    })
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));*/
        } else {
            $prodcuts = Product::with('product_color', 'product_category', 'product_subcategory')
                    ->sortable(['created_at' => 'desc'])
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }
        $pageTitle = 'Product List';
        $title = 'Product List';

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.prodcuts.index';
        $breadcrumb = array('pages' => $pages, 'active' => 'admin.products.index');
        return view('admin.products.index', compact('prodcuts', 'pageTitle', 'title', 'breadcrumb', 'user'));
    }

    public function create() {
        $pageTitle = trans('admin.ADD_USER');
        $title = trans('admin.ADD_USER');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.users.index';

        $user = Auth::user();
        $breadcrumb = array('pages' => $pages, 'active' => 'admin.products.index');
        $colors = DB :: table('colors')->where('status', '=', '1')->orderBy('color_name', 'asc')->pluck('color_name', 'id');
        $sizes = DB :: table('size')->where('status', '=', '1')->orderBy('size', 'asc')->pluck('size', 'id');
        $brands = DB :: table('brands')->where('status', '=', '1')->orderBy('brand_name', 'asc')->pluck('brand_name', 'id');
        $category_lists = ['' => 'Select Category'] + DB :: table('categories')
                        ->where('status', '=', '1')->where('parent_id', '=', '0')->orderBy('cat_name', 'asc')->pluck('cat_name', 'id');

        $sub_category_lists = ['' => 'Select Sub Category'] + DB :: table('categories')
                        ->where('parent_id', '!=', '0')->where('status', '=', '1')->orderBy('cat_name', 'asc')->pluck('cat_name', 'id');
        //$sub_category_lists[] = 'Select Sub Category';

        $sub_sub_category_lists[] = 'Select Sub Sub Category';
        return view('admin.products.create', compact('brands', 'pageTitle', 'title', 'breadcrumb', 'user', 'category_lists', 'sub_category_lists', 'colors', 'sizes', 'sub_sub_category_lists'));
    }

    public function store(Request $request) {
        //$request = $request->all();
        //$request['product_description'] = trim($request['product_description']);
        //pr(str_replace(array("\r", "\n", "\n", "\&nbsp"), '', $request['product_description']).'afd');
        //pr($request);exit;
        $validator = validator::make($request->all(), [
                    'product_title' => 'required|max:255|unique:products',
                    'category_id' => 'required',
                    'brand_id' => 'required',
                    'product_code' => 'required|max:255|unique:products',
                    'product_description' => 'required|min:2',
                    'price' => 'required',
                        //'total_quantity' => 'required|numeric',
                        // 'profile_image' => 'required|image|mimes:'.Config::get('global.image_mime_type').'|max:'.Config::get('global.file_max_size'),
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\ProductsController@create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $productsObj = new Product();
        $input = $request->all();
        $proattr = $input['proattr'];

        unset($input['proattr']);
        $input['slug'] = BasicFunction::getUniqueSlug($productsObj, $input['product_title']);
        $products = Product::create($input);

        foreach ($proattr as $proattrs) {
            $Datas['color_id'] = $proattrs['color_id'];
            $Datas['size_id'] = $proattrs['size_id'];
            $Datas['quantity'] = $proattrs['quantity'];
            $Datas['product_id'] = $products->id;
            Productcolor::create($Datas);
        }

        return redirect()->action('Admin\ProductsController@addimage', $products->id)->with('alert-sucess', trans('admin.USER_ADD_SUCCESSFULLY'));
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

        $product = Product::with('product_color')->find($id);
//pr($product);exit;

        if (empty($product)) {
            return $this->InvalidUrl();
        }



        $colors[] = "";
        foreach ($product->product_color as $products) {
            $colors[] = $products->color_id;
        }
        $procolors = array_filter($colors);


        $sizes[] = "";
        foreach ($product->product_color as $products) {
            $sizes[] = $products->size_id;
        }
        $prosizes = array_filter($sizes);




        $pageTitle = 'Edit Product';
        $title = 'Edit Product';
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages['Products'] = 'admin.products.index';
        $breadcrumb = array('pages' => $pages, 'actives' => 'Edit Product', 'active' => 'admin.products.index');
        $colors = DB :: table('colors')->where('status', '=', '1')->orderBy('color_name', 'asc')->pluck('color_name', 'id');
        $sizes = DB :: table('size')->where('status', '=', '1')->orderBy('size', 'asc')->pluck('size', 'id');

        $category_lists = ['' => 'Select Category'] + DB :: table('categories')->where('parent_id', '=', '0')->orderBy('cat_name', 'asc')->pluck('cat_name', 'id');
        $sub_category_lists = ['' => 'Select Sub Category'] + DB :: table('categories')->where('parent_id', '=', $product->category_id)->orderBy('cat_name', 'asc')->pluck('cat_name', 'id');
        //$sub_category_lists[] = 'Select Sub Category';
        if ($product->sub_category_id != 0) {
            $sub_sub_category_lists = ['' => 'Select Sub Sub Category'] + DB :: table('categories')->where('parent_id', '=', $product->sub_category_id)->orderBy('cat_name', 'asc')->pluck('cat_name', 'id');
        } else {
            $sub_sub_category_lists[] = 'Select Sub Sub Category';
        }
        $brands = DB :: table('brands')->where('status', '=', '1')->orderBy('brand_name', 'asc')->pluck('brand_name', 'id');
        return view('admin.products.edit', compact('brands', 'prosizes', 'procolors', 'sizes', 'colors', 'pageTitle', 'title', 'breadcrumb', 'product', 'user', 'category_lists', 'sub_category_lists', 'sub_sub_category_lists'));
    }

    public function update(Request $request, $id) {
        if ($id == '') {
            return $this->InvalidUrl();
        }
        $product = Product::findOrFail($id);
        //$product_color = Productcolor::where('product_id', $id);
        //pr($product_color);exit;
        if (empty($product)) {
            return $this->InvalidUrl();
        }

        $validator = validator::make($request->all(), [
                    'category_id' => 'required',
                    'brand_id' => 'required',
                    'product_title' => 'required|max:255|unique:products,product_title,' . $id,
                    //'size' => 'required|max:255',
                    //'color' => 'required|max:255',
                    'product_code' => 'required|max:255|unique:products,product_code,' . $id,
                    'product_description' => 'required',
                    'price' => 'required|numeric',
                        //'total_quantity' => 'required|numeric'
                        // 'profile_image' => 'required|image|mimes:'.Config::get('global.image_mime_type').'|max:'.Config::get('global.file_max_size'),
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\ProductsController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $request->all();

//pr($input);exit;
        if (!empty($input['proattr'])) {
            $proattr = $input['proattr'];
            unset($input['proattr']);
            unset($proattr["0"]);
        }
       

        $productsObj = new Product();
        $input['slug'] = BasicFunction::getUniqueSlug($productsObj, $input['product_title']);
        $product->fill($input)->save();
        $discount = ($input['discount'] / 100) * $input['price'];
        $price = $input['price'] - (($input['discount'] / 100) * $input['price']);
        $is_update = Cart::where('product_id', $product->id)
                ->update(['price' => $price, 'discount' => $discount, 'product_name' => $input['product_title']]);


        if (isset($proattr[1]['color_id']) && !empty($proattr[1]['color_id'])) {
            foreach ($proattr as $proattrs) {
                $Datas['color_id'] = $proattrs['color_id'];
                $Datas['size_id'] = $proattrs['size_id'];
                $Datas['quantity'] = $proattrs['quantity'];
                $Datas['product_id'] = $id;
                Productcolor::create($Datas);
            }
        }
        
        $wishlistProducts = DB::table('products')
                                ->join('wishlist', 'products.id', '=', 'wishlist.product_id')
                                ->join('users', 'users.id', '=', 'wishlist.user_id')
                                ->where('wishlist.product_id', $product->id)
                                ->orderby('wishlist.created_at', 'desc')
                                ->groupBy('wishlist.user_id')
                                ->select('wishlist.id as id','wishlist.product_id as product_id','wishlist.color_id as color_id','products.product_title as product_title', 'products.price as price', 'products.discount as discount','users.first_name','users.last_name','users.email')->get();
             
        //pr($wishlistProducts);exit;
           $prorow = array();
           
       //pr($product_color);exit;
        foreach ($wishlistProducts as $wishlistProduct){
            //$product_color = Productcolor::select('size_id','color_id','quantity')->where('product_id', $wishlistProduct->product_id)->where('color_id', $wishlistProduct->color_id)->get()->toArray();
            //$sizeName = CommonHelpers::sizeName($wishlistProduct->size_id);
            $colorName = CommonHelpers::colorName($wishlistProduct->color_id);
            $prorow[] = '<tr><td>'.$wishlistProduct->product_title.'</td><td>'.$colorName[0]['color_name'].'</td><td>'.$wishlistProduct->price.'</td><td>'.$wishlistProduct->discount.' %</td></tr>';
          $this->wishlist_email($wishlistProduct->first_name, $wishlistProduct->last_name, $wishlistProduct->email, $prorow); 
        }
        



        return redirect()->back()->with('alert-sucess', 'Product Update Successfully.');
    }
    
    public function wishlist_email($first_name, $last_name, $email, $prorow)
    {
        
        $tablehead = '<table border="1">
	<thead>
		<tr>
			<th>Product Name</th>
			<th>Product Color</th>
                        <th>Product Price</th>
                        <th>Product Discount</th>                        
		</tr>
	</thead>
	<tbody>';
        $tbalefooter = '</tbody>
	<tfoot>
	</tfoot>
</table>';
        $prorows = $tablehead.implode('<br/>', $prorow).$tbalefooter;
       
        //echo $prorows;
        //pr($prorow);
        //exit;
            $from = "info@pepealoans.com";
            $to = $email;
            $email_template = EmailTemplate::where('slug', '=', 'user-wishlist')->first();
            $email_type = $email_template->email_type;
            $subject = $email_template->subject;
            $body = $email_template->body;
            $to = $email;
            
    $body = str_replace(array(
                '{FIRST_NAME}',
                '{LAST_NAME}',
                '{PRO_ROWS}',
                    ), array(
                ucfirst($first_name),
                ucfirst($last_name),
                $prorows
                    ), $body);
            $subject = str_replace(array(
                '{FIRST_NAME}',
                '{LAST_NAME}',
                '{PRO_ROWS}'
                    ), array(
                ucfirst($first_name),
                ucfirst($last_name),
                $prorows
                    ), $subject);
//pr($body);exit;
            EmailHelper::sendMail($to, $from, '', $subject, 'default', $body, $email_type);
}


    public function addimage(Request $request, $id) {

        $pageTitle = 'Add Product Image';
        $title = 'Add Product Image';
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.users.index';

        $user = Auth::user();
        $breadcrumb = array('pages' => $pages, 'actives' => 'Add Images', 'active' => 'admin.products.index');
        $attachment = Productimage::with('product_image_color')->where('product_id', $id)->get();

        $color_List = DB::table('productcolors')
                ->join('colors', 'productcolors.color_id', '=', 'colors.id')
                ->where('productcolors.product_id', $id)
                ->orderby('colors.color_name', 'asc')
                ->groupBy('colors.id')
                ->pluck('colors.color_name as color_name', 'colors.id as id');

        $check_pro = Productimage::where('product_id', $id)->count();
        if ($check_pro > 0) {
            $is_update = Product::where('id', $id)
                    ->update(['is_image' => 1]);
        } else if ($check_pro == 0) {
            $is_update = Product::where('id', $id)
                    ->update(['is_image' => 0]);
        }

        //pr($color_List);exit;
        return view('admin.products.addimage', compact('pageTitle', 'title', 'breadcrumb', 'user', 'attachment', 'id', 'color_List'));
    }

    public function update_image(Request $request, $id) {
        //echo $id;
        $input = $request->all();
        //pr($input);exit;
        if ($id == '') {
            return $this->InvalidUrl();
        }
        /* $validator = validator::make($request->all(), [
          'image_name[]' => 'required|image|mimes:'.Config::get('global.image_mime_type').'|max:'.Config::get('global.file_max_size'),
          ]);
          if ($validator->fails()) {
          return redirect()->action('Front\ProductsController@edit', $id)
          ->withErrors($validator)
          ->withInput();
          } */



        if (!empty($input['image_attr']['0'])) {
            foreach ($input['image_attr'] as $file) {
                if (isset($file['image_name']) && !empty($file['image_name'])) {
                    //pr($file);exit;   
                    $destinationPath = 'public/uploads/products/';
                    $fileName = time() . '_' . $file['image_name']->getClientOriginalName();
                    $attachment_input['image_name'] = $fileName;
                    $attachment_input['color_id'] = $file['color_id'];
                    //$attachment_input['type'] = $file->getClientOriginalExtension();
                    $file['image_name']->move($destinationPath, $fileName);
                    $attachment_input['product_id'] = $id;
                    //pr($attachment_input);exit;
                    $attachments = Productimage::create($attachment_input);
                    $attachments->fill($attachment_input)->save();
                }
            }
        }

        //$input['dob'] = date('Y-m-d', strtotime($input['dob']));
        //pr($input);exit;
        /* if (!empty($input['profile_img'])) {
          $file = $input['profile_img'];
          }
          ini_set("upload_max_filesize", "10240M");
          if (!empty($file)) {
          $destinationPath = 'public/uploads/';
          $fileName = time() . '_' . $file->getClientOriginalName();
          $input['profile_img'] = $fileName;
          $file->move($destinationPath, $fileName);
          } */
//pr($input);exit;
        //$product->fill($input)->save();
        return redirect()->back()->with('alert-sucess', 'Product Image Update Successfully.');
    }

    public function remove_attachment() {

        $id = Input::get('id');
        $product_id = Input::get('product_id');
        $auth = adminUser();

        if (!empty($auth)) {
            $imageName = Productimage::where('id', $id)->first();
            $attachment = Productimage::find($id)->delete();
            if ($attachment) {
                $check_pro = Productimage::where('product_id', $product_id)->count();
                if ($check_pro > 0) {
                    $is_update = Product::where('id', $product_id)
                            ->update(['is_image' => 1]);
                } else if ($check_pro == 0) {
                    $is_update = Product::where('id', $product_id)
                            ->update(['is_image' => 0]);
                }

                $destinationPath = 'public/uploads/products/';
                BasicFunction::UnlinkImage($destinationPath, $imageName->image_name);
                echo json_encode(['message' => 'Attachment Remove Successfuly']);
                exit;
            }
        }
    }

    public function destroy($id) {

        $user = Product::find($id)->delete();
        Productcolor::where('product_id', $id)->delete();
        //Productsize::where('product_id', $id)->delete();
        $imageName = Productimage::where('product_id', $id)->get();
        //pr($imageName);exit;
        if (!empty($imageName)) {
            foreach ($imageName as $image) {
                $destinationPath = 'public/uploads/products/';
                BasicFunction::UnlinkImage($destinationPath, $image->image_name);
            }
            $image = Productimage::where('product_id', $id)->delete();
        }
        return redirect()->action('Admin\ProductsController@index');
    }

    public function remove_product_parameter($id, $product_id, $color_id) {
        Productcolor::where('id', $id)->delete();
        Productimage::where('product_id', $product_id)->where('color_id', $color_id)->delete();
        $check_pro = Productimage::where('product_id', $product_id)->count();
        if ($check_pro == 0) {
            $is_update = Product::where('id', $product_id)
                    ->update(['is_image' => 0]);
        }
        echo json_encode(['message' => 'Parameter Remove Successfuly']);
        exit;
    }

    public function update_product_qty($id, $qty) {
        $is_update = Productcolor::where('id', $id)
                ->update(['quantity' => $qty]);
         //return redirect()->back()->with('alert-sucess', 'Product Update Successfully.');
        echo json_encode(['message' => 'Qty Update Successfuly']);
        exit;
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
        $user = Product::where('id', '=', $id)->first();
        $user->status = $new_status;
        $user->save();
        return redirect()->back()->with('alert-sucess', 'Product Status Change Successfully.');
    }

    public function getsubcategory($id) {
        if (empty($id)) {
            return $this->InvalidUrl();
        }
        $subCategory = DB::table('categories')->where('parent_id', '=', $id)->orderBy('cat_name', 'asc')->pluck('cat_name', 'id');
        echo json_encode($subCategory);
        exit;
    }

    public function getsubsubcategory($id) {
        if (empty($id)) {
            return $this->InvalidUrl();
        }
        $subsubCategory = DB::table('categories')->where('parent_id', '=', $id)->orderBy('cat_name', 'asc')->pluck('cat_name', 'id');
        echo json_encode($subsubCategory);
        exit;
    }

}
