<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use App\EmailTemplate;
use App\Cart;
use App\Helpers\EmailHelper;
use Input;
use Config;
use URL;
use Session;
use Socialite;
use Mbarwick83\Instagram\Instagram;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

    protected $guard = 'web';
    protected $redirectAfterLogout = '/';
    protected $loginPath = 'login';
    protected $redirectTo = '/changePassword';

    use AuthenticatesAndRegistersUsers,
        ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    //protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    /* public function __construct()
      {
      $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
      } */

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:ar_users',
                    'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register() {


        $from = "info@pepealoans.com";
        $password = Input::get('password');
        $checkEmail = User::where('email', Input::get('email'))->first();
        $checkPhone = User::where('phone', Input::get('phone'))->first();
        $checkName = User::where('first_name', Input::get('name'))->first();


        if (empty(Input::get('first_name'))) {
            echo json_encode(['message' => 'Please enter First Name.']);
            exit;
        } elseif (empty(Input::get('last_name'))) {
            echo json_encode(['message' => 'Please enter Last name.']);
            exit;
        } elseif (empty(Input::get('email'))) {
            echo json_encode(['message' => 'Please enter email.']);
            exit;
        } elseif (empty(Input::get('phone'))) {
            echo json_encode(['message' => 'Please enter phone No.']);
            exit;
        } elseif (empty(Input::get('password'))) {
            echo json_encode(['message' => 'Please enter password.']);
            exit;
        } elseif (!empty($checkEmail)) {
            echo json_encode(['message' => 'An account with this email address already exists.']);
            exit;
        } /* elseif (!empty($checkPhone)) {
          echo json_encode(['message' => 'An account with this number already exists.', 'method' => 'register', 'status' => 'fail']);
          exit;
          } */ elseif (!empty($checkName)) {
            echo json_encode(['message' => 'An account with this name already exists.']);
            exit;
        } elseif (empty(Input::get('confirm_password'))) {
            echo json_encode(['message' => 'please enter confirm password.']);
            exit;
        } elseif (Input::get('password') != Input::get('confirm_password')) {
            echo json_encode(['message' => "Password and Confirm password don't match."]);
            exit;
        } else {

            $ip_address = $_SERVER['REMOTE_ADDR'];

            $userData['role_id'] = 2;
            $userData['status'] = 1;
            /* if (!empty($input['lat'])) {
              $userData['lat'] = $input['lat'];
              }
              if (!empty($input['lng'])) {
              $userData['lng'] = $input['lng'];
              } */
            $userData['first_name'] = Input::get('first_name');
            $userData['last_name'] = Input::get('last_name');
            $userData['ip_address'] = $ip_address;
            $userData['email'] = Input::get('email');
            $userData['phone'] = Input::get('phone');


            $userData['email_token'] = md5(uniqid(rand(), true));
            $userData['password'] = Hash::make(Input::get('password'));
            $userData['pwd'] = Input::get('password');
            $userData['login_mode'] = 'manual';
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


            EmailHelper::sendMail($to, $from, '', $subject, 'default', $body, $email_type);
            //}


            $checkstatus['user_id'] = $user->id;
            $checkstatus['email'] = $user->email;
            $checkstatus['gender'] = $user->gender;
            $checkstatus['phone'] = $user->phone;
            $checkstatus['first_name'] = $user->first_name;

            echo json_encode(['message' => 'Activate the link on email for registration complete.', 'status' => 'success', 'data' => $checkstatus]);
            exit;
        }
    }

    public function postLogin(Request $request) {
        $msg['message'] = "";
        $session_id = session()->getId();
        if (empty(Input::get('email'))) {
            $msg['message'] = "Please enter Email.";
        } elseif (empty(Input::get('password'))) {
            $msg['message'] = "Please enter password.";
        } else {
            $userData = User::select('id', 'email', 'password', 'payment_status')->where('email', Input::get('email'))->get()->toArray();
            if (!empty($userData)) {
                $password = Hash::check(Input::get('password'), $userData['0']['password']);
                if (!empty($password)) {
                    if ($this->authenticate($userData['0']['email'], Input::get('password'), $userData['0']['email'])) {
                        $is_update = Cart::where('session_id', $session_id)
                                ->update(['user_id' => $userData['0']['id']]);
                        $delete_cart = "DELETE p1 FROM cart p1 INNER JOIN cart p2 WHERE p1.id < p2.id AND p1.product_id = p2.product_id AND p1.color_id = p2.color_id AND p1.size_id = p2.size_id AND p1.user_id = ?";
                       \DB::delete($delete_cart, array($userData['0']['id']));
                        //pr($is_update);exit; 
                        //if ($user['0']['status'] == 1 && $user['0']['varified'] == 1) {
                        $msg['status'] = "success";
                        $msg['payment_status'] = $userData['0']['payment_status'];
                        /* if($userData['0']['payment_status'] == 1){
                          //$msg['message'] = "successfully login click here to <a href = 'myaccount' >myaccount</a>";
                          $msg['message'] = "successfully login.";
                          }else{
                          //$msg['message'] = "successfully login click here to <a href = 'membershipplan' >membershipplan</a>";
                          $msg['message'] = "successfully login.";
                          } */
                        $msg['message'] = "Login Successfully";
                        //$msg['data'] = $checkstatus;
                        //return \Redirect::back();
                        //return Redirect::route('myaccount');
                    } else {
                        $msg['message'] = "Your account is not active.";
                    }
                } else {
                    $msg['message'] = "Incorrect Password";
                }
            } else {
                $msg['message'] = "Email id does not exist.";
            }
        }
        echo json_encode($msg);
    }

    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function getLogin() {

        return view('admin.auth.login');
    }

    public function getLogout() {
        session()->forget('ORDER_NO');
        $session_id = session()->getId();
        Session::forget(session()->getId()); 
        //session()->forget(session()->getId());
        Cart::where('session_id', $session_id)
                        ->update(['session_id' => $session_id.'123']);
        Auth::guard('web')->logout();
        return redirect()->route('home')->with('alert-sucess', trans('admin.LOGOUT_SUCCESSFULLY'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }

    public function authenticate($email, $password, $remember) {

        if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password, 'varified' => 1, 'status' => 1], $remember)) {
            // Authentication passed...

            return redirect()->intended($this->redirectTo);
        } else {
            //return redirect::to('login');
            return false;
        }
    }

    public function redirectToProvider() {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback() {
        $user = Socialite::driver('facebook')->user();
        $name = explode(" ", $user->name);
        $session_id = session()->getId();

        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            if ($this->authenticate($user->email, $authUser->pwd, $user->email)) {
                $is_update = Cart::where('session_id', $session_id)
                        ->update(['user_id' => $authUser->id]);
                return redirect()->action('Front\UsersController@myaccount');
            }
        } else {
            $pwd = '123456';
            $users = User::create([
                        'first_name' => $name[0],
                        'last_name' => $name[1],
                        'email' => $user->email,
                        'profile_img' => $user->avatar,
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'role_id' => 2,
                        'status' => 1,
                        'email_token' => md5(uniqid(rand(), true)),
                        'password' => Hash::make($pwd),
                        'pwd' => $pwd,
                        'varified' => 1,
                        'login_mode' => 'facebook'
                            //'provider' => $provider,
                            //'provider_id' => $user->id
            ]);
            if ($users) {
                $password = Hash::check($pwd, $users->password);
                if ($this->authenticate($users->email, $pwd, $users->email)) {
                    $is_update = Cart::where('session_id', $session_id)
                            ->update(['user_id' => $users->id]);
                    return redirect()->action('Front\UsersController@myaccount');
                }
            }
        }
    }

    // Get login url:
    public function insta_login(Instagram $instagram) {
        //pr($instagram);exit;
        
        $data = $instagram->getLoginUrl();
        //$access_token = getAccessToken($code);
        //$data = $instagram->get('v1/users/self', ['access_token' => $access_token]);
         //$data = $instagram->get('v1/users/' $user-id, ['access_token' => $access_token]);
        //return $data;
        return redirect($data);
    }

    // Get access token on callback, once user has authorized via above method
    public function callback(Request $request, Instagram $instagram) {
        $response = $instagram->getAccessToken($request->code);
        
        $name = explode(" ", $response['user']['full_name']);
        $session_id = session()->getId();

        $authUser = User::where('instagram_username', $response['user']['username'])->first();
        if ($authUser) {
            //return $authUser;
            if ($this->authenticate($authUser->email, $authUser->pwd, $authUser->email)) {
                $is_update = Cart::where('session_id', $session_id)
                        ->update(['user_id' => $authUser->id]);
                return redirect()->action('Front\UsersController@myaccount');
            }
        } else {
            $pwd = '123456';
            $users = User::create([
                        'first_name' => $name[0],
                        'last_name' => $name[1],
                        'email' => $response['user']['username'].'@gmail.com',
                        'instagram_username' => $response['user']['username'],
                        'profile_img' => $response['user']['profile_picture'],
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'role_id' => 2,
                        'status' => 1,
                        'email_token' => md5(uniqid(rand(), true)),
                        'password' => Hash::make($pwd),
                        'pwd' => $pwd,
                        'varified' => 1,
                        'login_mode' => 'instagram'
                            //'provider' => $provider,
                            //'provider_id' => $user->id
            ]);
            if ($users) {
                $password = Hash::check($pwd, $users->password);
                if ($this->authenticate($users->email, $pwd, $users->email)) {
                    $is_update = Cart::where('session_id', $session_id)
                            ->update(['user_id' => $users->id]);
                    return redirect()->action('Front\UsersController@myaccount');
                }
            }
        }
        
       
//pr($response);exit;
        if (isset($response['code']) == 400) {
            throw new \Exception($response['error_message'], 400);
        }

        //return $response['access_token'];
    }

}
