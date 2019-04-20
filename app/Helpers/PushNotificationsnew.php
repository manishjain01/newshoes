<?php 
// Server file
namespace App\Helper;
use App\Helper\Push;
use App\Helper\Firebase;

//AIzaSyCeEvNVn4qOn-4biasUwESbPpXmEpLW2k4

class PushNotificationsnew {
	// (Android)API access key from Google API's Console.
	private static $API_ACCESS_KEY = 'AIzaSyCqlPm2ULBFrZNfT8aWYmSHYyrpgEQ2Eeo';
	//private static $API_ACCESS_KEY = 'AIzaSyAL_9qqiExojgPpicKyruXrMTQVdQgbRWk';
	// (iOS) Private key's passphrase.
	private static $passphrase = '123';
	
	
	// Change the above three vriables as per your app.
	/*public function __construct() {
		exit('Init function is not allowed');
	}
	*/
        // Sends Push notification for Android users
	public static function android($dataArray,$deviceToken){
                //echo '<pre>android';
                //print_r($dataArray);
                //die;
      
		$firebase = new Firebase();
		$push = new Push();
	 
		// optional payload
		$payload = array();
		$payload['team'] = 'India';
		$payload['score'] = '5.6';
	        
                //$payload['id'] = $dataArray['notification_id'];
		// notification title
		$title = $dataArray['title'];
		 
		// notification message
		$message = $dataArray['notification'];
		 
		// push type - single user / topic
		$push_type = 'individual';
		 
		// whether to include to image or not
		//$include_image = $dataArray['image']; 

        $notification_id = $dataArray['id']; 
      	$push->setId($notification_id);
               
		 $CompanyId = $dataArray['company_id'];
		 $push->setCompanyId($CompanyId);
	 
		$push->setTitle($title);
		$push->setMessage($message);
		/*if ($include_image) {
		    $push->setImage($include_image); 
			//please change image when you need to send image on notification
		} else {
		    $push->setImage('');
		}*/
		$push->setIsBackground(FALSE);
		$push->setPayload($payload);
	 
	 
		$json = '';
		$response = '';
	 
		if ($push_type == 'topic') {
		    $json = $push->getPush();
		    $response = $firebase->sendToTopic('global', $json);
		} else if ($push_type == 'individual') {
		    $json = $push->getPush();
		    $regId = $deviceToken;
		    $response = $firebase->send($regId, $json);
		}


	}
	
	
	
        // Sends Push notification for iOS users
	public static  function iOS($data, $devicetoken) {
               // echo '<pre>Ios';
               // print_r($data);
               // die;
		$deviceToken = $devicetoken;
		$ctx = stream_context_create();
		// ck.pem is your certificate file
		stream_context_set_option($ctx, 'ssl', 'local_cert', $_SERVER['DOCUMENT_ROOT'].'/dev/wgo/public/uploads/CertificatesDisWGO123.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', self::$passphrase);
		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.push.apple.com:2195', $err,
                       //'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		     
				 //Create the payload body
				$body['aps'] = array(
					'alert' => array(
					    'title' => $data['title'],
				'body' => $data['notification'],
				'id' => $data['id'],
				'image' => $data['image'],
                                'company_id' => $data['company_id']
					 ),
                                        'content-available' => 1,
					'sound' => 'default'
				);
		    
		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		// Close the connection to the server
		fclose($fp);
		if (!$result)
			return 'Message not delivered ' . PHP_EOL;
		else
			return 'Message successfully delivered Device Token is ('.$devicetoken.')' . PHP_EOL;
           
	}
	
	// Curl 
	private static function useCurl($url, $headers, $fields = null) {
	        // Open connection
	        $ch = curl_init();
	        
	        if ($url) {
	            // Set the url, number of POST vars, POST data
	            curl_setopt($ch, CURLOPT_URL, $url);
	            curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	     
	            // Disabling SSL Certificate support temporarly
	            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	            if ($fields) {
	                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	            }
	     
	            // Execute post
	            $result = curl_exec($ch);
	            if ($result === FALSE) {
	                die('Curl failed: ' . curl_error($ch));
	            }
	     
	            // Close connection
	            curl_close($ch);
	
	            return $result;
        }
    }
    
    
     public static function sendNotification($message, $device_token) {
echo $message;exit;
    $Api_Key = 'AAAAvtaHEbE:APA91bFTX3WVk43HUQwvmezhVf10xNOxehC5IOdf2_mPX8EKoSDtweIuhzzgHZuKd_EJOkT94YuSw08WJN2f6Negb8ZDpIEamm8xFz55llalvRCYa08b0CiH3s2QoCLxJ0JMJVnFLLBp';  
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array (
            'registration_ids' => array (
                    $device_token
            ),
            'data' => array (
                    "message" => $message
            )
    );
    $fields = json_encode ( $fields );

    $headers = array (
            'Authorization: key=' . $Api_Key,
            'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    echo $result;
    curl_close ( $ch );
}
    
}
?>
