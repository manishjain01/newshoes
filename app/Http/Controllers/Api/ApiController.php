<?php

namespace App\Http\Controllers\api;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use URL;
use App\Http\Controllers\Controller;
use App\User;
use App\Product;
Use DB;
use Validator;
use Config;
use Input;
use App\Helpers\BasicFunction;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\MembershipPlansController;

class ApiController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $input = $request->all();
        //pr($input);die;
        //echo json_decode($input['request']);die;
        //$requestobj = (array)json_decode(base64_decode($input['request']));
        $requestobj = (array) json_decode($input['request']);
        //pr($requestobj);die;
        try {

            if (strtolower($requestobj['method']) == "login") {
                $user = new UsersController;
                return $user->login($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "forgot_password") {
                $user = new UsersController;
                return $user->forgot_password($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "register") {
                if (!empty($input['profile_img'])) {
                    $file = $input['profile_img'];
                } else {
                    $file = "";
                }
                $user = new UsersController;
                return $user->register($requestobj['data'],$file);
            } elseif (strtolower($requestobj['method']) == "api_logout") {
                //  pr($requestobj);die;  
                $contactus = new UsersController;
                return $contactus->api_logout($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "update_profile") {
                if (!empty($input['profile_img'])) {
                    $file = $input['profile_img'];
                } else {
                    $file = "";
                }
                $user = new UsersController;
                return $user->update_profile($requestobj['data'],$file);
            } elseif (strtolower($requestobj['method']) == "user_profile") {
                $users = new UsersController;
                return $users->user_profile($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "plan_list") {
                $plan = new MembershipPlansController;
                return $plan->plan_list($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "gender_category") {
                $plan = new MembershipPlansController;
                return $plan->gender_category($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "allproduct_list") {
                $product = new ProductsController;
                return $product->allproduct_list($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "product_detail") {
                $product = new ProductsController;
                return $product->product_detail($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "product_listbyseller") {
                $products = new ProductsController;
                return $products->product_listBySeller($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "addwhishlist") {
                $products = new ProductsController;
                return $products->addwhishlist($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "addcontact") {
                $products = new ProductsController;
                return $products->addcontact($requestobj['data']);
            } elseif (strtolower($requestobj['method']) == "body_detail") {
                $products = new ProductsController;
                return $products->body_detail($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "add_review_byseller") {
                $products = new ProductsController;
                return $products->add_review_byseller($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "add_review_bybuyer") {
                $products = new ProductsController;
                return $products->add_review_bybuyer($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "product_review") {
                $products = new ProductsController;
                return $products->product_review($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "wishlist_detail") {
                $products = new ProductsController;
                return $products->wishlist_detail($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "delete_wishlist") {
                $products = new ProductsController;
                return $products->delete_wishlist($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "wishlist_count") {
                $products = new ProductsController;
                return $products->wishlist_count($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "buyer_list") {
                $products = new ProductsController;
                return $products->buyer_list($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "seller_pstatus") {
                $products = new ProductsController;
                return $products->seller_pstatus($requestobj['data']);
            }
            elseif (strtolower($requestobj['method']) == "api_deleteproduct") {
                $products = new ProductsController;
                return $products->api_deleteproduct($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "api_removeproductimg") {
                $products = new ProductsController;
                return $products->api_removeproductimg($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "upgrade_profile") {
                $users = new UsersController;
                return $users->upgrade_profile($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "upgrade_token") {
                $users = new UsersController;
                return $users->upgrade_token($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "buyer_review_detail") {
                $products = new ProductsController;
                return $products->buyer_review_detail($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "postcomment_bybuyer") {
                $products = new ProductsController;
                return $products->postcomment_bybuyer($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "review_detail_seller") {
                $products = new ProductsController;
                return $products->review_detail_seller($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "postcomment_byseller") {
                $products = new ProductsController;
                return $products->postcomment_byseller($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "product_list_contactproduct") {
                $products = new ProductsController;
                return $products->product_list_contactproduct($requestobj['data']);
            }
            elseif (strtolower($requestobj['method']) == "buyer_notification") {
                $products = new ProductsController;
                return $products->buyer_notification($requestobj['data']);
            }
            elseif (strtolower($requestobj['method']) == "seller_notification") {
                $products = new ProductsController;
                return $products->seller_notification($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "nearby_product") {
                $products = new ProductsController;
                return $products->nearby_product($requestobj['data']);
            }
            elseif (strtolower($requestobj['method']) == "notification_send") {
                $products = new ProductsController;
                return $products->notification_send($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "get_token") {
                $products = new MembershipPlansController;
                return $products->get_token($requestobj['data']);
            }elseif (strtolower($requestobj['method']) == "api_addimage") {
                $file1 = "";              
                if (!empty($input['profile_img1'])) {
                    $file1 = $input['profile_img1'];                    
                }
                $prduct = new ProductsController;
                return $prduct->api_addimage($requestobj['data'], $file1);
            }elseif (strtolower($requestobj['method']) == "api_addproduct") {
                $file1 = "";
                /*$file2 = "";
                $file3 = "";
                $file4 = "";
                $file5 = "";*/
                if (!empty($input['profile_img1'])) {
                    $file1 = $input['profile_img1'];                    
                }
                /*if (!empty($input['profile_img2'])) {
                    $file2 = $input['profile_img2'];
                }
                if (!empty($input['profile_img3'])) {
                    $file3 = $input['profile_img3'];
                }
                if (!empty($input['profile_img4'])) {
                    $file4 = $input['profile_img4'];
                }
                if (!empty($input['profile_img5'])) {
                    $file5 = $input['profile_img5'];
                }*/

                $prduct = new ProductsController;
                return $prduct->api_addproduct($requestobj['data'], $file1);
            }elseif (strtolower($requestobj['method']) == "api_updateproduct") {
                //$file1 = "";
                /*$file2 = "";
                $file3 = "";
                $file4 = "";
                $file5 = "";*/
                /*if (!empty($input['profile_img1'])) {
                    $file1 = $input['profile_img1'];
                }
                if (!empty($input['profile_img2'])) {
                    $file2 = $input['profile_img2'];
                }
                if (!empty($input['profile_img3'])) {
                    $file3 = $input['profile_img3'];
                }
                if (!empty($input['profile_img4'])) {
                    $file4 = $input['profile_img4'];
                }
                if (!empty($input['profile_img5'])) {
                    $file5 = $input['profile_img5'];
                }*/

                $prduct = new ProductsController;
                return $prduct->api_updateproduct($requestobj['data']);
            } else {
                try {
                    
                } catch (Exception $e) {

                    if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {

                        return json_encode(['status' => 'fail', 'error' => 'Token is Invalid']);
                    } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {

                        return json_encode(['status' => 'fail', 'error' => 'Token is Expired']);
                    } else {

                        return json_encode(['status' => 'fail', 'error' => 'Something is wrong']);
                    }
                }
            }
        } catch (Exception $e) {

            return Response::json(['status' => 'fail', 'message' => 'Wrong json formate.'], HttpResponse::HTTP_CONFLICT);
        }
    }

}
