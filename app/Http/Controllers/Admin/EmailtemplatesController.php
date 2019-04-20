<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\EmailTemplate;
use Validator;

class EmailtemplatesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $emailtemplates = EmailTemplate::sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        $title = trans('admin.EMAIL_TEMPLATES');
        $pageTitle = trans('admin.EMAIL_TEMPLATES');

        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.EMAIL_TEMPLATES'), 'active' =>'admin.emailtemplates.index');
        //  dd($emailtemplates);  
        return view('admin.emailtemplates.index', compact('emailtemplates', 'title', 'pageTitle', 'breadcrumb', 'controller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {


        $emailtemplates = EmailTemplate::find($id);
        $title = "Edit Email Template";
        $pageTitle = "Edit Email Template";
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.EMAIL_TEMPLATES')] = 'admin.emailtemplates.index';

        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.EMAIL_TEMPLATES'), 'active' =>'admin.emailtemplates.index');
        return view('admin.emailtemplates.edit', compact('emailtemplates', 'title', 'pageTitle', 'breadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //check is user has permissions 
        /* $validator = validator::make($request->all(), [
          'name' => 'required|max:255',
          'description' => 'required',
          'meta_title' => 'required',
          'meta_keywords' => 'required',
          'meta_description' => 'required',
          ]);
          if ($validator->fails()) {
          return redirect()->action('Admin\EmailtemplatesController@edit' ,$id)
          ->withErrors($validator)
          ->withInput();
          }

         */
        $this->validate($request, [
            'name' => 'required|max:255',
            'subject' => 'required',
            'body' => 'required',
        ]);

        $emailtemplates = EmailTemplate::findOrFail($id);
        //$input = $request->all();
        $input['name'] = $request->name;
        $input['subject'] = $request->subject;
        $input['body'] = $request->body;
        $emailtemplates->fill($input)->save();
        return redirect()->action('Admin\EmailtemplatesController@index')->with('alert-sucess', 'Email template updated successfully.');
    }

}
