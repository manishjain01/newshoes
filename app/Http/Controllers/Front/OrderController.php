<?php

namespace App\Http\Controllers\Front;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use URL;
use App\Http\Controllers\Controller;
use App\User;
use App\Product;
use App\Color;
use App\Cart;
use App\Order;
use App\Review;
use App\Wishlist;
use App\Orderdetail;
use App\Payments;
use App\Country;
use App\Productcolor;
use App\Reviews;
use App\Category;
use App\EmailTemplate;
use App\Helpers\EmailHelper;
use App\Helpers\CommonHelpers;
use Intervention\Image\ImageManagerStatic as Image;
Use DB;
use Validator;
use Config;
use Input;
use App\Helpers\BasicFunction;
use Mail;
use Crypt;
use Illuminate\Support\Facades\Auth;
use Session;
use File;
use PaytmWallet;
use Softon\Indipay\Facades\Indipay;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
//use PayPal\Api\OAuthTokenCredential;
//use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalInvalidCredentialException;

class OrderController extends Controller
{
    
    /*public function handle($request, Closure $next)
    {
        if($request->input('_token')) {
            if ( \Session::getToken() != $request->input('_token')) {
                   dd(\Session::getToken() == $request->input('_token'));
                \Log::error("Expired token found. Redirecting to /");
                return redirect()->guest('/');
            }
        }

        return parent::handle($request, $next);
    }*/
    
