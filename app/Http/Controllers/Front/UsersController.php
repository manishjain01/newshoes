<?php

namespace App\Http\Controllers\Front;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
use App\Reviews;
use App\EmailTemplate;
use App\Helpers\EmailHelper;
use App\Helpers\CommonHelpers;
use App\Newsletter;
use App\Wishlist;
use App\Pincode;
Use DB;
use Validator;
use Config;
use Input;
use App\Helpers\BasicFunction;
use Mail;
use Crypt;
use Session;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $search = Input::get('search');
        if ($search) {
            $users = User::where('role_id', '!=', Config::get('global.role_id.admin'))->where('varified', '=', '1')->sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('first_name', 'LIKE', "%$search%")
                                ->orwhere('email', 'LIKE', "%$search%")
                                ->orwhere('last_name', 'LIKE', "%$search%")
                                ->orwhere('phone', 'LIKE', "%$search%");
                    })
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $users = User::where('role_id', '!=', Config::get('global.role_id.admin'))->where('varified', '=', '1')
                            ->sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }
        $pageTitle = "Client Information";
        $title = trans('admin.USERS');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'active' => 'Client');
        setCurrentPage('admin.users');

        return view('front.users.index', compact('users', 'pageTitle', 'title', 'breadcrumb'));
    }

    public function create() {
        $pageTitle = trans('admin.ADD_USER');
        $title = trans('admin.ADD_USER');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.users.index';


        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.ADD_USER'));

        return view('front.users.create', compact('pageTitle', 'title', 'breadcrumb'));
    }

    public function account_information() {

        $auth = LoginUser();

        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }

        //$user = Auth::user();

        $user = DB::table('users')
                        ->where('id', '=', $auth->id)->get();
        // pr($user);exit;

        $title = 'Account Information';

        $pages[trans('admin.MY_PROFILE')] = 'admin.profile';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.CHANGE_PASSWORD'));
        return view('front.users.account_information', compact('pages', 'breadcrumb', 'user', 'title'));
    }

    public function wishlist() {
        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }
        $wishlistProduts = DB::table('products')
                        ->join('wishlist', 'products.id', '=', 'wishlist.product_id')
                        //->join('images', 'products.id', '=', 'images.product_id')
                        ->where('wishlist.user_id', $auth->id)
                        ->orderby('wishlist.created_at', 'desc')
                        //->groupBy('products.id')
                        ->select('wishlist.id as id', 'wishlist.product_id as product_id', 'wishlist.color_id as color_id', 'products.product_title as product_title', 'products.price as price', 'products.status as status', 'products.discount as discount', 'products.slug as slug', 'products.category_id as category_id', 'products.sub_category_id as sub_category_id', 'products.sub_sub_category_id as sub_sub_category_id')->get();

        //pr($wishlistProduts);exit;

        $user = DB::table('users')
                        ->where('id', '=', $auth->id)->get();

        $title = 'Wishlist';

        $pages[trans('admin.MY_PROFILE')] = 'admin.profile';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.CHANGE_PASSWORD'));
        return view('front.users.user_wishlist', compact('pages', 'breadcrumb', 'user', 'title', 'wishlistProduts'));
    }

    public function address() {

        $auth = LoginUser();

        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }


        $state = ['' => 'Select State'] + DB :: table('state')->where('country', 101)->orderBy('state_name', 'asc')->pluck('state_name', 'id');
        $city = ['' => 'Select City'] + DB::table('city')->where('state', '=', $auth->state)->orderBy('city_name', 'asc')->pluck('city_name', 'id');

        //$user = Auth::user();

        $user = LoginUser();
        // pr($user);exit;

        $title = 'Account Address';

        $pages[trans('admin.MY_PROFILE')] = 'admin.profile';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.CHANGE_PASSWORD'));
        return view('front.users.address', compact('pages', 'breadcrumb', 'user', 'title', 'city', 'state'));
    }

    public function updateAddress(Request $request, $id) {
        //$input = $request->all();
        //pr($input);exit;
        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }
        $validator = validator::make($request->all(), [
                    //'first_name' => 'required|max:255|unique:users,first_name,' . $id,
                    'pincode' => 'required|digits:6|integer',
                    'city' => 'required',
                    'state' => 'required',
                    'address_1' => 'required',
                        //'email' => 'required|email|max:255|unique:users,email,' . $id,
                        //'profile_img' => 'required|image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
        ]);
        //pr($validator->fails());exit;
        if ($validator->fails()) { //echo "1";exit;
            return redirect()->action('Front\UsersController@address')
                            ->withErrors($validator)
                            ->withInput();
        }
        //echo "hello";exit;

        $input = $request->all();
        //pr($input);exit;
        $users = User::findOrFail($id);

        //pr($input);exit;
        $users->fill($input)->save();
        if (Session::has('ORDER_NO')) {
            $order_no = Session::get('ORDER_NO');
            $is_update = Order::where('order_no', $order_no)
                    ->update(['address_1'=>$input['address_1'],'address_2'=>$input['address_2'],
                        'pincode'=>$input['pincode'],'state'=>$input['state'],'city'=>$input['city']]); 
        }
        return redirect()->action('Front\UsersController@address')->with('alert-sucess', 'Address Update successfully');
    }

    public function myaccount() {

        $auth = LoginUser();

        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }
        $title = 'My dashboard';
        //$user = Auth::user();

        $user = DB::table('users')
                        ->where('id', '=', $auth->id)->get();
        //pr($user);exit;
        $state = DB :: table('state')->where('id', $user[0]->state)->first();
        $city = DB :: table('city')->where('id', $user[0]->city)->first();

        $pages[trans('admin.MY_PROFILE')] = 'admin.profile';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.CHANGE_PASSWORD'));
        return view('front.users.myaccount', compact('pages', 'breadcrumb', 'user', 'title', 'state', 'city'));
    }

    public function register(Request $request) {


        $validator = validator::make($request->all(), [

                    'first_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'phone' => 'required|phone|min:10',
                    'password' => 'required|same:confirm_password|min:6',
                    'confirm_password' => 'required|min:6',
                    'address' => 'required',
                    'dob' => 'required',
                        //'profile_img' => 'required|image|mimes:'.Config::get('global.image_mime_type').'|max:'.Config::get('global.file_max_size'),
        ]);
        if ($validator->fails()) {
            return redirect()->action('Front\HomesController@index')
                            ->withErrors($validator)
                            ->withInput();
        }


        $input = $request->all();

        $input['password'] = Hash::make($request->password);
        //$input['role_id'] = $input['type'];
        $input['email_token'] = $input['_token'];
        $input['looking'] = implode(',', $input['looking']);
        $file = $input['profile_img'];
        if (!empty($file)) {
            $destinationPath = 'public/uploads/';
            $fileName = time() . '_' . $file->getClientOriginalName();
            $input['profile_img'] = $fileName;
            /* Image::make($attachment_name->getRealPath())->resize('100', '100')->save($destinationPath.'thumbnails/'.$fileName); */
            $file->move($destinationPath, $fileName);
        }
        //pr($input);exit;
        $plan = User::create($input);

        $email = $input['email'];
        $email_token = $input['email_token'];
        $email_template = EmailTemplate::where('slug', '=', 'account-registered')->first();
        $email_type = $email_template->email_type;
        $subject = $email_template->subject;
        $body = $email_template->body;
        //$to = $email;

        $reset_link = URL::route('front.resetAccountlink', ['email_token' => $email_token]);
        //$login_link = ADMIN_URL;
        $body = str_replace(array(
            '{FIRST_NAME}',
            '{EMAIL}',
            '{LOGIN_LINK}',
                ), array(
            ucfirst($input['first_name']),
            ucfirst($email),
            $reset_link,
                ), $body);
        $subject = str_replace(array(
            '{FIRST_NAME}',
            '{EMAIL}',
            '{LOGIN_LINK}',
                ), array(
            ucfirst($input['first_name']),
            ucfirst($email),
            $reset_link,
                ), $subject);
        //pr($body);exit;
        EmailHelper::sendMail($email, $email, '', $subject, 'default', $body, $email_type);


        return redirect()->action('Front\HomesController@index')->with('alert-sucess', 'Information Updated Successfully');

        //pr($input);exit;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $validator = validator::make($request->all(), [

                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'phone' => 'required|phone|unique:users',
                    //'password' => 'required|valid_password|same:confirm_password|min:6',
                    'confirm_password' => 'required|min:6',
                        // 'profile_image' => 'required|image|mimes:'.Config::get('global.image_mime_type').'|max:'.Config::get('global.file_max_size'),
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\UsersController@create')
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();

        $input['password'] = Hash::make($request->password);
        $input['role_id'] = Config::get('global.role_id.user');
        $input['email_token'] = $input['_token'];
        //$user = User::create($input);

        $email = $input['email'];
        $email_token = $input['email_token'];
        $email_template = EmailTemplate::where('slug', '=', 'account-registered')->first();
        $email_type = $email_template->email_type;
        $subject = $email_template->subject;
        $body = $email_template->body;
        //$to = $email;

        $reset_link = URL::route('admin.resetAccountlink', ['email_token' => $email_token]);
        //$login_link = ADMIN_URL;
        $body = str_replace(array(
            '{FIRST_NAME}',
            '{LAST_NAME}',
            '{EMAIL}',
            '{LOGIN_LINK}',
                ), array(
            ucfirst($input['first_name']),
            ucfirst($input['last_name']),
            ucfirst($email),
            $reset_link,
                ), $body);
        $subject = str_replace(array(
            '{FIRST_NAME}',
            '{LAST_NAME}',
            '{EMAIL}',
            '{LOGIN_LINK}',
                ), array(
            ucfirst($input['first_name']),
            ucfirst($input['last_name']),
            ucfirst($email),
            $reset_link,
                ), $subject);


        EmailHelper::sendMail($email, $email, '', $subject, 'default', $body, $email_type);
        //echo "hello";
        //echo "<pre>";
        //print_r($input);
        //exit;
        //$msg = "A new account has been created by ".$input['phone'].".";    
        //$phone = '9785205042';
        //$data = EmailHelper::sendsms($phone,$msg);   

        return redirect()->action('Admin\UsersController@index', getCurrentPage('admin.users'))->with('alert-sucess', trans('admin.USER_ADD_SUCCESSFULLY'));
    }

    function resetAccountlink($email_token = null) {
        $user = User::where('email_token', '=', $email_token)->first();
        if ($user) {
            $is_update = User::where('id', $user->id)
                    ->update(['varified' => 1]);
        }
        return view('admin.users.rereset_accountlink');
    }

    function resetPasswordlink($email_token = null) {
        $user = User::where('email_token', '=', $email_token)->first();
        //pr($user);exit;
        if ($user) {
            /* $is_update = User::where('id', $user->id)
              ->update(['varified' => 1]); */
        }
        return view('front.users.reset_password', compact('user', 'email_token'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetPasswordUpdate(Request $request, $email_token) {

        $validator = validator::make($request->all(), [
                    'password' => 'required|same:confirm_password|min:6',
                    'confirm_password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Front\UsersController@resetPasswordlink', $email_token)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $user = User::where('email_token', '=', $email_token)->first();
        $password = Hash::make($request->password);
        $is_update = User::where('id', $user->id)
                ->update(['password' => $password]);
        return redirect()->action('Front\UsersController@resetPasswordlink', $email_token)->with('alert-sucess', 'Account password changed successfully');
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
    public function edit() {

        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }

        $Auth_user = Auth::user();
        $user = User::find($Auth_user->id);
        if (empty($user)) {
            return $this->InvalidUrl();
        }

        $pageTitle = trans('admin.EDIT_USER');
        $title = trans('admin.EDIT_USER');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.users.index';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.EDIT_USER'));
        return view('front.users.edit', compact('pageTitle', 'title', 'breadcrumb', 'user'));
    }

    public function updateProfile(Request $request, $id) {
        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }
        $input = $request->all();
        $input['phone'] = trim($input['phone']);
        $validator = validator::make($input, [
                    //'first_name' => 'required|max:255|unique:users,first_name,' . $id,
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'phone' => 'required|phone|min:10|max:10',
                    //'email' => 'required|email|max:255|unique:users,email,' . $id,
                    'profile_img' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
        ]);
        //pr($validator->fails());exit;
        if ($validator->fails()) { //echo "1";exit;
            return redirect()->action('Front\UsersController@account_information')
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $request->all();
        if (!empty($input['profile_img'])) {
            $file = $input['profile_img'];
        }
        ini_set("upload_max_filesize", "10240M");
        if (!empty($file)) {
            $destinationPath = 'public/uploads/user/';
            $fileName = time() . '_' . $file->getClientOriginalName();
            $input['profile_img'] = $fileName;
            /* Image::make($attachment_name->getRealPath())->resize('100', '100')->save($destinationPath.'thumbnails/'.$fileName); */
            $file->move($destinationPath, $fileName);
        }
        $users = User::findOrFail($id);
        $users->fill($input)->save();
        if (Session::has('ORDER_NO')) {
            $order_no = Session::get('ORDER_NO');
            $is_update = Order::where('order_no', $order_no)
                    ->update(['first_name'=>$input['first_name'],'last_name'=>$input['last_name'],
                        'phone'=>$input['phone']]); 
        }
        return redirect()->action('Front\UsersController@account_information')->with('alert-sucess', trans('admin.MY_PROFILE_UPDATE_SUCCESS'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        if ($id == '') {
            return $this->InvalidUrl();
        }
        $user = User::findOrFail($id);
        if (empty($user)) {
            return $this->InvalidUrl();
        }



        $validator = validator::make($request->all(), [
                    'first_name' => 'required|max:255',
                    'dob' => 'required',
                    'address' => 'required',
                    'phone' => 'required|phone|min:10',
                        //'profile_img' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
        ]);
        if ($validator->fails()) {


            return redirect()->action('Admin\UsersController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $input['dob'] = date('Y-m-d', strtotime($input['dob']));
        //pr($input);exit;
        if (!empty($input['profile_img'])) {
            $file = $input['profile_img'];
        }
        ini_set("upload_max_filesize", "10240M");
        if (!empty($file)) {
            $destinationPath = 'public/uploads/';
            $fileName = time() . '_' . $file->getClientOriginalName();
            $input['profile_img'] = $fileName;
            /* Image::make($attachment_name->getRealPath())->resize('100', '100')->save($destinationPath.'thumbnails/'.$fileName); */
            $file->move($destinationPath, $fileName);
        }
        pr($input);
        exit;
        $user->fill($input)->save();
        return redirect()->back()->with('alert-sucess', trans('admin.USER_UPDATE_SUCCESSFULLY'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $user = User::find($id)->delete();
        return redirect()->action('Admin\UsersController@index');
    }

    public function forgotPassword() {
        $checkEmail = User::where('email', Input::get('username'))->first();

        $from = "info@pepealoans.com";

        if (empty(Input::get('username'))) {
            echo json_encode(['message' => 'Please enter Email Id.']);
            exit;
        } elseif (empty($checkEmail)) {
            echo json_encode(['message' => 'Email does not exists.']);
            exit;
        } else {
            //$userData = User::select('id', 'email', 'first_name')->where('email', Input::get('email'))->where('status', '1')->get()->toArray();
            //$reset_password = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            //$password_hash = Hash::make($reset_password);
            //$is_update = User::where('id', $checkEmail->id)->update(['password' => $password_hash]);

            $user = User::findorFail($checkEmail->id);

            $email = $user['email'];
            $email_token = $user['email_token'];
            $email_template = EmailTemplate::where('slug', '=', 'user-forgot-password')->first();

            $email_type = $email_template->email_type;
            $subject = $email_template->subject;
            $body = $email_template->body;
            $to = $email;
            $reset_link = URL::route('front.resetPasswordlink', ['email_token' => $email_token]);


            $body = str_replace(array(
                '{FIRST_NAME}',
                '{LAST_NAME}',
                '{EMAIL}',
                '{PASSWORD}',
                    ), array(
                ucfirst($user->first_name),
                ucfirst($user->last_name),
                ucfirst($email),
                $reset_link,
                    ), $body);
            $subject = str_replace(array(
                '{FIRST_NAME}',
                '{LAST_NAME}',
                '{EMAIL}',
                '{PASSWORD}',
                    ), array(
                ucfirst($user->first_name),
                ucfirst($user->last_name),
                ucfirst($email),
                $reset_link,
                    ), $subject);


            EmailHelper::sendMail($to, '', '', $subject, 'default', $body, $email_type);


            echo json_encode(['message' => 'Please Check Your mail']);
            exit;
        }
    }

    function resetPassword($email_token = null) {
        if ($email_token == null) {
            return redirect()->action('Admin\AuthController@getLogin');
        }
        $user = User::where('email_token', '=', $email_token)->where('role_id', '=', 1)->first();

        if (empty($user->id)) {
            return redirect()->action('Admin\AuthController@getLogin');
        }
        $pageTitle = trans('front.RESET_PASSWORD');
        $title = trans('front.RESET_PASSWORD');
        return view('admin.users.reset_password', compact('pageTitle', 'title', 'email_token'));
    }

    public function change_password() {


        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }
        $title = 'Change Password';
        $user = Auth::user();
        $pageTitle = trans('front.CHANGE_PASSWORD');
        $title = 'Change Password';
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('front.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.MY_PROFILE')] = 'admin.profile';
        $breadcrumb = array('pages' => $pages, 'active' => trans('front.CHANGE_PASSWORD'));
        return view('front.users.change_password', compact('pageTitle', 'breadcrumb', 'user', 'title'));
    }

    public function UpdateChangePassword(Request $request) {

        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }
        $user = Auth::user();
        if (isset($user->login_mode) && $user->login_mode == 'manual') {
            $validator = validator::make($request->all(), [
                        //'new_password' => 'required|ValidPassword|min:6',                    
                        'old_password' => 'required|OldPasswordCheck:' . $user->password,
                        'new_password' => 'required|min:6',
                        'confirm_password' => 'required_with:new_password|same:new_password|min:6',
            ]);
        } else {
            $validator = validator::make($request->all(), [
                        //'new_password' => 'required|ValidPassword|min:6',                    
                        //'old_password' => 'required|OldPasswordCheck:' . $user->password,                         
                        'new_password' => 'required|min:6',
                        'confirm_password' => 'required_with:new_password|same:new_password|min:6',
            ]);
        }
        if ($validator->fails()) {
            return redirect()->action('Front\UsersController@change_password')
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $request->all();
        $password = Hash::make($request->new_password);
        $is_update = User::where('id', $user->id)
                ->update(['password' => $password, 'pwd' => $request->new_password, 'login_mode' => 'manual']);
        return redirect()->action('Front\AuthController@getLogout')->with('alert-sucess', trans('admin.PASSWORD_CHANGE_SUCCESS'));
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
        $user = User::where('id', '=', $id)->first();
        $user->status = $new_status;
        $user->save();
        return redirect()->back()->with('alert-sucess', trans('admin.USER_CHANGE_STATUS_SUCCESSFULLY'));
    }

    function sendCredentials($id) {

        if ($id == '') {
            return $this->InvalidUrl();
        }
        $user = User::findOrFail($id);
        if (empty($user)) {
            return $this->InvalidUrl();
        }
        $password = generateStrongPassword();
        $user->password = Hash::make($password);
        $user->save();


        $email_template = EmailTemplate::where('slug', '=', 'send-login-credentials')->first();
        $email_type = $email_template->email_type;
        $subject = $email_template->subject;
        $body = $email_template->body;

        $to = $user->email;

        $login_link = WEBSITE_URL;
        $body = str_replace(array(
            '{FIRST_NAME}',
            '{LAST_NAME}',
            '{EMAIL_ADDRESS}',
            '{LOGIN_LINK}',
            '{PASSWORD}'
                ), array(
            ucfirst($user->first_name),
            ucfirst($user->last_name),
            $user->email,
            $login_link,
            $password,
                ), $body);


        $subject = str_replace(array(
            '{FIRST_NAME}',
            '{LAST_NAME}',
            '{EMAIL_ADDRESS}',
            '{LOGIN_LINK}',
            '{PASSWORD}'
                ), array(
            ucfirst($user->first_name),
            ucfirst($user->last_name),
            $user->email,
            $login_link,
            $password,
                ), $subject);


        EmailHelper::sendMail($to, '', '', $subject, 'default', $body, $email_type);
        return redirect()->action('Admin\UsersController@index', getCurrentPage('admin.users'))->with('alert-sucess', trans('admin.CREDENTIALS_SEND_SUCCESSFULLY'));
    }

    public function check_otp($data) {
        $input = (array) $data;
        $user = array();
        //   $user = User::select('otp')->where('otp',$input['otp'])->get()->toArray();
        $user = User::where('otp', $input['otp'])->first();
        if (!empty($user)) {

            if ($user['otp'] == $input['otp']) {
                $input['varified'] = 1;
                $user->fill($input)->save();
                return base64_encode(json_encode(['message' => 'Otp successful done', 'method' => 'check_otp', 'status' => 'success']));
            } else {
                return base64_encode(json_encode(['message' => 'Wrong Otp ', 'method' => 'check_otp', 'status' => 'fail']));
            }
        } else {
            return base64_encode(json_encode(['message' => 'Please Enter Currect Otp ', 'method' => 'check_otp', 'status' => 'fail']));
        }
    }

    public function check_email($data) {
        $input = (array) $data;
        $user = array();
        $user = User::select('email')->where('email', $input['email'])->where('varified', 1)->get()->toArray();
        if (!empty($user)) {

            return base64_encode(json_encode(['message' => 'Email already exists', 'method' => 'check_email', 'status' => 'fail']));
        } else {
            return base64_encode(json_encode(['message' => 'Email not exists', 'method' => 'check_email', 'status' => 'success']));
        }
    }

    public function check_phone($data) {
        $input = (array) $data;
        $user = array();
        $user = User::select('phone')->where('phone', $input['phone'])->where('varified', 1)->get()->toArray();
        //print_r($user);exit;
        if (!empty($user)) {
            return base64_encode(json_encode(['message' => 'Phone no. already exists', 'method' => 'check_phone', 'status' => 'fail']));
        } else {
            return base64_encode(json_encode(['message' => 'Phone no. not exists', 'method' => 'check_phone', 'status' => 'success']));
        }
    }

    public function resend_otp($data) {
        $input = (array) $data;
        $user = array();
        //$user = User::findOrFail($input['user_id']);
        $user = User::find($input['user_id']);
        if (!empty($user)) {
            $Token = mt_rand(1111, 9999);
            $input['otp'] = $Token;

            $user->otp = $Token;
            $user->save();
            //$checkstatus['otp'] = $user->otp;
            if ($user) {
                $checkstatus['otp'] = $user->otp;
                $checkstatus['phone'] = $user->phone;
                $Msg = 'Your unique OTP is ' . $Token;
                $userName = "jbit110"; //your username
                $pwd = "Jbit5000"; //your password
                $mobilenumbers = "91" . $checkstatus['phone']; //enter Mobile numbers comma seperated
                $message = $Msg; //enter Your Message
                $senderid = "JAJOOS"; //Your senderid
                $messagetype = "N"; //Type Of Your Message
                $DReports = "Y"; //Delivery Reports
                /* $url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
                  $message = urlencode($message);
                  $ch = curl_init();
                  if (!$ch){die("Couldn't initialize a cURL handle");}
                  $ret = curl_setopt($ch, CURLOPT_URL,$url);
                  curl_setopt ($ch, CURLOPT_POST, 1);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                  curl_setopt ($ch, CURLOPT_POSTFIELDS,
                  "User=$userName&passwd=$pwd&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
                  $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); */
                //If you are behind proxy then please uncomment below line and provide your proxy ip with port.
                //$ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
                // $curlresponse = curl_exec($ch); // execute

                $msg = "Your OTP to verify your account is " . $user->otp;
                $phone = $user->phone;
                $data = EmailHelper::sendsms($phone, $msg);

                return base64_encode(json_encode(['message' => 'Otp successful Change', 'method' => 'resend_otp', 'status' => 'success', 'data' => $checkstatus]));
            } else {
                return base64_encode(json_encode(['message' => 'Wrong Otp ', 'method' => 'resend_otp', 'status' => 'fail']));
            }
        } else {

            return base64_encode(json_encode(['message' => 'User Not Found', 'method' => 'resend_otp', 'status' => 'fail']));
        }
    }

    public function getLogin() {
        return view('front.users.login');
    }

    public function postLogin(Request $request) {
        $validator = validator::make($request->all(), [
                    'email' => 'required|email',
                    //'phone' => 'required|phone|unique:users',
                    'password' => 'required']);
        //pr($validator->fails());
        if ($validator->fails()) {
            return redirect()->action('Front\UsersController@getLogin')
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $input['role_id'] = 2;
        if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')])) {
            return \Redirect::route('index');
        } else {
            return \Redirect::route('front_login')->with('failed', 'Email or Password incorrect!!!!!');
        }
        //
        $user = User::select('id', 'email', 'phone', 'first_name', 'profile_img', 'password', 'role_id', 'status', 'varified', 'address', 'lat', 'lng')->where('email', $input['email'])->where('status', '1')->get()->toArray();

        if (!empty($user)) {
            $userData = User::findOrFail($user['0']['id']);

            if (!empty($user['0']['profile_img'])) {
                $checkstatus['profile_img'] = $user['0']['profile_img'];
            } else {
                $checkstatus['profile_img'] = '';
            }
            $userData['device_type'] = 'web';
            $userData->save();
            $password = Hash::check($input['password'], $user['0']['password']);

            if ($password) {

                if ($user['0']['role_id'] == Config::get('global.role_id.user')) {
                    if ($user['0']['status'] == 1 && $user['0']['varified'] == 1) {

                        echo json_encode(['message' => 'Login successful done', 'method' => 'login', 'status' => 'success', 'data' => $checkstatus]);
                        exit;
                    } else {
                        echo json_encode(['message' => 'Your account is not active.', 'method' => 'login', 'status' => 'fail']);
                        exit;
                    }
                } else {
                    echo json_encode(['message' => 'Wrong email or password.', 'method' => 'login', 'status' => 'fail']);
                    exit;
                }
            } else {
                echo json_encode(['message' => 'Wrong  password.', 'method' => 'login', 'status' => 'fail']);
                exit;
            }
        } else {
            echo json_encode(['message' => 'Wrong email or password.', 'method' => 'login', 'status' => 'fail']);
            exit;
        }
    }

    public function password_reset($data) {
        $input = (array) $data;
        $mobile = $input['mobile'];
        $otp = $input['otp'];
        $new_password = Hash::make($input['new_password']);
        $userData = User::where('otp', $otp)->first();

        if ($input['new_password'] == $input['confirm_password']) {
            if ($userData) {
                $update = User::where('phone', $mobile)->first();
                $update->password = $new_password;
                $update->save();
                return base64_encode(json_encode(['message' => 'Your password changed successfully.', 'method' => 'password_reset', 'status' => 'success']));
            } else {
                return base64_encode(json_encode(['message' => 'Your OTP does not match.', 'method' => 'password_reset', 'status' => 'fail']));
            }
        } else {
            return base64_encode(json_encode(['message' => 'Your new password and confirm password does not match.', 'method' => 'password_reset', 'status' => 'fail']));
        }
    }

    public function forgot_password($data) {

        $input = (array) $data;
        $user = array();
        //print_r($input);
        if (empty($input['type'])) {

            echo json_encode(['message' => 'Please enter email or phone.', 'method' => 'forgot_password', 'status' => 'fail']);
            exit;
        } elseif (empty($input['value'])) {

            echo json_encode(['message' => 'Please enter value email or phone.', 'method' => 'forgot_password', 'status' => 'fail']);
            exit;
        }
        if ($input['type'] == 'email') {
            $userData = User::select('id', 'email', 'first_name', 'last_name')->where('email', $input['value'])->where('status', '1')->get()->toArray();

            if (!empty($userData)) {
                if ($userData) {
                    $reset_password = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                    $password_hash = Hash::make($reset_password);
                    $is_update = User::where('id', $userData['0']['id'])->update(['password' => $password_hash]);
                    if ($is_update) {
                        $user = User::findorFail($userData['0']['id']);
                        $email = $user['email'];
                        $email_token = $user['email_token'];
                        $email_template = EmailTemplate::where('slug', '=', 'user-forgot-password')->first();
                        $email_type = $email_template->email_type;
                        $subject = $email_template->subject;
                        $body = $email_template->body;
                        $to = $email;

                        //$reset_password = $password;
                        //$login_link = ADMIN_URL;
                        $body = str_replace(array(
                            '{FIRST_NAME}',
                            '{LAST_NAME}',
                            '{EMAIL}',
                            '{PASSWORD}',
                                ), array(
                            ucfirst($user->first_name),
                            ucfirst($user->last_name),
                            ucfirst($email),
                            $reset_password,
                                ), $body);
                        $subject = str_replace(array(
                            '{FIRST_NAME}',
                            '{LAST_NAME}',
                            '{EMAIL}',
                            '{PASSWORD}',
                                ), array(
                            ucfirst($user->first_name),
                            ucfirst($user->last_name),
                            ucfirst($email),
                            $reset_password,
                                ), $subject);


                        EmailHelper::sendMail($to, $to, '', $subject, 'default', $body, $email_type);
                    }

                    echo json_encode(['message' => 'Please Check Your mail', 'method' => 'forgot_password', 'status' => 'success']);
                    exit;
                } else {

                    echo json_encode(['message' => 'Email Id incorrect', 'method' => 'forgot_password', 'status' => 'fail']);
                    exit;
                }
            } else {
                echo json_encode(['message' => 'Invalid Email Id', 'method' => 'forgot_password', 'status' => 'fail']);
                exit;
            }
        } elseif ($input['type'] == 'phone') {

            $user_Data = User::select('id', 'phone', 'email')->where('phone', $input['value'])->where('status', '1')->get()->toArray();
            if ($user_Data) {
                echo "sms api not found.";
                exit;
            } else {
                echo json_encode(['message' => 'Invalid Phone No.', 'method' => 'forgot_password', 'status' => 'fail']);
                exit;
            }
        }
    }

    public function newletter_post() {

        $checkEmail = Newsletter::where('email', Input::get('news_email'))->first();

        if (empty(Input::get('news_email'))) {
            echo json_encode(['message' => 'Please enter email id']);
            exit;
        } else if (!empty($checkEmail)) {
            echo json_encode(['message' => 'This Email Id is already exist']);
            exit;
        } else {
            $input['email'] = Input::get('news_email');
            $newsletter = Newsletter::create($input);
            $newsletter->fill($input)->save();

            echo json_encode(['message' => 'Successfully Subscribed For Newsletter.']);
            exit;
        }
    }

    public function remove_userimg() {

        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        } else {
            $is_update = User::where('id', $auth->id)
                    ->update(['profile_img' => '']);
            if ($is_update) {
                /* if(file_exists(IMAGE_URL.Input::get('image_name'))){                  
                  unlink(IMAGE_URL.Input::get('image_name'));
                  } */
                echo json_encode(['message' => 'Image Remove Successfuly']);
                exit;
            }
        }
    }

    public function getcities($id) {


        if (empty($id)) {
            return $this->InvalidUrl();
        }
        $subCategory = ['' => 'Select City'] + DB::table('city')->where('state', '=', $id)->orderBy('city_name', 'asc')->pluck('city_name', 'id');
        echo json_encode($subCategory);
        exit;
    }

    public function postReview(Request $request) {

        $input['user_id'] = Input::get('user_id');
        $input['product_id'] = Input::get('product_id');
        $input['rating'] = Input::get('rating');
        $input['comment'] = Input::get('comment');


        $msg['message'] = "";
        if (empty(Input::get('rating'))) {
            $msg['message'] = "please enter Rating.";
        } elseif (empty(trim(Input::get('comment')))) {
            $msg['message'] = "please enter comment.";
        } else {
            $checkCountProduct = DB::table('orders')
                            ->join('orderdetails', 'orderdetails.order_no', '=', 'orders.order_no')
                            ->where('orderdetails.product_id', Input::get('product_id'))
                            ->where('orders.status', '=', '1')
                            ->select('orders.id')->count();
            //pr($checkCountProduct);exit;
            if ($checkCountProduct == 0) {
                $msg['message'] = "Oops! You are not allowed to review this product.";
                //echo json_encode(['message' => 'Oops! You are not allowed to review this product.']);
                //exit; 
            } else { 
                $reviews = Reviews::create($input);
                $reviews->fill($input)->save();
                $msg['message'] = "Review submitted successfully";
                //echo json_encode(['message' => 'Review submitted successfully']);
                //exit;
            }
        }
        echo json_encode($msg);
        exit;
    }

    public function allReviews($product_id, $slug) {

        //$auth = LoginUser();

        /* if (empty($auth)) {
          return redirect()->action('Front\HomesController@index');
          } */
        $title = 'Reviews';

        /* $reviews = DB::table('reviews')
          ->where('product_id', '=', $product_id)->paginate(2); */

        $reviews = DB::table('reviews')
                        ->join('users', 'reviews.user_id', '=', 'users.id')
                        ->where('reviews.product_id', $product_id)
                        ->orderby('reviews.created_at', 'desc')
                        ->select('reviews.id as id', 'reviews.rating as rating', 'reviews.comment as comment', 'users.first_name as first_name', 'users.last_name as last_name', 'users.profile_img as profile_img')->paginate(10);

        $pages[trans('admin.MY_PROFILE')] = 'admin.profile';

        return view('front.users.allreviews', compact('pages', 'breadcrumb', 'reviews', 'title'));
    }

    public function pincodeAvail(Request $request) {

        $pincode = Input::get('pincode');

        $msg['message'] = "";
        if (empty(Input::get('pincode'))) {
            $msg['message'] = "please enter pincode.";
        } else {
            $pincode_availability = Pincode::where('pincode', $pincode)->get()->toArray();

            if (isset($pincode_availability) && !empty($pincode_availability)) {
                echo json_encode(['message' => 'Product is available for this location']);
                exit;
            } else {
                echo json_encode(['message' => 'Product is not available for this location']);
                exit;
            }
        }
        echo json_encode($msg);
    }

    public function edit_address($order_no = null, $page = null) {

        $auth = LoginUser();

        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }


        $state = ['' => 'Select State'] + DB :: table('state')->where('country', 101)->orderBy('state_name', 'asc')->pluck('state_name', 'id');
        $city = ['' => 'Select City'] + DB::table('city')->where('state', '=', $auth->state)->orderBy('city_name', 'asc')->pluck('city_name', 'id');

        //$user = Auth::user();

        $user = LoginUser();
        //pr($user);exit;

        $title = 'Account Address';

        $pages[trans('admin.MY_PROFILE')] = 'admin.profile';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.CHANGE_PASSWORD'));
        return view('front.users.edit_address', compact('page','order_no','pages', 'breadcrumb', 'user', 'title', 'city', 'state'));
    }

    public function update_user_Address(Request $request, $id, $order_no = null, $page = null) {
        //echo $order_no;
         //echo $page;exit;
        $input = $request->all();
        $input['phone'] = trim($input['phone']);
        //pr($input);exit;
        $auth = LoginUser();
        if (empty($auth)) {
            return redirect()->action('Front\HomesController@index');
        }
        $validator = validator::make($input, [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'pincode' => 'required|digits:6|integer',
                    'city' => 'required',
                    'state' => 'required',
                    'address_1' => 'required',
                    'phone' => 'required|phone|min:10|max:10',
                        //'email' => 'required|email|max:255|unique:users,email,' . $id,
                        //'profile_img' => 'required|image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
        ]);
        //pr($validator->fails());exit;
        if ($validator->fails()) { //echo "1";exit;
            return redirect()->action('Front\UsersController@edit_address', [$order_no, $page])
                            ->withErrors($validator)
                            ->withInput();
        }
      
        $input = $request->all();
        //pr($input);exit;
        $users = User::findOrFail($id);

        //pr($input);exit;
        $users->fill($input)->save();
        if($page == "ByNow"){
            return redirect()->action('Front\ProductsController@bynow_checkout', $order_no)->with('alert-sucess', 'Address Update successfully');
        }else{
        return redirect()->action('Front\ProductsController@checkout')->with('alert-sucess', 'Address Update successfully');
    
        }
        }

}
