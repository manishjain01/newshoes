<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Support\Facades\Auth;
use File;
use Validator;

class SettingsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $setting = Setting::find(1);
        $pageTitle = 'Site Configuration';
        $title = 'Site Configuration';
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' => 'Site Configuration','active' =>'admin.settings.index');

        return view('admin.settings.index', compact('setting', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {




        $validator = validator::make($request->all(), [
                    'site_title' => 'required|max:255',
                    'page_limit' => 'required|numeric',
                    'front_page_limit' => 'required|numeric',
                    'fromemail' => 'required|email|max:255',
                    'reply_to_email' => 'required|email|max:255',
                    'staff_mail' => 'required|email|max:255',
                    'from_name' => 'required|max:255',
                    'copyright' => 'required|max:255',
                    'shipping_amount' => 'required|numeric',
                    'meta_description' => 'required',
                    'meta_title' => 'required',
                    'meta_keywords' => 'required',
                    'email_signature' => 'required',
                    'phone' => 'required|phone|max:10',
                    'postal_address' => 'required',
                    'facebook' => 'url',
                    'linkedin' => 'url',
                    'twitter' => 'url',
                    'thumblr' => 'url',
                    'imgur' => 'url',
                    'pinterest' => 'url',
                    'gplus' => 'url',
                    'instagram' => 'url',
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\SettingsController@index')
                            ->withErrors($validator)
                            ->withInput();
        }



        $setting = Setting::findOrFail($id);
        $input = $request->all();
        $setting->fill($input)->save();
        $setting = Setting::find(1)->toArray();
        $filename = 'f' . gmdate('YmdHis');
        $path = base_path() . '/config/';
        File::put($path . $filename, '<?php ' . "\n");
        File::append($path . $filename, 'return [ ' . "\n");

        foreach ($setting as $key => $value) {
            $constant = "CONFIG_" . strtoupper($key);
            File:: append($path . $filename, '"' . $constant . '"   =>   "' . addslashes($value) . '",' . "\n");
        }
        File:: append($path . $filename, ' ];');
        @rename($path . $filename, $path . 'settings.php');





        return redirect()->action('Admin\SettingsController@index')->with('alert-sucess', 'Site configuration save successfully.');
        ;
    }

}
