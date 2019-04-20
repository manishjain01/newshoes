<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use URL;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\EmailLog;
use Illuminate\Support\Facades\Auth;

class EmailLogsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $EmailLogObj = new EmailLog();
        $email_log = $EmailLogObj->sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        $pageTitle = trans('admin.EMAIL_LOG');
        $title = trans('admin.EMAIL_LOG');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.EMAIL_LOG'));

        return view('admin.email_logs.index', compact('email_log', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id) {
        $email_log = EmailLog::find($id);
        $pageTitle = trans('admin.EMAIL_LOG');
        $title = trans('admin.EMAIL_LOG');
        /*         * breadcrumb* */

        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.EMAIL_LOG')] = 'admin.emaillogs.index';
        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.VIEW_EMAIL_LOG'));

        return view('admin.email_logs.view', compact('email_log', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $grades = EmailLog::find($id)->delete();
        return redirect()->action('Admin\EmailLogsController@index')->with('alert-sucess', trans('admin.EMAILLOG_DELETED_SUCCESSFULLY'));
    }

}
