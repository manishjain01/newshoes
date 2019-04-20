<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\NewsletterSubscriber;
use App\Helpers\BasicFunction;
use Validator;

class NewsletterSubscriberController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $newsletter_subscriber = NewsletterSubscriber::sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        ;

        $pageTitle = trans('admin.ALL_SUBSCRIBERS');
        $title = trans('admin.ALL_SUBSCRIBERS');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.ALL_SUBSCRIBERS'));
        setCurrentPage('admin.newsletter-subscriber');

        return view('admin.newsletter-subscriber.index', compact('newsletter_subscriber', 'pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $pageTitle = trans('admin.ADD_SUBSCRIBERS');
        $title = trans('admin.ADD_SUBSCRIBERS');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.ALL_SUBSCRIBERS')] = 'admin.newsletter-subscriber.index';


        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.ADD_SUBSCRIBERS'));

        return view('admin.newsletter-subscriber.create', compact('pageTitle', 'title', 'breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $newsletter_subscriberObj = new NewsletterSubscriber();


        $validator = validator::make($request->all(), [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:newsletter_subscribers',
              
        ]);
        if ($validator->fails()) {
            return redirect()->action('Admin\NewsletterSubscriberController@create')
                            ->withErrors($validator)
                            ->withInput();
        }


        $input = $request->all();
        

        $newsletter = $newsletter_subscriberObj->create($input);
        return redirect()->action('Admin\NewsletterSubscriberController@index', getCurrentPage('admin.newsletter-subscriber'))->with('alert-sucess', trans('admin.SUBSCRIBERS_ADD_SUCCESSFULLY'));
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
        $newsletter_subscriber = NewsletterSubscriber::find($id);
        if (empty($newsletter_subscriber)) {
            return $this->InvalidUrl();
        }

        $pageTitle = trans('admin.EDIT_SUBSCRIBERS');
        $title = trans('admin.EDIT_SUBSCRIBERS');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        $pages[trans('admin.ALL_SUBSCRIBERS')] = 'admin.newsletter-subscriber.index';


        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.EDIT_SUBSCRIBERS'));

        return view('admin.newsletter-subscriber.edit', compact('newsletter_subscriber', 'pageTitle', 'title', 'breadcrumb'));
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
        $newsletter_subscriber = NewsletterSubscriber::findOrFail($id);


        $validator = validator::make($request->all(), [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:newsletter_subscribers,email,' . $newsletter_subscriber->id,
              
        ]);

      
        if ($validator->fails()) {
            return redirect()->action('Admin\NewsletterSubscriberController@edit',$id)
                            ->withErrors($validator)
                            ->withInput();
        }



        
        $input = $request->all();
        $newsletter_subscriber->fill($input)->save();
        return redirect()->action('Admin\NewsletterSubscriberController@index', getCurrentPage('admin.newsletter-subscriber'))->with('alert-sucess', trans('admin.SUBSCRIBERS_UPDATE_SUCCESSFULLY'));
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
        $newsletter_subscriber = NewsletterSubscriber::where('id', '=', $id)->first();
        $newsletter_subscriber->status = $new_status;
        $newsletter_subscriber->save();
        return redirect()->action('Admin\NewsletterSubscriberController@index', getCurrentPage('admin.newsletter-subscriber'))->with('alert-sucess', trans('admin.SUBSCRIBERS_CHANGE_STATUS_SUCCESSFULLY'));
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
        $newsletter_subscriber =  NewsletterSubscriber::find($id)->delete();
        return redirect()->action('Admin\NewsletterSubscriberController@index', getCurrentPage('admin.newsletter-subscriber'))->with('alert-sucess', trans('admin.SUBSCRIBERS_DELETE_SUCCESSFULLY'));
    }

}
