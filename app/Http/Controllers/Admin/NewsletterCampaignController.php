<?php

namespace App\Http\Controllers\Admin;

use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\BasicFunction;
use Validator;
use EmailHelper;
use App\NewsletterCampaign;
use App\Newsletters;
use App\EmailTemplate;


class NewsletterCampaignController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $newsletter_campaign = NewsletterCampaign::with('newsletterName')->where('is_deleted','=','0')->sortable(['created_at' => 'desc'])->paginate(Configure('CONFIG_PAGE_LIMIT'));
        

        $pageTitle = trans('admin.NEWSLETTER_CAMPAIGN');
        $title = trans('admin.NEWSLETTER_CAMPAIGN');
        /*         * breadcrumb* */
        $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';


        $breadcrumb = array('pages' => $pages, 'active' => trans('admin.NEWSLETTER_CAMPAIGN'));
        setCurrentPage('admin.newsletter_campaign');

        return view('admin.newsletter-campaign.index', compact('newsletter_campaign', 'pageTitle', 'title', 'breadcrumb'));
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
        $newsletter = NewsletterCampaign::where('id', '=', $id)->first();
        $newsletter->status = $new_status;
        $newsletter->save();
        return redirect()->action('Admin\NewsletterCampaignController@index', getCurrentPage('admin.newsletter_campaign'))->with('alert-sucess', trans('admin.NEWSLETTER_CAMPAIGN_CHANGE_STATUS_SUCCESSFULLY'));
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
       
       
        $newsletterCamp =  NewsletterCampaign::find($id)->delete();
        return redirect()->action('Admin\NewsletterCampaignController@index', getCurrentPage('admin.newsletter_campaign'))->with('alert-sucess', trans('admin.NEWSLETTER_CAMPAIGN_DELETE_SUCCESSFULLY'));
    }

    /**
     * manage schedule.
        @param  int  $id id of Newsletter
     * @return \Illuminate\Http\Response
     */
    public function sendMail($id) {
        if (empty($id)) {
            return $this->InvalidUrl();
        }
        $newsletterCamp = NewsletterCampaign::find($id);
        if (empty($newsletterCamp)) {
            return $this->InvalidUrl();
        }

        $newsletters_data    =      Newsletters::find($newsletterCamp->newsletter_id);
        

        $email_template = EmailTemplate::where('slug', '=', 'newsletter')->first();
        $email_type = $email_template->email_type;

        $subject = $newsletters_data->subject;

        $body = $email_template->body;
        $to = $newsletterCamp->email;
        $name = '';
        $content =  $newsletters_data->body;

        if($newsletterCamp->fist_name !='' || $newsletterCamp->last_name){

            $name = ucfirst($newsletterCamp->fist_name.' '.$newsletterCamp->last_name);
        }

        $login_link = WEBSITE_URL;
            $unsubscribe_link   ="<a href='".$login_link."'> Click Here</a>"  ;
        $body = str_replace(array(
            '{NAME}',
            '{CONTENT}',
            '{UNSUBSCRIBE_LINK}',
            '{EMAIL}',
           
                ), array(
            ucfirst($name),
            ucfirst($content),
            
            $unsubscribe_link,
            $to,
         
                ), $body);  
       
        $subject = str_replace(array(
            '{NAME}',
            '{CONTENT}',
            '{UNSUBSCRIBE_LINK}',
           
                ), array(
            ucfirst($name),
            ucfirst($content),
            
            $unsubscribe_link,
            $to,
         
                ), $subject);
  

 
        EmailHelper::sendMail($to, '', '', $subject, 'default', $body, $email_type);

        $newsletter = NewsletterCampaign::where('id', '=', $id)->first();
        $newsletter->mail_send = 1;
        $newsletter->save();


    return redirect()->action('Admin\NewsletterCampaignController@index', getCurrentPage('admin.newsletter_campaign'))->with('alert-sucess', trans('admin.NEWSLETTER_SENDED_SUCCESSFULLY'));

        
    }


   

}
