<?php

namespace App\Helpers;

use App\Helpers\BasicFunction;
use App\Helpers\GlobalHelper;
use App\Helper\Push;
use App\Helper\Firebase;
use Mail;
use view;
use App\EmailLog;

class EmailHelper {

    // (Android)API access key from Google API's Console.
    private static $API_ACCESS_KEY = 'AIzaSyCT3qEEbRrtsd_DAg2PYN_ynvgAiUydxCk';
    //private static $API_ACCESS_KEY = 'AIzaSyAL_9qqiExojgPpicKyruXrMTQVdQgbRWk';
    // (iOS) Private key's passphrase.
    private static $passphrase = '123456';

    public static function sendMail($to, $from, $replyTo, $subject, $layout = 'default', $body = '', $email_type = '', $attachments = "", $sendAs = 'html', $bcc = array()) {
        $data = array();

        $body = str_replace(array(
            '{EMAIL_SIGNATURE}',
            '{SITE_TITLE}'
                ), array(
            nl2br(Configure('CONFIG_EMAIL_SIGNATURE')),
            Configure('CONFIG_SITE_TITLE')
                ), $body);




        $data['body'] = $body;
        $data['pathToFile'] = WEBSITE_IMG_URL . 'logo.jpeg';

        $fromName = Configure('CONFIG_FROM_NAME');
        if ($from == '') {
            $from = Configure('CONFIG_FROMEMAIL');
        }

        if ($replyTo == '') {
            $replyTo = Configure('CONFIG_REPLY_TO_EMAIL');
        }



        $datas = Mail::send('emails.' . $layout, $data, function ($message) use ($from, $fromName, $to, $replyTo, $subject, $bcc, $attachments) {

                    $message->from($from, $fromName);

                    $message->to($to, $name = null);

                    if (!empty($bcc)) {
                        $message->bcc($bcc, $name = null);
                    }
                    $message->replyTo($replyTo, $name = null);
                    $message->subject($subject);
                    // $message->priority($level);
                    if ($attachments != '') {
                        $message->attach($attachments);
                    }


                    // Get the underlying SwiftMailer message instance...
                    $message->getSwiftMessage();
                });


        $email_log = new EmailLog();
        $email_log->email_to = $to;
        $email_log->email_from = $from;
        $email_log->email_type = $email_type;
        $email_log->subject = $subject;
        $email_log->message = view('emails.' . $layout, $data)->render();
        $email_log->save();
    }

  
    
    
     public static function sendNotification($title, $message, $device_token, $count, $userid, $name, $profile_img) {
        $ch = curl_init("https://fcm.googleapis.com/fcm/send");
        $key = 'AAAAtxXUa0s:APA91bE47SWz1m4gBRJTizcFJw56L3yQrUmeBhxB_Nh7_ZkWuQ5HkKJ_YNXLlpjO8ITaLWCflRycS0rCFAK3lNaJ418S9tALsT-72X0-smGxHjyZ2VebpvXTY9SvTnYI5xQoK7RhS9cT';

        
        /*if($type == 'Chat'){
            $action = 'com.nixbin.MeetNepali.chat.ChatScreenActivity';
        }else{
            $action = 'com.nixbin.MeetNepali.activities.FriendRequestActivity';
        }*/
        $notification = array('title' => $title, 'text' => $message, 'badge' => $count);
        //pr($notification);
        $data = array('title' => $title, 'text' => $message, 'userid' => $userid,  'username'=>$name,'profile_img'=>$profile_img);
        $arrayToSend = array('to' => $device_token, 'notification' => $notification,'data' => $data, 'priority' => 'high');
        //pr($arrayToSend);exit;

        $json = json_encode($arrayToSend);
        //pr($json);exit;

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key= AAAA5ZiF6Q8:APA91bFYBbsoUSB2sVdbLh6XDdsPf_wNaqfkxwDxatS4VpwGIGfQzDwOmt1ld0xoIrr8Cc5oQMuw2q8JLMcRcW_z42lf3Lih7FinSsmr3saDTTQ8APAfffO8UFSmrb-XP-FQYsNjHhVO'; // key here
        //Setup curl, add headers and post parameters.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //Send the request

        $response = curl_exec($ch);
//print_r($response);exit;
        //Close request
        curl_close($ch);
        return $response;
    }
  
}

?>