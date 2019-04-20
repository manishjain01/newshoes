<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Session;
use Agent;
use GeoIP;
use Auth;
use App\VisitorLog;

class VisitorHelper {

    public static function recordActivity() {

        $request = Request();
        $current_page_full_url = $request->fullUrl();
      
        $url = $current_page_full_url . '$$ ' . time();
        $session_id = Session::getId();

        $visitor_detail = VisitorLog::where('session_id', $session_id)->first();
       
        
        if (!empty($visitor_detail)) {
            $visitor = VisitorLog::find($visitor_detail->id);
            if ($visitor_detail->view_pages!='') {
                if (strstr($visitor_detail->view_pages, $current_page_full_url)) {
                    $url = $visitor_detail->view_pages;
                                        
   
                } else {
                    
                    $url = $visitor_detail->view_pages . ',' . $url;
                }
            }else{
               
                
            }
             
            $visitor->view_pages = $url;
        } else {
            $visitor = new VisitorLog();
            $visitor->session_id = $session_id;
            if (Auth::guard('admin')->check()) {
                 $admin = adminUser();
                 $visitor->visitor_id =     $admin['id'];
                 $visitor->visitor_type =     'Onymous' ;
                 $visitor->visitor_name =   ucfirst($admin['first_name'].' '.$admin['last_name']);
                 
            }else{
                $visitor->visitor_id = 0;
                $visitor->visitor_name = 'Anonymous';
                $visitor->visitor_name = 'Anonymous';

            }

            $visitor->visitor_ip = ip2long($_SERVER['REMOTE_ADDR']);
            $visitor->visit_time = time();


            $visitor->view_pages = $url;

            $browser_name = Agent::browser();
            $visitor->browser_name = Agent::browser();
            $visitor->browser_version = Agent::version($browser_name);
            $is_phone = Agent::isPhone();
            if ($is_phone) {
              $visitor->user_browser_device = Agent::device();

               
            } else {
            
                 $visitor->user_browser_device = Agent::platform() ;
            }
          /*  $location = GeoIP::getLocation($_SERVER['REMOTE_ADDR']);
            $visitor->country_name = $location['country'];
            $visitor->city = $location['city'];
            $visitor->latitude = $location['lat'];
            $visitor->longitude = $location['lon'];*/
            $visitor->clicked_from = $request->server('HTTP_REFERER');
        }

       
        $visitor->save();

        return true;
    }

}

?>