<?php

namespace App\Helpers;

use App\Category;
use App\Cms;
use App\Size;
use App\Color;
use App\Cart;
use App\Wishlist;
use App\Reviews;
use App\Productcolor;
use App\Productimage;
Use DB;

class CommonHelpers {
    public static function getcmslist() {
        $cmslist = Cms::select('slug', 'title', 'id')->where('status', '=', 1)->orderBy('id')->get()->toArray();
        return $cmslist;
    }

    public static function getcatlist() {
        $category_lists = Category ::where('parent_id', '=', '0')->where('status', '=', 1)->orderBy('id', 'asc')->get();
        return $category_lists;
    }

    public static function getsubCatlist($id) {
        $category_lists = Category ::where('parent_id', $id)->where('status', '=', 1)->orderBy('id', 'asc')->get();
        return $category_lists;
    }

    public static function getsubsubCatlist($id) {
        $category_lists = Category ::where('parent_id', $id)->where('status', '=', 1)->orderBy('id', 'asc')->get();
        return $category_lists;
    }

    public static function getsizeProductList($product_id, $color_id) {
        $product_sizes = DB::table('productcolors')
                ->join('size', 'productcolors.size_id', '=', 'size.id')
                ->where('productcolors.product_id', $product_id)
                ->where('productcolors.color_id', $color_id)
                ->orderby('size.size', 'asc')
                ->pluck('size.size', 'size.id');
        return $product_sizes;
    }

    public static function getsizelist() {
        $size_lists = Size ::where('status', '=', '1')->orderBy('id', 'asc')->get();
        return $size_lists;
    }

    public static function getcolorlist() {
        $color_lists = Color ::where('status', '=', '1')->orderBy('id', 'asc')->get();
        return $color_lists;
    }

    public static function getSize($sizeid) {
        $size_name = Size ::where('id', '=', $sizeid)->where('status', '=', '1')->get()->toArray();
        //pr($size_name);exit;
        return $size_name;
    }

    public static function getColor($colorid) {
        $color_name = Color ::where('id', '=', $colorid)->get()->toArray();
        return $color_name;
    }

    public static function count_wishlist($user_id) {
        $wishlistcount = Wishlist::Where('user_id', $user_id)->count();
        
        return $wishlistcount;
    }

    public static function wishlist_list($user_id, $product_id, $colorId = null) {
        $wishlist = Wishlist::Select('id')
                ->where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->where('color_id', $colorId)
                ->get()->toArray();
        return $wishlist;
    }

    public static function wishlistProducts($user_id) {
        $wishlistProduts = Wishlist::Select()->where('user_id', $user_id)->get()->toArray();
        return $wishlistProduts;
    }

    public static function allWishlistProducts($user_id) {
        $wishlistProduts = DB::table('products')
                        ->join('wishlist', 'products.id', '=', 'wishlist.product_id')
                        //->join('images', 'products.id', '=', 'images.product_id')
                        ->where('wishlist.user_id', $user_id)
                        ->orderby('wishlist.created_at', 'desc')
                        //->groupBy('products.id')
                        ->select('wishlist.id as id','wishlist.product_id as product_id','wishlist.color_id as color_id','products.product_title as product_title', 'products.price as price','products.discount as discount', 'products.slug as slug', 'products.status as status')->get();
        //pr($wishlistProduts);
        return $wishlistProduts;
    }

    public static function count_cartlist($session_id, $userId) {
        if($userId == 0){
            $cartlistcount = Cart::Where('session_id', $session_id)->count();           
        }else{
            $cartlistcount = Cart::Where('user_id', $userId)->orwhere('session_id', $session_id)->count(); 
        }
        return $cartlistcount;
    }

    public static function productReviews($product_id) {
        $reviews = Reviews::Where('product_id', $product_id)->sum('rating');
        return $reviews;
    }

    public static function productReviewsCount($product_id) {
        $reviews_count = Reviews::Where('product_id', $product_id)->count();
        return $reviews_count;
    }

    public static function getProductColor($color_id) {
        $color_lists = Color ::where('status', '=', '1')
                        ->where('id', $color_id)
                        ->orwhere('slug', $color_id)
                        ->orderBy('id', 'asc')->first();
        
        return $color_lists;
    }
    
    public static function getProductColor_image($color_id, $product_id) {
          $color_lists = DB::table('colors')
                            ->join('images', 'images.color_id', '=', 'colors.id')
                            ->where('colors.status', '=', '1')
                            ->where('colors.id', $color_id)
                            ->where('images.product_id', $product_id)
                            ->orderBy('colors.id', 'asc')->first();
        //pr($color_lists);
        
        return $color_lists;
    }

    public static function getProductImage($product_id, $color_id) {
        $images = Productimage ::where('product_id', '=', $product_id)->where('color_id', $color_id)->get()->toArray();
        return $images;
    }

    public static function colorName($color_id) {
        $colorName = Color::Select('color_name')->where('id', $color_id)->get()->toArray();
        return $colorName;
    }

    public static function sizeName($size_id) {
        $sizeName = Size::Select('size')->where('id', $size_id)->get()->toArray();
        return $sizeName;
    }
    public static function cityName($city_id) {
       $cityName = DB :: table('city')->where('id', $city_id)->first();
        return $cityName;
    }
    public static function stateName($state_id) {
       $stateName = DB :: table('state')->where('id', $state_id)->first();
        return $stateName;
    }
    
    
    public static function user_orders($order_id) {
        $orders = DB::table('orderdetails')
			->join('size', 'orderdetails.size_id', '=', 'size.id')
                        ->join('images', 'orderdetails.product_id', '=', 'images.product_id')
                        ->where('orderdetails.order_id', $order_id)
                        ->orderby('orderdetails.created_at', 'desc')
                        ->groupBy('orderdetails.id')
                        ->select('orderdetails.*', 'size.size as size', 'images.image_name as image_name')->get();
        //pr($wishlistProduts);
        return $orders;
    }
    
    public static function check_cart_stock($product_id, $color_id, $size_id, $quantity){
        $checkCountstatus = Productcolor::where('product_id', $product_id)
                        ->where('color_id', $color_id)
                        ->where('size_id', $size_id)
                    ->where('quantity', '>=', $quantity)->count();
        return $checkCountstatus;
    }

}