    /*private $_api_context;    
    public function __construct() {
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'], $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }*/

    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    /*public function order()
    {
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => $order->id,
          'user' => $user->id,
          'mobile_number' => $user->phonenumber,
          'email' => $user->email,
          'amount' => $order->amount,
          'callback_url' => 'http://example.com/payment/status'
        ]);
        return $payment->receive();
    }*/

    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        $status = PaytmWallet::with('status');
        $status->prepare(['order' => $transaction->response()['ORDERID']]);
        
        
        $response = $transaction->response();
         $order_id = $transaction->getOrderId();
         //pr($response);exit;
         $prorow = array();
         if($transaction->response()){
             $txnmsg = "";
             $orderDetails = Orderdetail::where('order_no', $transaction->response()['ORDERID'])->get();
             if($transaction->response()['STATUS'] == 'TXN_FAILURE'){
               $txnmsg =  'Failure';
               foreach($orderDetails as $orderDetail){
                $is_update = Productcolor::where('product_id', $orderDetail->product_id)
                        ->where('color_id', $orderDetail->color_id)
                        ->where('size_id', $orderDetail->size_id)
                    ->increment('quantity', $orderDetail->quantity);
                
               }
             }else if($transaction->response()['STATUS'] == 'TXN_SUCCESS'){
               $txnmsg =  'Complete';
               
            foreach($orderDetails as $orderDetail){
                /*$is_update = Productcolor::where('product_id', $orderDetail->product_id)
                        ->where('color_id', $orderDetail->color_id)
                        ->where('size_id', $orderDetail->size_id)
                    ->decrement('quantity', $orderDetail->quantity);*/
                $sizeName = CommonHelpers::sizeName($orderDetail->size_id);
                $colorName = CommonHelpers::colorName($orderDetail->color_id); 
                $gross_price = ($orderDetail->discount + $orderDetail->unit_price)*$orderDetail->quantity;
                $prorow[] = '<tr><td>'.$orderDetail->product_name.'</td><td>'.$orderDetail->quantity.'</td><td>'.$gross_price.'</td><td>'.$colorName[0]['color_name'].'</td><td>'.$sizeName[0]['size'].'</td><td>'.$orderDetail->discount*$orderDetail->quantity.'</td><td>'.$orderDetail->unit_price*$orderDetail->quantity.'</td></tr>';
              }
             $session_id = session()->getId();
         if (Auth::check()) {
             $auth = LoginUser();
        $carts = Cart::where('user_id', $auth->id)->delete();
         }else{
             $carts = Cart::where('session_id', $session_id)->delete();
         }
            $orders = Order::where('order_no', $transaction->response()['ORDERID'])->first();
            $state = DB :: table('state')->where('id', $orders->state)->first();
            $city = DB :: table('city')->where('id', $orders->city)->first();
            
            $this->invoice($orders->first_name,$orders->last_name,$orders->email,$orders->shipping_amount,$prorow,$orders->order_no,$txnmsg,$orders->item_total_amount,$orders->address_1,$orders->address_2,$orders->pincode,$city->city_name,$state->state_name,$orders->pay_mode,$orders->discount);
            
             }
             $is_update = Order::where('order_no', $transaction->response()['ORDERID'])
                    ->update(['payment_status'=>$txnmsg]);
             
            $payment_data['order_id'] = $transaction->response()['ORDERID'];
            $payment_data['merchant_id'] = $transaction->response()['MID'];
            $payment_data['txn_id'] = $transaction->response()['TXNID'];
            $payment_data['amount'] = $transaction->response()['TXNAMOUNT'];
            $payment_data['currency'] = $transaction->response()['CURRENCY'];
            if(isset($transaction->response()['TXNDATE'])){
            $payment_data['txn_date'] = $transaction->response()['TXNDATE'];
            }
            $payment_data['status'] = $transaction->response()['STATUS'];
            $payment_data['responce_msg'] = $transaction->response()['RESPMSG'];
            if(isset($transaction->response()['BANKNAME'])){
            $payment_data['bank_name'] = $transaction->response()['BANKNAME'];
            }
            $payment_data['bank_txn'] = $transaction->response()['BANKTXNID'];
            if(isset($transaction->response()['GATEWAYNAME'])){
            $payment_data['gateway_name'] = $transaction->response()['GATEWAYNAME'];
            }
            $payment_data['payment_mode'] = 'paytm';
            $pay_data = Payments::create($payment_data);
            $pay_data->fill($payment_data)->save();
            
            
         }
         //pr($pay_data);exit;
         if($pay_data->responce_msg == 'Txn Success'){
            $msg1 = 'Transaction successfully completed!';
         }else{
            $msg1 = str_replace('User has not completed', 'You have cancelled the', $pay_data->responce_msg).'  Your Order Id is:- '.$pay_data->order_id; 
         }
         $str = $msg1.' <br />  Your Transaction Id is:- '.$pay_data->txn_id;
         return redirect()->action('Front\OrderController@paytm_mst', $pay_data->order_id)->with('alert-sucess', $str);
         //return view('front.payments.paytm_success', compact('pay_data'));
        /*if($transaction->isSuccessful()){
          //EventRegistration::where('order_id',$order_id)->update(['status'=>2, 'transaction_id'=>$transaction->getTransactionId()]);
          Cart::where('id','=', 2)->update(['product_name'=>2]);  
          dd('Payment Successfully Paid.');
        }else if($transaction->isFailed()){
          //EventRegistration::where('order_id',$order_id)->update(['status'=>1, 'transaction_id'=>$transaction->getTransactionId()]);
         Cart::where('id','=', 2)->update(['product_name'=>1]); 
         dd('Payment Failed.');
        }*/
    }  
    
    /**
    * Obtain the transaction status/information.
    *
    * @return Object
    */
    public function statusCheck(){
        $status = PaytmWallet::with('status'); 
        $status->prepare(['order' => '4446546546545']);
        $status->check();
        
        $response = $status->response(); // To get raw response as object
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=txn-status-api-description
        
        if($status->isSuccessful()){
          //Transaction Successful
        }else if($status->isFailed()){
          //Transaction Failed
        }else if($status->isOpen()){
          //Transaction Open/Processing
        }
        $status->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $status->getOrderId(); // Get order id
        $status->getTransactionId(); // Get transaction id
    }
    
    /**
    * Initiate refund.
    *
    * @return Object
    */
    public function refund(){
        $refund = PaytmWallet::with('refund');
        $refund->prepare([
            'order' => $order->id,
            'reference' => "refund-order-4", // provide refund reference for your future reference (should be unique for each order)
            'amount' => 300, // refund amount 
            'transaction' => $order->transaction_id // provide paytm transaction id referring to this order 
        ]);
        $refund->initiate();
        $response = $refund->response(); // To get raw response as object
        
        if($refund->isSuccessful()){
          //Refund Successful
        }else if($refund->isFailed()){
          //Refund Failed
        }else if($refund->isOpen()){
          //Refund Open/Processing
        }else if($refund->isPending()){
          //Refund Pending
        }
    }
    
    /**
    * Initiate refund.
    *
    * @return Object
    */
    public function refund1(){
        $refundStatus = PaytmWallet::with('refund_status');
        $refundStatus->prepare([
            'order' => $order->id,
            'reference' => "refund-order-4", // provide reference number (the same which you have entered for initiating refund)
        ]);
        $refundStatus->check();
        
        $response = $refundStatus->response(); // To get raw response as object
        
        if($refundStatus->isSuccessful()){
          //Refund Successful
        }else if($refundStatus->isFailed()){
          //Refund Failed
        }else if($refundStatus->isOpen()){
          //Refund Open/Processing
        }else if($refundStatus->isPending()){
          //Refund Pending
        }
    }
    
     /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function invoice($first_name, $last_name, $email, $shipping_amount, $prorow, $order_no, $payment_status, $total,$address_1,$address_2,$pincode,$city,$state,$pay_mode,$discount)
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
            $email_template = EmailTemplate::where('slug', '=', 'order-invoice')->first();
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
                '{PAYMENT_MOD}',
                '{PAYMENT_STATUS}',
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
                $pay_mode,
                $payment_status,
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
                '{PAYMENT_MOD}',
                '{PAYMENT_STATUS}',
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
                $pay_mode,
                $payment_status,
                $address_1.', '.$address_2,
                $pincode,
                $city,
                $state
                    ), $subject);
