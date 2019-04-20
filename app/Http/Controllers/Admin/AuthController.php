<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;    
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

    protected $guard = 'admin';
    protected $redirectAfterLogout = '/admin';
     protected $loginPath = 'admin/login';

    protected $redirectTo = '/admin/dashboard';

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
public function postLogin(Request $request)
{
    //echo "hello";exit;
      $validator = validator::make($request->all(),[
        'email' => 'required|email', 'password' => 'required',
    ]);
        if ($validator->fails()) {
            return redirect($this->loginPath)
                        ->withErrors($validator)
                        ->withInput();
        }
        
    $credentials = $this->getCredentials($request);
    
    $credentials['role_id'] =   1;

    if (Auth::guard('admin')->attempt($credentials, $request->has('remember'))) {
    
  $admin = adminUser();
        return redirect()->intended($this->redirectPath())->with('alert-sucess', trans('admin.LOGIN_SUCCESSFULLY', ['site_tite'=>Configure('CONFIG_SITE_TITLE'),'Name' => $admin->first_name]));

    }

    return redirect($this->loginPath)
        ->withInput($request->only('email', 'remember'))
        ->withErrors([
            'email' => $this->getFailedLoginMessage(),
        ])->with('alert-error', trans('admin.LOGIN_EMAIL_PASSWORD_NOT_MATCH'));
    
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
       Auth::guard('admin')->logout();

        return redirect()->route('admin.login')->with('alert-sucess', trans('admin.LOGOUT_SUCCESSFULLY'));
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

    public function authenticate() {
        
        if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password, 'role_id' => 1], $remember)) {
            // Authentication passed...
           
             return redirect()->intended($this->redirectTo);
        } else {
            return redirect::to('auth/login');
        }
    }
    
  

}
