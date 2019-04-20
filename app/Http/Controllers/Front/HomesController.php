<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\Banner;
use App\Category;
use App\Cms;
use App\Helpers\GlobalHelper;
use App\Helpers\CommonHelpers;

//use vendor\firebase\token-generator\src;

class HomesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        /* try {

          $generator = new TokenGenerator('<YOUR_FIREBASE_SECRET>');
          pr($generator);
          exit;
          $token = $generator
          ->setData(array('uid' => 'exampleID'))
          ->create();
          } catch (TokenException $e) {
          echo "Error: " . $e->getMessage();
          }

          echo $token; */

        $pageTitle = trans('admin.DASHBOARD');
        $title = 'Home';
        /*         * breadcrumb* */

        $banners = Banner::where('status', '1')->orderBy('created_at', 'desc')->take(3)->get();
           
        $latest_products = Product::with('product_image')->where('status', '1')->where('is_image', '1')->orderBy('created_at', 'desc')->take(6)->get();
        
        /*$latest_products = Product::select('products.*','productcolors.size_id as size_id','productcolors.color_id as color_id')
                            ->join('productcolors', 'products.id', '=', 'productcolors.product_id')
                            ->where('products.status', '1')
                            ->orderBy('products.created_at', 'desc')->take(6)->get();*/
        
        $random_products = Product::with('product_image')->where('status', '1')->where('is_image', '1')->orderByRaw("RAND()")->take(6)->get();
       /* $random_products = Product::select('products.*','productcolors.size_id as size_id','productcolors.color_id as color_id')
                            ->join('productcolors', 'products.id', '=', 'productcolors.product_id')
                            ->where('products.status', '1')
                            ->orderByRaw("RAND()")->take(6)->get();*/
        //pr($random_products);exit;
         /*$featured_products = Product::with('product_category','product_subcategory')->select('products.*','productcolors.size_id as size_id','productcolors.color_id as color_id')
                            ->join('productcolors', 'products.id', '=', 'productcolors.product_id')
                            ->where('products.status', '1')
                            ->where('products.featured', '1')
                            ->orderBy('products.created_at', 'desc')->take(6)->get();*/
         
        $featured_products = Product::with('product_image','product_category','product_subcategory')->where('status', '1')->where('is_image', '1')->where('featured', '1')->orderBy('created_at', 'desc')->take(6)->get();
        $featured_products_count = Product::with('product_image','product_category','product_subcategory')->where('status', '1')->where('is_image', '1')->where('featured', '1')->orderBy('created_at', 'desc')->count();
        
        //pr($featured_products);exit;
        $mens_cat = Category::select('slug', 'cat_name')->where('status',  '1')->where('id', 1)->first();
        $womens_cat = Category::select('slug', 'cat_name')->where('status',  '1')->where('id', 2)->first();
	//pr($featured_products);exit;
        return view('front.homes.index', compact('womens_cat','featured_products_count','mens_cat','pageTitle', 'title','latest_products','random_products','featured_products','banners'));
    }
    
    public function cms_list($slug) {
		
        $pageTitle = trans('admin.DASHBOARD');
        $cmslist = Cms::Where('slug', $slug)->first();
        $title = $cmslist->meta_title;
        $meta_description = $cmslist->meta_description;
        $meta_keywords = $cmslist->meta_keywords;

        return view('front.homes.page', compact('pageTitle', 'cmslist','title','meta_description','meta_keywords'));
    }
    
    
     

}
