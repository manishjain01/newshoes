<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\BasicFunction;
use Validator;
use App\NewsletterCampaign;
use App\NewsletterSubscriber;
use App\Newsletters;
use App\Newsletter;

class NewsletterController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $newsletterlist = Newsletter::sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
  
//pr($newsletterlist);exit;
        $pageTitle = 'Subscribes List';
        $title = trans('admin.NEWSLETTER_TEMPLATE');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'actives' => 'Subscribes List', 'active' =>'admin.newsletter.index');
        setCurrentPage('admin.newsletter');

        return view('admin.newsletter.index', compact('newsletterlist', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $pageTitle = trans('admin.NEWSLETTER_TEMPLATE');
        $title = trans('admin.NEWSLETTER_TEMPLATE');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.NEWSLETTER_TEMPLATE')] = 'admin.newsletter.index';


        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.ADD_NEWSLETTER_TEMPLATE'), 'active' =>'admin.newsletter.index');

        return view('admin.newsletter.create', compact('pageTitle', 'title', 'breadcrumb'));
    }  


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $newsletterObj = new Newsletters();


        $validator = validator::make($request->all(), [
                    'title' => 'required|max:255',
                    'subject' => 'required|max:255',
                    'body' => 'required',
              
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\NewsletterController@create')
                            ->withErrors($validator)
                            ->withInput();
        }


        $input = $request->all();
        

        $newsletter = $newsletterObj->create($input);
        return redirect()->action('Admin\NewsletterController@index', getCurrentPage('admin.newsletter'))->with('alert-sucess', trans('admin.NEWSLETTER_TEMPLATE_ADD_SUCCESSFULLY'));
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
        $newsletter = Newsletters::find($id);
        if (empty($newsletter)) {
            return $this->InvalidUrl();
        }

        $pageTitle = trans('admin.NEWSLETTER_TEMPLATE');
        $title = trans('admin.NEWSLETTER_TEMPLATE');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.NEWSLETTER_TEMPLATE')] = 'admin.newsletter.index';


        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.EDIT_NEWSLETTER_TEMPLATE'), 'active' =>'admin.newsletter.index');

        return view('admin.newsletter.edit', compact('newsletter', 'pageTitle', 'title', 'breadcrumb'));
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
                    'title' => 'required|max:255',
                    'subject' => 'required|max:255',
                    'body' => 'required',
              
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\NewsletterController@edit',$id)
                            ->withErrors($validator)
                            ->withInput();
        }



        $newsletter = Newsletters::findOrFail($id);
        $input = $request->all();
        $newsletter->fill($input)->save();
        return redirect()->action('Admin\NewsletterController@index', getCurrentPage('admin.newsletter'))->with('alert-sucess', trans('admin.NEWSLETTER_TEMPLATE_UPDATE_SUCCESSFULLY'));
    }


    /**
     * Function To chnage Status of Newsletter
     *
     * @param  int  $id id of cms pages
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
        $newsletter = Newsletters::where('id', '=', $id)->first();
        $newsletter->status = $new_status;
        $newsletter->save();
        return redirect()->action('Admin\NewsletterController@index', getCurrentPage('admin.newsletter'))->with('alert-sucess', trans('admin.NEWSLETTER_TEMPLATE_CHANGE_STATUS_SUCCESSFULLY'));
    } 
    /**
     * Function To delete  Newsletter
     *
     * @param  int  $id id of Newsletter
     * @return \Illuminate\Http\Response
     */
    public function delete($id) {

        if (empty($id)) {
            return $this->InvalidUrl();
        }
       
        $newsletter = Newsletters::where('id', '=', $id)->first();
        $newsletter->is_deleted = 1;
        $newsletter->save();
        return redirect()->action('Admin\NewsletterController@index', getCurrentPage('admin.newsletter'))->with('alert-sucess', trans('admin.NEWSLETTER_TEMPLATE_DELETE_SUCCESSFULLY'));
    }

    /**
     * manage schedule.
        @param  int  $id id of Newsletter
     * @return \Illuminate\Http\Response
     */
    public function manageSchedule($id) {
        if (empty($id)) {
            return $this->InvalidUrl();
        }
        $newsletter = Newsletters::find($id);
        if (empty($newsletter)) {
            return $this->InvalidUrl();
        }
        $pageTitle = trans('admin.MANAGE_SCHEDULE');
        $title = trans('admin.MANAGE_SCHEDULE');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.NEWSLETTER_TEMPLATE')] = 'admin.newsletter.index';
        $user_list =    NewsletterSubscriber::where('status','=',1)->orderBy('email')->lists('email', 'email')->toArray();;

        $breadcrumb = array('pages' => $pages, 'actives' => trans('admin.MANAGE_SCHEDULE'), 'active' =>'admin.newsletter.index');

        return view('admin.newsletter.manage_schedule', compact('pageTitle', 'title', 'breadcrumb','user_list','newsletter'));
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manageScheduleStore(Request $request, $id) {


        $validator = validator::make($request->all(), [
                    'email' => 'required|max:255',
                    'schedule_time' => 'required|max:255',
                   
              
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\NewsletterController@manageSchedule',$id)
                            ->withErrors($validator)
                            ->withInput();
        }


        $newsletterCampObj = New NewsletterCampaign();

        $input = $request->all();
        foreach ($input['email'] as $key => $value) {
           $data    =   array();
           $data['newsletter_id']    =   $id;
           $data['email']            =   $value;
           $data['schedule_time']    =   str2time($input['schedule_time']);
           $data['newsletter_id']    =   $id;
           $newsletterCampObj->create($data);
        
        }

    
     
        return redirect()->action('Admin\NewsletterController@index', getCurrentPage('admin.newsletter'))->with('alert-sucess', trans('admin.NEWSLETTER_SCHEDULED_SUCCESSFULLY'));
    }

}
