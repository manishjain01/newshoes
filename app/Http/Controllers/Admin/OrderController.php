<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use URL;
use App\Http\Controllers\Controller;
use App\Order;
use App\Orderdetail;
use App\User;
use App\EmailTemplate;
use App\Helpers\EmailHelper;
Use DB;
use Validator;
use Config;
use Input;
use App\Helpers\BasicFunction;
use App\Helpers\CommonHelpers;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\PayloadFactory;
use Mail;
use Crypt;

class OrderController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $search = trim(Input::get('order_no'));
        if ($search) {
            
                    
            $orders = DB::table('orders')->select('orders.*', 'payments.txn_id as txn_id')
                                ->join('payments', 'payments.order_id', '=', 'orders.order_no')
                                ->where('orders.status', '=', 1)
                            ->where(function($query) use ($search) {
                                return $query->where('orders.order_no', 'LIKE', "%$search%")
                                        ->orwhere('orders.email', 'LIKE', "%$search%")
                                        ->orwhere('payments.txn_id', 'LIKE', "%$search%");
                            })
                            ->orderby('created_at', 'desc')->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            
            $orders = DB::table('orders')->select('orders.*', 'payments.txn_id as txn_id')
                                ->join('payments', 'payments.order_id', '=', 'orders.order_no')
                                ->where('orders.status', '=', 1)
                    ->orderby('orders.created_at', 'desc')
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
            //pr($orders);exit;
        }

        $user = User::where('role_id', '!=', Config::get('global.role_id.admin'))->get();
        $pageTitle = "Orders";
        $title = trans('admin.USERS');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' => 'Orders List', 'active' =>'admin.orders');




        //setCurrentPage('admin.orders');

        return view('admin.orders.index', compact('pageTitle', 'orders', 'title', 'breadcrumb'));
    }

    public function viewOrder($order_no) {
        $orderDetail = Order::where('order_no', '=', $order_no)->where('status', '=', 1)->first();
        if (isset($orderDetail->state) && !empty($orderDetail->state)) {
            $state_name = DB :: table('state')->where('country', 101)->where('id', $orderDetail->state)->first();
        } else {
            $state_name = "";
        }
        //pr($state_name);exit;
        if (isset($orderDetail->city) && !empty($orderDetail->city)) {
            $city_name = DB :: table('city')->where('state', $orderDetail->city)->first();
        } else {
            $city_name = "";
        }
        //pr($orderDetail);exit;		
        $order_id = $orderDetail->id;

        $orderProducts = DB::table('orderdetails')->where('order_id', '=', $order_id)->get();
        $paymentss = DB::table('payments')->where('order_id', '=', $order_no)->first();

        //pr($paymentss);exit;

        $pageTitle = "Order View";
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' => 'View Order', 'active' =>'admin.orders.index');

        return view('admin.orders.view', compact('paymentss','pageTitle', 'orderDetail', 'orderProducts', 'breadcrumb','state_name','city_name'));
    }

    public function create() {
        $pageTitle = trans('admin.ADD_USER');
        $title = trans('admin.ADD_USER');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.users.index';


        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.ADD_USER'), 'active' =>'admin.orders.index');

        return view('admin.users.create', compact('pageTitle', 'title', 'breadcrumb'));
    }

    public function show($id) {
        //$user = User::find($id);
    }

    public function destroy($id) {
        $user = User::find($id)->delete();
        return redirect()->action('Admin\UsersController@index');
    }

    function resetPassword($email_token = null) {
        if ($email_token == null) {
            return redirect()->action('Admin\AuthController@getLogin');
        }
        $user = User::where('email_token', '=', $email_token)->where('role_id', '=', 1)->first();

        if (empty($user->id)) {
            return redirect()->action('Admin\AuthController@getLogin');
        }
        $pageTitle = trans('admin.RESET_PASSWORD');
        $title = trans('admin.RESET_PASSWORD');
        return view('admin.users.reset_password', compact('pageTitle', 'title', 'email_token'));
    }

    /**
     * Update logged user (admin) profile 
     *
     */
    public function profile() {
        $admin = adminUser();
        $user = User::find($admin->id);

        $pageTitle = trans('admin.MY_PROFILE');
        $title = trans('admin.MY_PROFILE');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';

        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.MY_PROFILE'), 'active' =>'admin.orders.index');
        return view('admin.users.profile', compact('user', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Update logged user (admin) profile 
     *
     */
    public function ChangePassword() {

        $pageTitle = trans('admin.CHANGE_PASSWORD');
        $title = trans('admin.CHANGE_PASSWORD');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.MY_PROFILE')] = 'admin.profile';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.CHANGE_PASSWORD'));
        return view('admin.users.change_password', compact('pageTitle', 'title', 'breadcrumb'));
    }

    public function UpdateChangePassword(Request $request) {
        # code...
        $admin = adminUser();
        $validator = validator::make($request->all(), [
                    'old_password' => 'required|OldPasswordCheck:' . $admin->password,
                    'new_password' => 'required|ValidPassword|min:6',
                    'confirm_password' => 'required|ValidPassword|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\UsersController@ChangePassword')
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $request->all();
        $password = Hash::make($request->new_password);
        $is_update = User::where('id', $admin->id)
                ->update(['password' => $password]);
        return redirect()->action('Admin\AuthController@getLogout')->with('alert-sucess', trans('admin.PASSWORD_CHANGE_SUCCESS'));
    }

    /**
     * Update user profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request) {
        $admin = adminUser();

        $validator = validator::make($request->all(), [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\UsersController@profile')
                            ->withErrors($validator)
                            ->withInput();
        }
        $user = User::findOrFail($admin->id);
        $input = $request->all();
        $user->fill($input)->save();
        return redirect()->action('Admin\PagesController@index')->with('alert-sucess', trans('admin.MY_PROFILE_UPDATE_SUCCESS'));
    }

    /**
     * Function To chnage Status of USer
     *
     * @param  int  $id id of user
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
        $user = User::where('id', '=', $id)->first();
        $user->status = $new_status;
        $user->save();
        return redirect()->back()->with('alert-sucess', trans('admin.USER_CHANGE_STATUS_SUCCESSFULLY'));
    }

    public function updateOrder(Request $request, $id) {
        $input = $request->all();        
        $order_id = $input['order_id'];
        $order_status = $input['order_status'];

        
        //pr($orders);exit;
        $is_update = Order::where('id', $id)
                ->update(['order_status' => $order_status]);
        if($is_update){
           $orders = Order::where('id', $id)->first(); 
           $orderDetails = Orderdetail::where('order_no', $orders->order_no)->get();
           $prorow = array();
            foreach($orderDetails as $orderDetail){                
                $sizeName = CommonHelpers::sizeName($orderDetail->size_id);
                $colorName = CommonHelpers::colorName($orderDetail->color_id); 
                $gross_price = ($orderDetail->discount + $orderDetail->unit_price)*$orderDetail->quantity;
                $prorow[] = '<tr><td>'.$orderDetail->product_name.'</td><td>'.$orderDetail->quantity.'</td><td>'.$gross_price.'</td><td>'.$colorName[0]['color_name'].'</td><td>'.$sizeName[0]['size'].'</td><td>'.$orderDetail->discount*$orderDetail->quantity.'</td><td>'.$orderDetail->unit_price*$orderDetail->quantity.'</td></tr>';
            }
            $state = DB :: table('state')->where('id', $orders->state)->first();
            $city = DB :: table('city')->where('id', $orders->city)->first(); 
            
            
            $this->order_invoice($orders->first_name,$orders->last_name,$orders->email,$orders->shipping_amount,$prorow,$orders->order_no,$orders->pay_mode,$orders->item_total_amount,$orders->address_1,$orders->address_2,$orders->pincode,$city->city_name,$state->state_name,$orders->order_status,$orders->discount);
            
        
        }
        return redirect()->back()->with('alert-sucess', 'Order Status Change Successfully');
    }
    
    public function order_invoice($first_name, $last_name, $email, $shipping_amount, $prorow, $order_no, $payment_status, $total,$address_1,$address_2,$pincode,$city,$state,$order_status,$discount)
    {
        $amount_paid = $total+$shipping_amount;
        $tablehead = '<table border="1">
	<thead>
		<tr>
			<th>Product Name</th>
			<th>Product Quantity</th>
			<th>Gross Amount</th>
			<th>Product Color</th>
			<th>Product Size</th>
                        <th>Product Discount</th>
                        <th>Total Amount</th>
		</tr>
	</thead>
	<tbody>';
        $tbalefooter = '</tbody>
	<tfoot>
                
		<tr>
			<td colspan="6">Shipping Charge:-</td>
			<td>'.$shipping_amount.'</td>
		</tr>
		<tr>
			<td colspan="6">Amount to paid:-</td>
			<td>'.$amount_paid.'</td>
		</tr>
	</tfoot>
</table>';
        $prorows = $tablehead.implode('<br/>', $prorow).$tbalefooter;
       
        //echo $prorows;
        //pr($prorow);
        //exit;
            $from = "info@pepealoans.com";
            $to = $email;
            $email_template = EmailTemplate::where('slug', '=', 'order-status')->first();
            $email_type = $email_template->email_type;
            $subject = $email_template->subject;
            $body = $email_template->body;
            $to = $email;
            
    $body = str_replace(array(
                '{FIRST_NAME}',
                '{LAST_NAME}',
                '{SHIPPING_CHARGE}',
                '{PRO_ROWS}',
                '{ORDER_NO}',
                '{TOTAL}',
                '{ORDER_STATUS}',
                '{ADDRESS}',
                '{PINCODE}',
                '{CITY}',
                '{STATE}',
                    ), array(
                ucfirst($first_name),
                ucfirst($last_name),
                $shipping_amount,
                $prorows,
                $order_no,
                $total,
                $order_status,
                $address_1.', '.$address_2,
                $pincode,
                $city,
                $state
                    ), $body);
            $subject = str_replace(array(
                '{FIRST_NAME}',
                '{LAST_NAME}',
                '{SHIPPING_CHARGE}',
                '{PRO_ROWS}',
                '{ORDER_NO}',
                '{TOTAL}',
                '{ORDER_STATUS}',
                '{ADDRESS}',
                '{PINCODE}',
                '{CITY}',
                '{STATE}',
                    ), array(
                ucfirst($first_name),
                ucfirst($last_name),
                $shipping_amount,
                $prorows,
                $order_no,
                $total,
                $order_status,
                $address_1.', '.$address_2,
                $pincode,
                $city,
                $state
                    ), $subject);
//pr($body);exit;
            EmailHelper::sendMail($to, $from, '', $subject, 'default', $body, $email_type);
}
 

}