//pr($body);exit;
            EmailHelper::sendMail($to, $from, '', $subject, 'default', $body, $email_type);
}
    public function order(Request $request)
    {
        $input = $request->all(); //pr($input);exit;
        
        //pr($productInfo);
        //pr($orderDetails);exit;
        $orders = Order::where('order_no', $input['order_no'])->first();
        //pr($orders);exit;
        $session_id = session()->getId();
         /*if (Auth::check()) {
             $auth = LoginUser();
        $carts = Cart::where('user_id', $auth->id)->delete();
         }else{
             $carts = Cart::where('session_id', $session_id)->delete();
         }*/
        /*if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }*/
         $orderDetails = Orderdetail::where('order_no', $input['order_no'])->get();
         foreach($orderDetails as $orderDetail){
                $is_update = Productcolor::where('product_id', $orderDetail->product_id)
                        ->where('color_id', $orderDetail->color_id)
                        ->where('size_id', $orderDetail->size_id)
                    ->decrement('quantity', $orderDetail->quantity);
                
               }
        if($input['pay_mode'] == 'cod'){
            Session::forget('ORDER_NO');
           $is_update = Order::where('order_no', $input['order_no'])
                    ->update(['status'=>1,'pay_mode'=>'cod']); 
           $orderDetails = Orderdetail::where('order_no', $input['order_no'])->get();
           $prorow = array();
            foreach($orderDetails as $orderDetail){
                $is_update = Productcolor::where('product_id', $orderDetail->product_id)
                        ->where('color_id', $orderDetail->color_id)
                        ->where('size_id', $orderDetail->size_id)
                    ->decrement('quantity', $orderDetail->quantity);
                $sizeName = CommonHelpers::sizeName($orderDetail->size_id);
                $colorName = CommonHelpers::colorName($orderDetail->color_id); 
                $gross_price = ($orderDetail->discount + $orderDetail->unit_price)*$orderDetail->quantity;
                $prorow[] = '<tr><td>'.$orderDetail->product_name.'</td><td>'.$orderDetail->quantity.'</td><td>'.$gross_price.'</td><td>'.$colorName[0]['color_name'].'</td><td>'.$sizeName[0]['size'].'</td><td>'.$orderDetail->discount*$orderDetail->quantity.'</td><td>'.$orderDetail->unit_price*$orderDetail->quantity.'</td></tr>';
            }
            $state = DB :: table('state')->where('id', $orders->state)->first();
            $city = DB :: table('city')->where('id', $orders->city)->first();    
            //pr($input);exit;
            $this->invoice($orders->first_name,$orders->last_name,$orders->email,$orders->shipping_amount,$prorow,$orders->order_no,$orders->payment_status,$orders->item_total_amount,$orders->address_1,$orders->address_2,$orders->pincode,$city->city_name,$state->state_name,$orders->pay_mode,$orders->discount);
           return view('front.payments.success', compact('input'));
        }else if($input['pay_mode'] == 'paytm'){ 
            Session::forget('ORDER_NO');
            $is_update = Order::where('order_no', $input['order_no'])
                    ->update(['status'=>1,'pay_mode'=>'paytm']);
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => $input['order_no'],
          'user' => $input['order_no'],
          'mobile_number' => $orders->phone,
          'email' => $orders->email,
          //'amount' => '1',
          'amount' => $input['checkout_amount'],
          'callback_url' => url('payment/status')
        ]);
        //pr($payment);exit;
        return $payment->receive();
        
        }else if($input['pay_mode'] == 'payumoney'){ 
            Session::forget('ORDER_NO');
            $is_update = Order::where('order_no', $input['order_no'])
                    ->update(['status'=>1,'shipping_amount'=>'0.00','pay_mode'=>'payumoney']);
            $parameters = [      
        'tid' => substr(hash('sha256', mt_rand() . microtime()), 0, 20),        
        'order_id' =>$input['order_no'],
        'phone' => $orders->phone,
        'email' => $orders->email,
        'firstname' => $orders->first_name,
        'productinfo' => $input['order_no'],
        'amount' =>$input['checkout_amount'],
        'udf1' =>CURRENCY,
      ];
      
      // gateway = CCAvenue / PayUMoney / EBS / Citrus / InstaMojo / ZapakPay / Mocker
      
      $order = Indipay::gateway('PayUMoney')->prepare($parameters);
      //pr($order);exit;
      return Indipay::process($order);
        }else if($input['pay_mode'] == 'paypal'){
            $is_update = Order::where('order_no', $input['order_no'])
                    ->update(['status'=>1,'shipping_amount'=>'0.00','pay_mode'=>'paypal']);
            return redirect()->action('Front\OrderController@paypal');
            //echo $input['pay_mode'];exit;
            /*$payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $item_1 = new Item();
            $item_1->setName('Item 1') 
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($request->get('amount'));
            $item_list = new ItemList();
            $item_list->setItems(array($item_1));
            $amount = new Amount();
            $amount->setCurrency('USD')
                    ->setTotal($request->get('amount'));
            $transaction = new Transaction();
            $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Your transaction description');
            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(URL('status')) 
                    ->setCancelUrl(URL('status'));
            $payment = new Payment();
            $payment->setIntent('Sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
          
            try {
                $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
                if (\Config::get('app.debug')) {
                    \Session::put('error', 'Connection timeout');
                    return Redirect::route('paywithpaypal');
                } else {
                    \Session::put('error', 'Some error occur, sorry for inconvenient');
                    //return Redirect::route('paywithpaypal');
                }
            }
            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            
            Session::put('paypal_payment_id', $payment->getId());
            if (isset($redirect_url)) {
               
                return Redirect::away($redirect_url);
            }
            \Session::put('error', 'Unknown error occurred');
            return Redirect::route('paywithpaypal');*/
        }else{
            echo $input['pay_mode'];exit;
        }
        //return $payment->view('front.payments.payment')->receive();
    }
    
    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
 
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
 
            \Session::put('error', 'Payment failed');
            return Redirect::route('/');
 
        }
 
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
 
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
 
        if ($result->getState() == 'approved') {
 
            \Session::put('success', 'Payment success');
            return Redirect::route('/');
 
        }
 
        \Session::put('error', 'Payment failed');
        return Redirect::route('/');
 
    } 
    public function order_list()
    {
        $auth = LoginUser();
        $title = 'Order List';        
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }
        
       $orderLists = Order::with('order_detail')->where('user_id', $auth->id)                           
                            ->where('status', 1)
                            ->where('payment_status', '!=', 'Failure')                          
                            ->sortable(['created_at' => 'desc'])
                            ->paginate('10');
       //pr($orderLists);exit;
        //$user = DB::table('users')
                 //->where('id', '=', $auth->id)->get();
        $pages[trans('admin.MY_PROFILE')] = 'admin.profile';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.CHANGE_PASSWORD'));        
        return view('front.users.order_list', compact('pages', 'breadcrumb','title','orderLists','auth'));      
    }
    
    public function response(Request $request)
    
    { //pr($request);exit;
        // For default Gateway
        //$response = Indipay::response($request);
        
        
        
        // For Otherthan Default Gateway
        $response = Indipay::gateway('PayUMoney')->response($request);

        dd($response);
    
    }  
    
     public function paypal() {
         
         $auth = LoginUser();
         if (Auth::check()) {
            $user_id =  $auth->id;
         }else{
             $user_id =  0;
         }
         /*if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }*/
        $session_order_no = Session::get('ORDER_NO');
         $orders = Order::where('user_id', $user_id)
                        ->where('order_no', $session_order_no)
                        ->where('status', 1)                           
                         ->orderby('created_at', 'desc')->first();
         $orderDetails = Orderdetail::where('order_no', $session_order_no)->get();
         $i = 0;
         $datas = array();
            foreach($orderDetails as $orderDetail){
              $datas[$i]['product_id'] = $orderDetail->product_id;
              $datas[$i]['color_id'] = $orderDetail->color_id;
              $datas[$i]['size_id'] = $orderDetail->size_id;
              $datas[$i]['quantity'] = $orderDetail->quantity;
              $i++;
                $sizeName = CommonHelpers::sizeName($orderDetail->size_id);
                $colorName = CommonHelpers::colorName($orderDetail->color_id); 
                $gross_price = ($orderDetail->discount + $orderDetail->unit_price)*$orderDetail->quantity;
                $prorow[] = '<tr><td>'.$orderDetail->product_name.'</td><td>'.$orderDetail->quantity.'</td><td>'.$gross_price.'</td><td>'.$colorName[0]['color_name'].'</td><td>'.$sizeName[0]['size'].'</td><td>'.$orderDetail->discount*$orderDetail->quantity.'</td><td>'.$orderDetail->unit_price*$orderDetail->quantity.'</td></tr>';
            }
            //pr($orders);exit;
            $state = DB :: table('state')->where('id', $orders->state)->first();
            $city = DB :: table('city')->where('id', $orders->city)->first();
            
            $this->invoice($orders->first_name,$orders->last_name,$orders->email,$orders->shipping_amount,$prorow,$orders->order_no,$orders->payment_status,$orders->item_total_amount,$orders->address_1,$orders->address_2,$orders->pincode,$city->city_name,$state->state_name,$orders->pay_mode,$orders->discount);
            $datas = json_encode($datas);
         Session::forget('ORDER_NO');
         return view('front.payments.paypal', compact('orders','datas'));
     }
     
      public function payusuccess(Request $request) {
        $transaction = Indipay::gateway('PayUMoney')->response($request);
           //pr($transaction);exit;
           if($transaction){
               $prorow = array();
            $orderDetails = Orderdetail::where('order_no', $transaction['productinfo'])->get();
            foreach($orderDetails as $orderDetail){
                $is_update = Productcolor::where('product_id', $orderDetail->product_id)
                        ->where('color_id', $orderDetail->color_id)
                        ->where('size_id', $orderDetail->size_id)
                    ->decrement('quantity', $orderDetail->quantity);
                $sizeName = CommonHelpers::sizeName($orderDetail->size_id);
                $colorName = CommonHelpers::colorName($orderDetail->color_id); 
                $gross_price = ($orderDetail->discount + $orderDetail->unit_price)*$orderDetail->quantity;
                $prorow[] = '<tr><td>'.$orderDetail->product_name.'</td><td>'.$orderDetail->quantity.'</td><td>'.$gross_price.'</td><td>'.$colorName[0]['color_name'].'</td><td>'.$sizeName[0]['size'].'</td><td>'.$orderDetail->discount*$orderDetail->quantity.'</td><td>'.$orderDetail->unit_price*$orderDetail->quantity.'</td></tr>';
            }
            //pr($input);exit;
            
        
             $is_update = Order::where('order_no', $transaction['productinfo'])
                    ->update(['payment_status'=>'Complete']);
             
            $payment_data['order_id'] = $transaction['productinfo'];
            $payment_data['merchant_id'] = $transaction['key'];
            $payment_data['txn_id'] = $transaction['txnid'];
            $payment_data['amount'] = $transaction['amount'];
            $payment_data['currency'] = $transaction['udf1'];
            $payment_data['txn_date'] = $transaction['addedon'];
            $payment_data['status'] = $transaction['status'];
            if($transaction['error_Message'] == 'No Error'){
            $payment_data['responce_msg'] = $transaction['field9'];
            }else{
               $payment_data['responce_msg'] = $transaction['error_Message']; 
            }
           
            $payment_data['bank_name'] = $transaction['PG_TYPE'];
           
            $payment_data['bank_txn'] = $transaction['bank_ref_num'];
            if(!empty($transaction['cardnum'])){
            $payment_data['gateway_name'] = $transaction['cardnum'];
            }
            $payment_data['payment_mode'] = 'payumoney';
            $pay_data = Payments::create($payment_data);
            $pay_data->fill($payment_data)->save();
            
            $orders = Order::where('order_no', $transaction['productinfo'])->first();
            //pr($orders);exit;
            $state = DB :: table('state')->where('id', $orders->state)->first();
            $city = DB :: table('city')->where('id', $orders->city)->first();
            
            $this->invoice($orders->first_name,$orders->last_name,$orders->email,$orders->shipping_amount,$prorow,$orders->order_no,$orders->payment_status,$orders->item_total_amount,$orders->address_1,$orders->address_2,$orders->pincode,$city->city_name,$state->state_name,$orders->pay_mode,$orders->discount);
         }
         return view('front.payments.payu_success', compact('pay_data'));
     }
     
      public function payufail(Request $request) {
           $transaction = Indipay::gateway('PayUMoney')->response($request);
           //pr($transaction);exit;
           if($transaction){
            /*$orderDetails = Orderdetail::where('order_no', $transaction['ORDERID'])->get();
            foreach($orderDetails as $orderDetail){
                $is_update = Productcolor::where('product_id', $orderDetail->product_id)
                        ->where('color_id', $orderDetail->color_id)
                        ->where('size_id', $orderDetail->size_id)
                    ->decrement('quantity', $orderDetail->quantity);
            }*/
        
             $is_update = Order::where('order_no', $transaction['productinfo'])
                    ->update(['payment_status'=>'Failure']);
             
            $payment_data['order_id'] = $transaction['productinfo'];
            $payment_data['merchant_id'] = $transaction['key'];
            $payment_data['txn_id'] = $transaction['txnid'];
            $payment_data['amount'] = $transaction['amount'];
            $payment_data['currency'] = $transaction['udf1'];
            $payment_data['txn_date'] = $transaction['addedon'];
            $payment_data['status'] = $transaction['status'];
            if($transaction['error_Message'] == 'No Error'){
            $payment_data['responce_msg'] = $transaction['field9'];
            }else{
               $payment_data['responce_msg'] = $transaction['error_Message']; 
            }
           
            $payment_data['bank_name'] = $transaction['PG_TYPE'];
           
            $payment_data['bank_txn'] = $transaction['bank_ref_num'];
            if(!empty($transaction['cardnum'])){
            $payment_data['gateway_name'] = $transaction['cardnum'];
            }
            $payment_data['payment_mode'] = 'payumoney';
            $pay_data = Payments::create($payment_data);
            $pay_data->fill($payment_data)->save();
         }
         
         return view('front.payments.payu_fail', compact('pay_data'));
     }
     
     public function paytm_mst($order_no) {         
        $orders = Order::where('order_no', $order_no)->first();
            $orderDetails = Orderdetail::where('order_no', $order_no)->get();
            $state = DB :: table('state')->where('id', $orders->state)->first();
            $city = DB :: table('city')->where('id', $orders->city)->first();
         return view('front.payments.paytm_success',  compact('orderDetails','orders','state','city'));
     }
     
     public function paypal_success() { 
         $request = $_REQUEST;
        //echo "ad";pr($request);exit;
        if($request){
            $orderDetails = Orderdetail::where('order_no', $request['cm'])->get();
            foreach($orderDetails as $orderDetail){
                $is_update = Productcolor::where('product_id', $orderDetail->product_id)
                        ->where('color_id', $orderDetail->color_id)
                        ->where('size_id', $orderDetail->size_id)
                    ->decrement('quantity', $orderDetail->quantity);
            }
        
             $is_update = Order::where('order_no', $request['cm'])
                    ->update(['payment_status'=>$request['st']]);
             
            $payment_data['order_id'] = $request['cm'];
            $payment_data['txn_id'] = $request['tx'];
            $payment_data['amount'] = $request['amt'];
            $payment_data['currency'] = $request['cc'];
            $payment_data['txn_date'] = date('Y-m-d H:i:s');
            $payment_data['status'] = $request['st'];            
            $payment_data['responce_msg'] = 'Payment Successfull.';
            $payment_data['payment_mode'] = 'paypal';
            $pay_data = Payments::create($payment_data);
            $pay_data->fill($payment_data)->save();
         }
         return view('front.payments.paypal_success', compact('pay_data'));
     }
     
     public function paypal_fail() { 
         //$request = $_REQUEST;
        //echo "ad";pr($request);exit;
         return view('front.payments.paypal_fail');
     }
     
     public function paypal_process() { 
         $request = $_REQUEST;
        echo "ad";pr($request);exit;
         return view('front.payments.paytm_success');
     }
     
     
      public function delivery_address($order_no, $page = null) { 
        $order = Order::where('order_no', '=', $order_no)->first();
        $state = [''=>'Select State']+DB :: table('state')->where('country',101)->orderBy('state_name', 'asc')->pluck('state_name', 'id');
        if(!empty($order->state)){
        $city = [''=>'Select City'] +  DB::table('city')->where('state', '=', $order->state)->orderBy('city_name', 'asc')->pluck('city_name', 'id');
        }else{
           $city = [''=>'Select City']; 
        }
        //$user = LoginUser();
        $title = 'Shipping Address';
          
        $pages[trans('admin.MY_PROFILE')] = 'admin.profile';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.CHANGE_PASSWORD'));
        return view('front.users.delivery_address', compact('page','pages','order', 'breadcrumb','title', 'city', 'state'));
    }
    
     public function updateDeliveryAddress(Request $request, $id, $page = null) { //echo $id.$page;exit;
         $orders = Order::findOrFail($id);
         $input = $request->all();
        $input['phone'] = trim($input['phone']);
         //pr($orders);exit;
        $validator = validator::make($input, [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'pincode' => 'required|digits:6|integer',
                    'city' => 'required',
                    'state' => 'required',
                    'address_1' => 'required',
                    'phone' => 'required|phone|min:10|max:10',
                    'email' => 'required|email|max:255',
                   //'profile_img' => 'required|image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
        ]);
        //pr($validator->fails());exit;
        if ($validator->fails()) { //echo "1";exit;
            return redirect()->action('Front\OrderController@delivery_address', [$orders->order_no, $page])
                            ->withErrors($validator)
                            ->withInput();
        }
        //$input = $request->all();
	
        $orders->fill($input)->save();
        if($page == "order"){
        return redirect()->action('Front\ProductsController@checkout')->with('alert-sucess', 'Address Update successfully');
        }else if($page == "guest"){
            return redirect()->action('Front\ProductsController@guest_checkout')->with('alert-sucess', 'Address Update successfully');
        }else if($page == "ByNow"){
            return redirect()->action('Front\ProductsController@bynow_checkout', $orders->order_no)->with('alert-sucess', 'Address Update successfully');
        }else if($page == "bynow"){
            return redirect()->action('Front\ProductsController@bynow', $orders->order_no)->with('alert-sucess', 'Address Update successfully');
        }
    }
   
}




