<?php
function getIcon(){
    $icon  =   Config::get('icon');
    $iconArray= array();

    foreach ($icon as $key => $value) {
        $iconArray[$key]= ucfirst(trim(str_replace(array(' ','fa-','-'),array('','',' '),$value)));
            
    }
   return $iconArray;
}
function adminUser(){

    return    Auth::guard('admin')->user();
}
function LoginUser(){

    return Auth::guard('web')->user();
    
}

function setCurrentPage($key){
        $page = Input::all();
        Session::put($key, $page);
           
}
function getCurrentPage($key){
    if(Session::has($key)){
       return Session::get($key, 'value');
    }
    else{

                return array('page'=>'1');
    }
}


function pr($value,$flag=0){
   echo "<pre>";
   print_r($value);
   echo "</pre>";
    if($flag){
       die; 
       
    }
    
}

 function Configure($key){
    
    return  config('settings.'.$key);
    
   
}

function generateStrongPassword($length = 10, $add_dashes = false, $available_sets = 'luds')
{
    $sets = array();
    if(strpos($available_sets, 'l') !== false)
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    if(strpos($available_sets, 'u') !== false)
        $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
    if(strpos($available_sets, 'd') !== false)
        $sets[] = '23456789';
    if(strpos($available_sets, 's') !== false)
        $sets[] = '!@#$%&*?';
    $all = '';
    $password = '';
    foreach($sets as $set)
    {
        $password .= $set[array_rand(str_split($set))];
        $all .= $set;
    }
    $all = str_split($all);
    for($i = 0; $i < $length - count($sets); $i++)
        $password .= $all[array_rand($all)];
    $password = str_shuffle($password);
    if(!$add_dashes)
        return $password;
    $dash_len = floor(sqrt($length));
    $dash_str = '';
    while(strlen($password) > $dash_len)
    {
        $dash_str .= substr($password, 0, $dash_len) . '-';
        $password = substr($password, $dash_len);
    }
    $dash_str .= $password;
    return $dash_str;
}



/** 
     * Function to get current time  
     * @return  timestamp
     */
     function getCurrentTime()
    {
        return time();
    } //end getCurrentTime()
