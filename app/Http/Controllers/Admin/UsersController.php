<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use URL;
use App\Http\Controllers\Controller;
use App\User;
use App\Contact;
use App\EmailTemplate;
use App\Helpers\EmailHelper;
Use DB;
use Validator;
use Config;
use Input;
use App\Helpers\BasicFunction;
use Mail;
use Crypt;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $search = trim(Input::get('search'));
        if ($search) {
            $users = User::where('role_id', '!=', Config::get('global.role_id.admin'))->sortable(['created_at' => 'desc'])
                    ->where(function($query) use ($search) {
                        return $query->where('first_name', 'LIKE', "%$search%")
                                ->orwhere('email', 'LIKE', "%$search%")
                                ->orwhere('last_name', 'LIKE', "%$search%")
                                ->orwhere('phone', 'LIKE', "%$search%");
                    })
                    ->paginate(Configure('CONFIG_PAGE_LIMIT'));
        } else {
            $users = User::where('role_id', '!=', Config::get('global.role_id.admin'))
                            ->sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        }
        $pageTitle = "Client Information";
        $title = trans('admin.USERS');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';

        //pr($users);
        $breadcrumb = array('pages' => $pages, 'actives' => 'Users', 'active' =>'admin.users.index');
        setCurrentPage('admin.users');

        return view('admin.users.index', compact('users', 'pageTitle', 'title', 'breadcrumb'));
    }

    public function create() {
        $pageTitle = trans('admin.ADD_USER');
        $title = trans('admin.ADD_USER');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.users.index';


        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.ADD_USER'));

        return view('admin.users.create', compact('pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responsep
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //$user = User::find($id);
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
        $user = User::find($id);
        if (empty($user)) {
            return $this->InvalidUrl();
        }



        $pageTitle = trans('admin.EDIT_USER');
        $title = trans('admin.EDIT_USER');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.USERS')] = 'admin.users.index';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.EDIT_USER'));
        return view('admin.users.edit', compact('user', 'pageTitle', 'title', 'breadcrumb'));
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

                    'gender' => 'required',
                    'address' => 'required',
                    'phone' => 'required|phone',
                        //'profile_img' => 'image|mimes:' . Config::get('global.image_mime_type') . '|max:' . Config::get('global.file_max_size'),
        ]);
        if ($validator->fails()) {

            return redirect()->action('Admin\UsersController@edit', $id)
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        //$input['looking'] = implode(',', $input['looking']);
        if(!empty($input['looking'])){
        $input['looking'] = $input['looking'];
        }
        $input['dob'] = date('Y-m-d', strtotime($input['dob']));
        //pr($input);exit;
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
        $pageTitle = trans('admin.CONFIG_MANAGEMENT');
        $title = trans('admin.CONFIG_MANAGEMENT');
        return view('admin.users.forgot_password', compact('pageTitle', 'title'));
    }

    public function sendPasswordLink(Request $request) {

        $validator = validator::make($request->all(), [

                    'email' => 'required|email|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\UsersController@forgotPassword')
                            ->withErrors($validator)
                            ->withInput();
        }

        $input = $request->all();
        $email = $input['email'];
        $user = User::where('email', '=', $email)->where('role_id', '=', 1)->first();
        if (empty($user->id)) {
            return redirect()->action('Admin\UsersController@forgotPassword')->with('alert-error', 'User Not exist.Please try with another email.');
        }
        $email_token = md5(uniqid(rand(), true));
        $is_update = User::where('id', $user->id)
                ->update(['email_token' => $email_token]);

        if ($is_update) {
            User::where('email', '=', $email)->where('role_id', '=', 1)->first();
        }
        $email_template = EmailTemplate::where('slug', '=', 'admin-forgot-password')->first();
        $email_type = $email_template->email_type;
        $subject = $email_template->subject;
        $body = $email_template->body;
        $to = $user->email;
        $reset_link = URL::route('admin.reset_password', ['email_token' => $email_token]);
        $login_link = ADMIN_URL;
        $body = str_replace(array(
            '{FIRST_NAME}',
            '{LAST_NAME}',
            '{EMAIL}',
            '{LOGIN_LINK}',
            '{PASSWORD_RESET_URL}'
                ), array(
            ucfirst($user->first_name),
            ucfirst($user->last_name),
            ucfirst($user->email),
            $login_link,
            $reset_link,
                ), $body);
        $subject = str_replace(array(
            '{FIRST_NAME}',
            '{LAST_NAME}',
            '{EMAIL}',
            '{LOGIN_LINK}',
            '{PASSWORD_RESET_URL}'
                ), array(
            ucfirst($user->first_name),
            ucfirst($user->last_name),
            ucfirst($user->email),
            $login_link,
            $reset_link,
                ), $subject);

        EmailHelper::sendMail($to, '', '', $subject, 'default', $body, $email_type);
        return redirect()->action('Admin\AuthController@getLogin')->with('alert-sucess', 'Password reset link successfully send');
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

    public function resetPasswordUpdate(Request $request, $email_token) {
        $validator = validator::make($request->all(), [
                    'password' => 'required|same:confirm_password|min:6',
                    'confirm_password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\UsersController@resetPassword')
                            ->withErrors($validator)
                            ->withInput();
        }
        $input = $request->all();
        $user = User::where('email_token', '=', $email_token)->where('role_id', '=', 1)->first();
        $password = Hash::make($request->password);
        $is_update = User::where('id', $user->id)
                ->update(['email_token' => '', 'password' => $password]);
        return redirect()->action('Admin\AuthController@getLogin')->with('alert-sucess', 'Account password changed successfully');
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

        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.MY_PROFILE'), 'active' =>'admin.profile');
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
        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.CHANGE_PASSWORD'), 'active' =>'admin.ChangePassword');
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
        return redirect()->action('Admin\UsersController@profile')->with('alert-sucess', trans('admin.MY_PROFILE_UPDATE_SUCCESS'));
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

    public function admin_user_search() {
        $search_name = Input::get('name');
        $search_email = Input::get('email');
        $search_phone = Input::get('phone');
        $users = DB::table('users');
        if ($search_name != '') {
            $users->where('first_name', 'LIKE', "%$search_name%")->orWhere('last_name', 'LIKE', "%$search_name%");
        }
        if ($search_email != '') {
            $users->where('email', 'LIKE', "%$search_email%");
        }
        if ($search_phone != '') {
            $users->where('phone', 'LIKE', "%$search_phone%");
        }

        $users = $users->where('role_id', '!=', Config::get('global.role_id.admin'))->paginate(Configure('CONFIG_PAGE_LIMIT'));

        $pageTitle = "Client Information";
        $title = trans('admin.USERS');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'active' => 'Client');
        setCurrentPage('admin.users');

        return view('admin.users.index', compact('users', 'pageTitle', 'title', 'breadcrumb'));
    }

    public function register($data,$file) {
		
        $input = (array) $data;
//pr($input);die;
        $password = $input['password'];
        $checkEmail = User::where('email', $input['email'])->first();
        $checkPhone = User::where('phone', $input['phone'])->first();
        $checkName = User::where('first_name', $input['name'])->first();

        if (empty($input['email'])) {
            echo json_encode(['message' => 'Please enter email.', 'method' => 'register', 'status' => 'fail']);
            exit;
        } elseif (empty($input['user_type'])) {
            echo json_encode(['message' => 'Please enter user type.', 'method' => 'register', 'status' => 'fail']);
            exit;
        } elseif (empty($input['phone'])) {
            echo json_encode(['message' => 'Please enter phone No.', 'method' => 'register', 'status' => 'fail']);
            exit;
        } elseif (empty($input['gender'])) {
            echo json_encode(['message' => 'Please select gender.', 'method' => 'register', 'status' => 'fail']);
            exit;
        } elseif (empty($input['name'])) {
            echo json_encode(['message' => 'Please enter name.', 'method' => 'register', 'status' => 'fail']);
            exit;
        } elseif (empty($input['password'])) {
            echo json_encode(['message' => 'Please enter password.', 'method' => 'register', 'status' => 'fail']);
            exit;
        } elseif (!empty($checkEmail)) {
            echo json_encode(['message' => 'An account with this email address already exists.', 'method' => 'register', 'status' => 'fail']);
            exit;
        } /*elseif (!empty($checkPhone)) {
            echo json_encode(['message' => 'An account with this number already exists.', 'method' => 'register', 'status' => 'fail']);
            exit;
        } */elseif (!empty($checkName)) {
            echo json_encode(['message' => 'An account with this name already exists.', 'method' => 'register', 'status' => 'fail']);
            exit;
        } else {

            $ip_address = $_SERVER['REMOTE_ADDR'];

            $userData['role_id'] = $input['user_type'];
            $userData['status'] = 1;
            if (!empty($input['lat'])) {
                $userData['lat'] = $input['lat'];
            }
            if (!empty($input['lng'])) {
                $userData['lng'] = $input['lng'];
            }
            $date = date('Y-m-d', strtotime($input['dob']));
            $userData['first_name'] = $input['name'];
            $userData['ip_address'] = $ip_address;
            $userData['email'] = $input['email'];
            $userData['phone'] = $input['phone'];
            $userData['address'] = $input['address'];
            $userData['gender'] = $input['gender'];
            $userData['looking'] = $input['looking'];
            $userData['dob'] = $date;
            $userData['email_token'] = md5(uniqid(rand(), true));
            $userData['password'] = Hash::make($input['password']);
            
            ini_set("upload_max_filesize", "102400M");
            //set_time_limit ( 300 );
            if (!empty($file)) {
                $destinationPath = 'public/uploads/';
                $fileName = time() . '_' . $file->getClientOriginalName();
                $userData['profile_img'] = $fileName;
                /* Image::make($attachment_name->getRealPath())->resize('100', '100')->save($destinationPath.'thumbnails/'.$fileName); */
                $file->move($destinationPath, $fileName);
            }
            $user = User::create($userData);
            $user->fill($userData)->save();

           // if ($user->role_id == 2) {
                $email = $user->email;
                $email_token = $user->email_token;
                $email_template = EmailTemplate::where('slug', '=', 'account-registered')->first();
                $email_type = $email_template->email_type;
                $subject = $email_template->subject;
                $body = $email_template->body;
                $to = $email;

                $reset_link = URL::route('front.resetAccountlink', ['email_token' => $email_token]);
                //$login_link = ADMIN_URL;
                $body = str_replace(array(
                    '{FIRST_NAME}',
                    '{LAST_NAME}',
                    '{EMAIL}',
                    '{LOGIN_LINK}',
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
                    '{LOGIN_LINK}',
                        ), array(
                    ucfirst($user->first_name),
                    ucfirst($user->last_name),
                    ucfirst($email),
                    $reset_link,
                        ), $subject);


                EmailHelper::sendMail($to, $to, '', $subject, 'default', $body, $email_type);
            //}


            $checkstatus['user_id'] = $user->id;
            $checkstatus['email'] = $user->email;
            $checkstatus['gender'] = $user->gender;
            $checkstatus['phone'] = $user->phone;
            $checkstatus['name'] = $user->first_name;
            $checkstatus['address'] = $user->address;
            $checkstatus['profile_img'] = $user->profile_img;
             $checkstatus['dob'] = $user->dob;
              $checkstatus['looking'] = $user->looking;

            echo json_encode(['message' => 'Active the link on email for registration complete.', 'method' => 'register', 'status' => 'success', 'data' => $checkstatus]);
            exit;
        }
    }

    public function update_profile($data, $file) {
		
        $input = (array) $data;
       
        $checkPhone = User::where('phone', $input['phone'])->where('id', '!=', $input['user_id'])->first();
        if (empty($input['user_id'])) {
            echo json_encode(['message' => 'Please enter user id.', 'method' => 'update_profile', 'status' => 'fail']);
            exit;
        }
        $user = User::findOrFail($input['user_id']);
        if (empty($user)) {
            echo json_encode(['message' => 'User not found.', 'method' => 'update_profile', 'status' => 'fail']);
            exit;
        } elseif (empty($input['phone'])) {
            echo json_encode(['message' => 'Please enter phone No.', 'method' => 'update_profile', 'status' => 'fail']);
            exit;
        } elseif (empty($input['gender'])) {
            echo json_encode(['message' => 'Please select gender.', 'method' => 'update_profile', 'status' => 'fail']);
            exit;
        } elseif (empty($input['address'])) {
            echo json_encode(['message' => 'Please enter address.', 'method' => 'update_profile', 'status' => 'fail']);
            exit;
        }elseif (empty($input['dob'])) {
            echo json_encode(['message' => 'Please enter dob.', 'method' => 'update_profile', 'status' => 'fail']);
            exit;
        } else {
            $date = date('Y-m-d', strtotime($input['dob']));
            $user_data['lat'] = $input['lat'];
            $user_data['lng'] = $input['lng'];

            //$user_data['first_name'] = $input['name'];
            $user_data['phone'] = $input['phone'];
            $user_data['address'] = $input['address'];
            $user_data['gender'] = $input['gender'];
            $user_data['dob'] = $date;
            $user_data['looking'] = $input['looking'];
            
             if (!empty($file)) {
                $destinationPath = 'public/uploads/';
                $fileName = time() . '_' . $file->getClientOriginalName();
                $user_data['profile_img'] = $fileName;
                /* Image::make($attachment_name->getRealPath())->resize('100', '100')->save($destinationPath.'thumbnails/'.$fileName); */
                $file->move($destinationPath, $fileName);
            }

            if ($user->fill($user_data)->save()) {
                $user_data = User::select('id', 'email','looking', 'gender', 'phone', 'lat','dob', 'looking', 'lng', 'first_name', 'varified', 'address', 'created_at', 'updated_at','profile_img')->where('id', $input['user_id'])->where('status', '1')->get()->toArray();

                $checkstatus['user_id'] = $user_data['0']['id'];
                $checkstatus['email'] = $user_data['0']['email'];
                $checkstatus['gender'] = $user_data['0']['gender'];
                $checkstatus['looking'] = $user_data['0']['looking'];
                $checkstatus['phone'] = $user_data['0']['phone'];
                $checkstatus['name'] = $user_data['0']['first_name'];
                $checkstatus['address'] = $user_data['0']['address'];
                $checkstatus['lat'] = $user_data['0']['lat'];
                $checkstatus['lng'] = $user_data['0']['lng'];
                $checkstatus['dob'] = $user_data['0']['dob'];
                $checkstatus['looking'] = $user_data['0']['looking'];
                $checkstatus['profile_img'] = $user_data['0']['profile_img'];
                $checkstatus['created_at'] = $user_data['0']['created_at'];
                $checkstatus['updated_at'] = $user_data['0']['updated_at'];

                echo json_encode(['message' => 'User profile update successfully.', 'method' => 'update_profile', 'status' => 'success', 'data' => $checkstatus]);
                exit;
            } else {
                echo json_encode(['message' => 'User profile not update.', 'method' => 'update_profile', 'status' => 'fail']);
                exit;
            }
        }
    }

    public function user_profile($data) {

        $input = (array) $data;
        $data = array();
        if (empty($input['user_id'])) {
            echo json_encode(['message' => 'Please enter user id.', 'method' => 'user_profile', 'status' => 'fail']);
            exit;
        } else {
            $user = User::select('id as user_id', 'email', 'phone', 'first_name as name', 'profile_img','dob','gender', 'address', 'lat', 'lng', 'created_at', 'updated_at')
                            ->where('varified', '1')->where('status', '1')
                            ->where('role_id', '!=', Config::get('global.role_id.admin'))->where('id', $input['user_id'])
                            ->get()->toArray();
            if (empty($user)) {
                echo json_encode(['message' => 'User not found.', 'method' => 'user_profile', 'status' => 'fail']);
                exit;
            } else {
                foreach ($user as $user_img) {
                    $data['user_id'] = $user_img['user_id'];
                    $data['email'] = $user_img['email'];
                    $data['name'] = $user_img['name'];
                    $data['gender'] = $user_img['gender'];
                    $data['phone'] = $user_img['phone'];
                    $data['address'] = $user_img['address'];
                    $data['lat'] = $user_img['lat'];
                    $data['lng'] = $user_img['lng'];
                    $data['profile_img'] = $user_img['profile_img'];
                    $data['dob'] = $user_img['dob'];
                    $data['created_at'] = $user_img['created_at'];
                    $data['updated_at'] = $user_img['updated_at'];
                }
                echo json_encode(['message' => 'User Profile', 'method' => 'user_profile', 'status' => 'success', 'data' => $data]);
                exit;
            }
        }
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

    public function login($data) {
        $input = (array) $data;

        /*if (empty($input['email'])) {
            echo json_encode(['message' => 'Please enter username.', 'method' => 'login', 'status' => 'fail']);
            exit;
        }*/
        if (empty($input['password'])) {
            echo json_encode(['message' => 'Please enter password.', 'method' => 'login', 'status' => 'fail']);
            exit;
        } /*elseif (empty($input['device_type'])) {
            echo json_encode(['message' => 'Please enter device type ios or android', 'method' => 'login', 'status' => 'fail']);
            exit;
        } *//*elseif (empty($input['device_token'])) {
            echo json_encode(['message' => 'Please enter device token.', 'method' => 'login', 'status' => 'fail']);
            exit;
        }*/
        $arr = ['email' =>$input['email'], 'status' => 1];
        $arr_1 = ['first_name' =>$input['name'], 'status' => 1];
        $user = User::select('id', 'email', 'gender','dob', 'looking','phone', 'first_name', 'profile_img', 'password', 'role_id', 'status', 'varified', 'address', 'lat', 'lng', 'created_at', 'updated_at','payment_status')->where($arr)->orwhere($arr_1)->get()->toArray();

        if (!empty($user)) {

            $password = Hash::check($input['password'], $user['0']['password']);
            if ($password) {
                if ($user['0']['status'] == 1 && $user['0']['varified'] == 1) {
                    $userData = User::findOrFail($user['0']['id']);
                    $userData['device_token'] = $input['device_token'];
                    $userData['device_type'] = $input['device_type'];
                    $userData['device_id'] = $input['device_id'];
                    $userData->save();

                    $checkstatus['user_id'] = $user['0']['id'];
                     $checkstatus['user_type'] = $user['0']['role_id'];
                    $checkstatus['email'] = $user['0']['email'];
                    $checkstatus['gender'] = $user['0']['gender'];
                    $checkstatus['phone'] = $user['0']['phone'];
                    $checkstatus['name'] = $user['0']['first_name'];
                    $checkstatus['address'] = $user['0']['address'];
                    $checkstatus['profile_img'] = $user['0']['profile_img'];
                    $checkstatus['dob'] = $user['0']['dob'];
                    $checkstatus['looking'] = $user['0']['looking'];
                    $checkstatus['lat'] = $user['0']['lat'];
                    $checkstatus['lng'] = $user['0']['lng'];
                    $checkstatus['created_at'] = $user['0']['created_at'];
                    $checkstatus['updated_at'] = $user['0']['updated_at'];
                    $checkstatus['payment_status'] = $user['0']['payment_status'];

                    echo json_encode(['message' => 'Login successful done', 'method' => 'login', 'status' => 'success', 'data' => $checkstatus]);
                    exit;
                } else {
                    echo json_encode(['message' => 'Your account is not active.', 'method' => 'login', 'status' => 'fail']);
                    exit;
                }
            } else {
                echo json_encode(['message' => 'Wrong  password.', 'method' => 'login', 'status' => 'fail']);
                exit;
            }
        } else {
            echo json_encode(['message' => 'Wrong User Name.', 'method' => 'login', 'status' => 'fail']);
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

    public function api_logout($data) {
        $input = (array) $data;
        if (empty($input['user_id'])) {
            echo json_encode(['message' => 'Please enter user id.', 'method' => 'api_logout', 'status' => 'fail']);
            exit;
        }
        if (isset($input['user_id'])) {
            $userData = User::find($input['user_id']);
            if (!empty($userData)) {
                $inputdata['device_type'] = '';
                $inputdata['device_token'] = '';
                $inputdata['device_id'] = '';
                $userData->fill($inputdata)->save();
                echo json_encode(['message' => 'User logout successfully', 'method' => 'api_logout', 'status' => 'success']);
                exit;
            } else {
                echo json_encode(['message' => 'Invalid User', 'method' => 'api_logout', 'status' => 'fail']);
                exit;
            }
        } else {
            echo json_encode(['message' => 'Invalid User', 'method' => 'api_logout', 'status' => 'fail']);
            exit;
        }
    }
    
    
    public function upgrade_profile($data) {

        $input = (array) $data;
        $data = array();
        if (empty($input['buyer_id'])) {
            echo json_encode(['message' => 'Please enter Customer id.', 'method' => 'upgrade_profile', 'status' => 'fail']);
            exit;
        } else {
            $is_update = User::where('id', $input['buyer_id'])
                    ->update(['role_id' => 3]);            
            if($is_update){
                echo json_encode(['message' => trans('front.UPGRADE_PROFILE_BUYER'), 'method' => 'upgrade_profile', 'status' => 'success']);
                exit;
            }else{
                
                echo json_encode(['message' => 'Not Upgrade', 'method' => 'upgrade_profile', 'status' => 'fail']);
                exit;
            }
            
        }
    }
    
    public function contactList() {
        $users = Contact::sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
       
        $pageTitle = "Contact List";
        $title = 'Contact List';
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';

        //pr($users);
        $breadcrumb = array('pages' => $pages, 'actives' => 'Contact List', 'active' =>'admin_contacts.contact_list');
        setCurrentPage('admin.contacts');

        return view('admin.contacts.contact_list', compact('users', 'pageTitle', 'title', 'breadcrumb'));
    }
    
}