/** 
     * Function to get current time  
     * @return 	timestamp
     */
     function str2time($time)
    {
        return strtotime($time);
    } //end getCurrentTime()

    /**
        Function to chnage Sql date formate to system Date formate
        @params $date 
        @params $formate

     */
        function date_val($date,$format){
            
            return date($format,strtotime($date));


        }


    
    /* Function to encode value using base64_encode	
     * @params $value as which value need to be encode	
     * @return encoded value
     */
     function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array(
            '+',
            '/',
            '='
        ), array(
            '-',
            '_',
            ''
        ), $data);
        return $data;
    } //end safe_b64encode()
    /**     
     * Function to decode value using base64_decode
     * @params $value as which value need to be encode
     * @return decoded value
     */
     function safe_b64decode($string)
    {
        $data = str_replace(array(
            '-',
            '_'
        ), array(
            '+',
            '/'
        ), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    } //end safe_b64decode()
    
    
    
    /** 
     * Function to encode value using ENCRYPT SLAT	
     * @params $value as which value need to be encode	
     * @return encoded value
     */
     function encode_value($value)
    {
        $skey =ENCRYPT_SLAT_STRING;
        if (!$value) {
            return false;
        }
        $text      = $value;
        $iv_size   = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv        = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim(safe_b64encode($crypttext));
    } //end encode_value()
    
    
    /**     
     * Function to decode value using ENCRYPT SLAT	
     * @params $value as which value need to be encode
     * @return decoded value
     */
     function decode_value($value)
    {
        $skey = ENCRYPT_SLAT_STRING;
        if (!$value) {
            return false;
        }
        $crypttext   = safe_b64decode($value);
        $iv_size     = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv          = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    } //end decode_value()
    
    
    /**
     * Function to Change date into timestamp
     * @param 	   $dateField particular date (dd/mm/YYYY)
     * @param 	   $timeField particular time mktime ($hour,$minute,$second,$month,$day,$year)
     * @return 	   timestamp of date
     * */
     function makeTime($dateField, $timeField = "0:0:0")
    {
        if ($dateField == '')
            return false;
        
        $dateArray = explode(DATE_SEPERATOR, $dateField);
        $timeArray = explode(":", $timeField);
        if (DATE_sE == 'm' . DATE_SEPERATOR . 'd' . DATE_SEPERATOR . 'Y') {
            return mktime($timeArray[0], $timeArray[1], $timeArray[2], @$dateArray[0], @$dateArray[1], @$dateArray[2]);
        } else {
            return mktime($timeArray[0], $timeArray[1], $timeArray[2], @$dateArray[1], @$dateArray[0], @$dateArray[2]);
        }
    } //end makeTime()
    
    
    /**
     * Function to Change timestamp into date for the datepicker
     * @param 	   $timestamp particular timestamp  
     * @return 	   Date according timestamp (mm/dd/YYYY)
     */
     function makeDatePickerDate($timestamp)
    {
        
        return date(DATE_FORMATE_DATE_PICKER, $timestamp);
    } //end makeDatePickerDate()
    
    
    /**
     * Function to Change timestamp into date
     * @param 	   $timestamp particular timestamp  
     * @return 	   Date according timestamp (m/d/Y)
     */
     function makeDate($timestamp)
    {
        return date(DATE_FORMATE, $timestamp);
    } //end makeDate()
    
    
    /**
     * @description Change timestamp into date & time
     * @param 	   $timestamp perticular timestamp  
     * @return 	   Date with time according timestamp
     */
     function makeDateTime($timestamp)
    {
        return date(DATE_TIME_FORMATE, $timestamp);
    } //end makeDateTime()
    
    
    /**	 
     * Function to get timestamp   
     * @params  $time_duration as number of days, month, year (eg 30, 1, 2)
     * @param $duration_type as days, month, year
     * @param $direction 'past' or 'future', default is 'past'
     * @return $dateinteger
     */
     function getTimeStampOfFixTime($time_duration = 0, $duration_type = '', $direction = 'past')
    {
        
        $sign = ($direction == 'past') ? '-' : '+';
        
        $dateinteger = strtotime("{$sign}{$time_duration} {$duration_type}");
        
        return $dateinteger;
    } //end getTimeStampOfFixTime()
    
    
    /**	 
     * Function to get timestamp value of any date
     * @param $date as date 
     * @return timestamp
     */
     function convertDateToTimestamp($date = null)
    {
        return strtotime($date);
    } //end convertDateToTimestamp()
    
    
    /**
     * Function to display price
     * @param $price
     * @return formated price 
     */
     function display_price($price = null)
    {
        $site_currency = Configure::read('CONFIG_CURRENCY_CODE');
        
        if ($site_currency == 'INR') {
            return $currency_symbol = 'Rs ' . number_format($price, 2);
        } elseif ($site_currency == 'USD') {
            return $currency_symbol = number_format($price, 2) . ' $';
        } else if ($site_currency == 'AED') {
            return $currency_symbol = $site_currency . ' ' . number_format($price, 2);
        } else {
            return $currency_symbol = '$ ' . number_format($price, 2);
        }
    } //end display_price()
    
    
    /**
     * Function to display currency
     * 
     * @return currency symbol
     */
     function display_currency()
    {
        $site_currency = Configure::read('CONFIG_CURRENCY_CODE');
        
        if ($site_currency == 'INR') {
            return 'Rs ';
        } elseif ($site_currency == 'USD') {
            return ' $';
        } else if ($site_currency == 'AED') {
            return $site_currency;
        } else {
            return '$ ';
        }
    } //end display_currency()
    
    /**
     * Function to get user full name
     * @param $first_name
     * @param $last_name
     * @param $full_name_type(0,1,2,3)
     * @return user full name
     */
     function getUserFullName($first_name = '', $last_name = '', $full_name_type = 0)
    {
        
        if ($full_name_type == 0) {
            $user_full_name = ucfirst($first_name . ' ' . $last_name);
        } else if ($full_name_type == 1) {
            $user_full_name = ucfirst($first_name);
        } else if ($full_name_type == 2) {
            $user_full_name = ucfirst($last_name);
        } else if ($full_name_type == 3) {
            $full_name      = $first_name . ' ' . $last_name;
            $name           = ucfirst(substr($full_name, 0, strpos($full_name, ' ') + 2));
            $user_full_name = $name . ' .';
        }
        return $user_full_name;
    } //end getUserFullName()
    
    
    /**
     * Function to get user name
     *
     * @param array $user_data 	as user information array
     *
     * @return string
     */
     function getUserProfileName($user_data = array())
    {
        $name = '';
        if (!empty($user_data)) {
            if (isset($user_data['user_type']) && ($user_data['user_type'] == Configure::read('USER_GROUP_SLUG.1'))) {
                $name = Configure::read('ADMIN_USER_NAME');
            } else if ($user_data['user_type'] == Configure::read('USER_GROUP_SLUG.3')) {
                if (isset($user_data['profile_name'])) {
                    $name = ucwords($user_data['profile_name']);
                } else {
                    $name = ucwords($user_data['first_name'] . ' ' . $user_data['last_name']);
                }
            } else {
                if (isset($user_data['profile_name'])) {
                    $name = ucwords($user_data['profile_name']);
                } else {
                    $name = ucwords($user_data['first_name'] . ' ' . $user_data['last_name']);
                }
            }
            return $name;
        }
    }
    
    /**
     * Function to get user full name
     *
     * @param array $user_data 	as user information array
     *
     * @return string
     */
     function getUserFullNameForEmail($user_data = array())
    {
        $name = '';
        if (!empty($user_data)) {
            if ($user_data['user_type'] == Configure::read('USER_GROUP_SLUG.3')) {
                $name = ucwords($user_data['first_name'] . ' ' . $user_data['last_name']);
            } else {
                $name = ucwords($user_data['first_name'] . ' ' . $user_data['last_name']);
            }
            return $name;
        }
    }
    
    /**
     * Function to generate encoded password
     * @param $plain_password as original password
     * @return encoded password
     */
     function generateEncodedPassword($plain_password = '')
    {
        
        $encoded_password = Security::hash($plain_password, PASSWORD_ENCODED_ALGORITHM, true);
        return $encoded_password;
        
    } //end generateEncodedPassword()
    
    
    /**
     * Function to generate encoded user password
     * @param $plain_password as original password
     * @return encoded user salt
     */
     function generateUserSaltEncode($plain_password = '')
    {
        $encoded_user_salt = base64_encode(USER_SALT_PREFIX . $plain_password . USER_SALT_POSTFIX);
        return $encoded_user_salt;
    } //end generateUserSaltEncode()
    
    
    /**
     * Function to generate decoded user salt
     * @param $encoded_user_salt as encoded user salt
     * @return decoded password
     */
     function generateUserSaltDecode($encoded_user_salt = '')
    {
        if (!empty($encoded_user_salt)) {
            $decode_user_salt = base64_decode($encoded_user_salt);
            $user_password    = $decode_user_salt;
            $user_salt_array  = explode(USER_SALT_PREFIX, $decode_user_salt);
            
            if (!empty($user_salt_array) && isset($user_salt_array[1])) {
                $encode_user_salt = explode(USER_SALT_POSTFIX, $user_salt_array[1]);
            }
            
            if (isset($encode_user_salt[0])) {
                $user_password = $encode_user_salt[0];
            }
            
            return $user_password;
        }
    } //end generateUserSaltDecode()
    
    
    /**
     * Function to generate encoded activation key for email verify
     * @param $email as user email address
     * @return encoded activation key
     */
     function generateEncodedActivationKey($email = '')
    {
        $encoded_activation_key = Security::hash($email, ACTIVATION_KEY_ENCODED_ALGORITHM);
        return $encoded_activation_key;
    } //end generateEncodedActivationKey()
    
    /**
     * Function to generate user archive email address after user is deleted
     * @param $email as user email address
     * @param $user_id as id of user email
     * @return archiveEmail
     **/
     function generateUserArchiveEmail($email = '', $user_id = null)
    {
        $archiveEmail = $email . ARCHIVE_EMAIL_TEXT . $user_id;
        return $archiveEmail;
    } //end generateUserArchiveEmail()
    

    /**	
     * Function to check website url contain "http or https"  And add if it not exist
     * @param 	$site_url  as url 
     * @return url with http or https
     */
     function getValidUrl($site_url = '')
    {
        
        $url = parse_url($site_url);
        
        if (isset($url['scheme']) && $url['scheme'] == 'https') {
            return $site_url;
        } else if (isset($url['scheme']) && $url['scheme'] == 'http') {
            return $site_url;
        } else {
            return 'http://' . $site_url;
        }
    } //end getValidUrl()
    

    


    
  
    
    /**
     * Function to get start and end timestamp of the day
     *
     * @param array date 
     *
     * @return date
     */
     function get_start_and_end_timestamp_of_day($date)
    {
        if (!empty($date)) {
            $start = BasicFunctions::makeTime($date, "0:0:0");
            $end   = BasicFunctions::makeTime($date, '23:59:59');
            
            $data['start'] = $start;
            $data['end']   = $end;
            
            return $data;
        }
    } //end get_start_and_end_timestamp_of_day()	
    
    /**
     * Function to get description according to word length
     *
     * @params $description description
     * @params  $length
     *
     * @return description accoiding to length
     */
    
     function getShortDescription($description = null, $length = 150)
    {
        App::uses('String', 'Utility');
        $descrition = String::truncate(trim($description), $length, array(
            'ellipsis' => '...',
            'exact' => false
        ));
        return ucfirst($descrition);
    } //end getShortDescription()
    
    
    /**
     * Function to get description according to word length
     *
     * @params $description description
     * @params  $length
     *
     * @return description accoiding to length
     */
    
     function showDescription($description = null)
    {
        return nl2br($description);
    } //end getShortDescription()
    
    
    /**
     * Function to run curl
     *
     * @params $url curl URL
     * @params  $post parameters to be posted on curl
     *
     * @return response return from curl
     */
     function curlExecute($url, $post = "")
    {
        $curl      = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        curl_setopt($curl, CURLOPT_URL, $url);
        //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        //The number of seconds to wait while trying to connect.
        if ($post != "") {
            curl_setopt($curl, CURLOPT_POST, 5);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        //The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        //To stop cURL from verifying the peer's certificate.
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    } //end curlExecute()
    
    /**
     * GeneralFunctionsHelper::time_elapsed_string()
     * @Description Function  to get ago time
     * @param $ptime time 
     * @return string
     * */
     function time_elapsed_string($ptime, $timestring = "yes")
    {
        $etime = time() - $ptime;
        
        if ($etime < 1) {
            return '0 seconds';
        }
        
        $a        = array(
            365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
        $a_plural = array(
            'year' => 'years',
            'month' => 'months',
            'day' => 'days',
            'hour' => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );
        if ($timestring == "yes") {
            foreach ($a as $secs => $str) {
                $d = $etime / $secs;
                if ($d >= 1) {
                    $r = round($d);
                    
                    return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
                }
            }
        } else {
            foreach ($a as $secs => $str) {
                $d = $etime / $secs;
                if ($d >= 1) {
                    $r = round($d);
                    
                    return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str);
                }
            }
        }
    }
    /**
     * GeneralFunctionsHelper::time_elapsed_string()
     * @Description Function  to get ago time
     * @param $ptime time 
     * @return string
     * */
     function getConversationTime($ptime)
    {
        $return_date       = date(DATE_FORMATE, $ptime);
        $today_date        = date(DATE_FORMATE);
        $yesterdat_date    = date(DATE_FORMATE, strtotime("-1 days"));
        $conversation_date = date(DATE_FORMATE, $ptime);
        if ($conversation_date == $today_date) {
            $return_date = date(MESSAGE_TIME_FORMATE, $ptime);
        } elseif ($conversation_date == $yesterdat_date) {
            $return_date = 'Yesterday ' . date(MESSAGE_TIME_FORMATE, $ptime);
        } else {
            $return_date = date(MESSAGE_DATE_TIME_FORMATE, $ptime);
        }
        return $return_date;
    }
    
    /**
     * Function to create encoded search string
     *
     * @params $search string
     
     *
     * @return encoded string
     */
     function createEncodedSearchString($search_string = null)
    {
        return base64_encode(str_pad(strtr($search_string, '-_', '+/'), strlen($search_string) % 4, '=', STR_PAD_RIGHT));
    }
    
    
    /*
     * 	@BasicFunctions::daysInMonth()
     * @Description	Get number of days in required month
     
     * @param		$year year of particular month which days count
     * @param		$month month which days count
     * @return 	integer
     */
    
     function daysInMonth($year, $month)
    {
        return date("t", mktime(0, 0, 0, $month, 1, $year));
    }
    
    /**
     * BasicFunctions::getTimeStamp()
     * @Desc Function to get current month end time stamp
     * 
     * @return integer
     * */
     function getTimeStamp($hour, $minute, $second, $month, $day, $year)
    {
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        return $timestamp;
    }
    /*
     * @description  function to round value using round_value
     * @return round value
     */
    
     function round_value($value)
    {
        return round($value, 1, PHP_ROUND_HALF_UP);
    } // end round_value
    
    /**
     * @BasicFunctions::reportsMakeTime 		
     * @description Change date into timestamp
     * @param 	   $month perticular month
     * @param 	   $day perticular date
     * @param 	   $year perticular year
     * @param 	   $hour perticular hour 
     * @param 	   $min perticular minutes 
     * @param 	   $sec perticular seconds 
     * @return 	   timestamp of date
     * 
     * */
     function reportsMakeTime($hour = '', $min = '', $sec = '', $month = '', $day = '', $year = '')
    {
        if ($year != '' && $day != '') {
            return mktime($hour, $min, $sec, $month, $day, $year);
        } else if ($day != '') {
            return mktime($hour, $min, $sec, $month, $day);
        } else {
            return mktime($hour, $min, $sec, $month);
        }
    } //End reportsMakeTime()
   
    /**
     * @BasicFunctions::getYearDropdownOption() 
     * 
     * @Description Function to get year drop down
     * 
     * @return void
    **/	
	   function getYearDropdownOption(){
		$years			= array();
		$current_year 	= Configure::read('START_YEAR_IN_DROPDOWN');
		
		for($ey = $current_year;$ey>=$current_year-10;$ey--){
			   $years[$ey] = $ey;
		}		
		return $years;
	}// end getYearDropdownOption()


?>
