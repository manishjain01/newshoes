<?php

namespace App\Helpers;

use Html;
use File;

class BasicFunction {

    /**
     * @description to upload images on website
     * @param 	   $image (image name to be uploading), 
     * @param 	   $uploadpath  Path for uplaoding file, 
     * @param 	   $image_prefix  prefix for image name, 
     * @param 	   $edit  if true than unlink previous uploaded image of the edit section, 
     * @param 	   $old_image  old image name we need to unlink, 
     * @return 	   image name
     */
     public static function uploadImage($image = array(), $uploadpath = '', $image_prefix = '', $edit = false, $old_image = '',$subfolder=false) {
        $image_name = '';


        if (!$image->isValid() || empty($uploadpath)) {
            return $image_name;
        }
       $edit_updaload_path  =   $uploadpath;

       if($subfolder){

            $year   =    date('Y');
            
            $uploadpath.=  $year.'/';
            if(!File::exists($uploadpath)) {
                    File::makeDirectory($uploadpath,  0777, true, true);
                    
            }
            $month   =    date('m');
            $uploadpath.=  $month.'/';
            if(!File::exists($uploadpath)) {
                    File::makeDirectory($uploadpath, 0777, true, true);
                    
            }

            $day   =    date('d');
            $uploadpath.=  $day.'/';
            if(!File::exists($uploadpath)) {
                    File::makeDirectory($uploadpath, 0777, true, true);
                   
            }
      }

       if ($image->isValid()) {
            $image_prefix = $image_prefix . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');


            $ext = $image->getClientOriginalExtension();

            $image_name = $image_prefix . '.' . $ext;

            $image->move($uploadpath, $image_name);
            //$image_name =   $year.'/'.$month.'/'.$day.'/'.$image_name;

            if ($edit) {
                @unlink($edit_updaload_path . $old_image);
            }
        } else {
            if ($edit) {
                $image_name = $old_image;
            }
        }
      
        return $image_name;
    }

     function currentTime() {

        return time();
    }

    /**
     * @description to show images on website
     * @param 	   $root_path , 
     * @param 	   $http_path, 
     * @param 	   $image_name  image name, 
     * @param 	   $attribute all attributes of image like(height,width, class), 		
     * @return 	   image url
     * */
     public static function showImage($root_path = '', $http_path = '', $image_name = '', $attribute = array()) {
        $alt =  Configure('CONFIG_SITE_TITLE');
        $title = Configure('CONFIG_SITE_TITLE');
        $height = '';
        $width = '';
        $class = '';
        $link_url = '';
        $type = '';
        $zc = '2';
        $ct = '0';
        if (isset($attribute['alt']) && $attribute['alt'] != '') {
            $alt = $attribute['alt'];
        }
        if (isset($attribute['title']) && $attribute['title'] != '') {
            $title = $attribute['title'];
        }
        if (isset($attribute['height']) && $attribute['height'] != '') {
            $height = $attribute['height'] . 'px';
        }

        if (isset($attribute['width']) && $attribute['width'] != '') {
            $width = $attribute['width'] . 'px';
        }
        if (isset($attribute['class']) && $attribute['class'] != '') {

            $class = $attribute['class'];
        }

        if (isset($attribute['url']) && $attribute['url'] != '') {

            $link_url = $attribute['url'];
        }

        // override Default zoom/crop setting of img.php file . 

        if (isset($attribute['zc']) && $attribute['zc'] != '') {

            $zc = $attribute['zc'];
        }

        if (isset($attribute['ct']) && $attribute['ct'] != '') {

            $ct = $attribute['ct'];
        }

        if (isset($attribute['type']) && $attribute['type'] != '') {

            $type = $attribute['type'];
        }

        if (file_exists($root_path . $image_name) && $image_name != '') {
            $url = WEBSITE_IMG_FILE_URL . '?image=' . $http_path . $image_name . '&amp;height=' . $height . '&amp;width=' . $width . '&amp;zc=' . $zc . '&amp;ct=' . $ct;



            return Html::image($url, $alt, $attributes = array('class' => $class, 'title' => $title));
            //return $this->Html->image($url, array('alt' => $alt, 'class' => $class, 'url' => $link_url, "title" => $title));
        } else {

            if($type=='user'){
                $url = WEBSITE_IMG_FILE_URL . '?image=' . 'img/no_image.png' . '&amp;height=' . $height . '&amp;width=' . $width . '&amp;zc=' . $zc . '&amp;ct=' . $ct;
            }else{

                $url = WEBSITE_IMG_FILE_URL . '?image=' . 'img/noImageIcon.jpg' . '&amp;height=' . $height . '&amp;width=' . $width . '&amp;zc=' . $zc . '&amp;ct=' . $ct;

            }

            return Html::image($url, $alt, $attributes = array('class' => $class, 'title' => $title));
        }
    }

    /**
     * Generate a unique slug.
     * If it already exists, a number suffix will be appended.
     * It probably works only with MySQL.
     *
     * @link http://chrishayes.ca/blog/code/laravel-4-generating-unique-slugs-elegantly
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $value
     * @return string
     */
     public static function getUniqueSlug($model, $value) {
        $slug = \Illuminate\Support\Str::slug(trim($value));
        $slugCount = count($model->whereRaw("slug REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }


    public static function getParentCategory(){
       
      $categorylist =     \App\Category::where('parent_id','=',0)->orderBy('name')->lists('name', 'id')->toArray();;
        return $categorylist;

    }    
    public static function getCategoryList(){
       
      $categorylist =     \App\Category::where('parent_id','=',0)->orderBy('name')->lists('name', 'id')->toArray();
      $new_list_array = array();
      foreach ($categorylist as $key => $value) {
        $new_list_array[$key] =  ucfirst($value);
        $subcategory_list =     \App\Category::where('parent_id','=',$key)->orderBy('name')->lists('name', 'id')->toArray();
        foreach ($subcategory_list as $sub_key => $sub_value) {
                 $new_list_array[$sub_key]   = '&nbsp;&nbsp;&nbsp;'. ucfirst($sub_value);
        }
      }
      return $new_list_array;

    }  

    public static function getAllList(){
       
      $mainMneuList =     \App\AdminMenu::where('parent_id','=',0)->where('status','=',1)->orderBy('menu_order')->get()->toArray();
     
      $new_list_array = array();
      foreach ($mainMneuList as $key => $value) {
        $new_list_array[$key] =  $value;
        $new_list_array[$key]['child_list'] =     \App\AdminMenu::where('parent_id','=',$value['id'])->where('status','=',1)->orderBy('menu_order')->get()->toArray();
        
      }
      return $new_list_array;

    }
     public static function getLastQuery() {
        if (App::environment('local')) {

            // The environment is local
            DB::enableQueryLog();
            return dd(DB::getQueryLog());
        } else {

            return false;
        }
    }

    public function sendsms($phone, $username,$reward_points,$msg){
        $user="jbit110"; 
        //your username
        $password="Jbit5000"; 
        //your password
        $mobilenumbers='91'.$phone; 
        //enter Mobile numbers comma seperated
        $Token = 'Dear '.$username.', '.$msg.' '.$reward_points;
        $message = 'Your unique OTP is'. $Token; //enter Your Message
        $senderid="VFJBIT"; //Your senderid
        $messagetype="N"; //Type Of Your Message
        $DReports="Y"; //Delivery Reports
        $url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";$message = urlencode($message);
        $ch = curl_init();if (!$ch){die("Couldn't initialize a cURL handle");}
        $ret = curl_setopt($ch, CURLOPT_URL,$url);curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt ($ch, CURLOPT_POSTFIELDS,"User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//If you are behind proxy then please uncomment below line and provide your proxy ip with port.//
        $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");$curlresponse = curl_exec($ch); // executereturn 
        $curlresponse;
    }
    
     public static function getcmslist(){
       
      $cmslist =     \App\Cms::where('status','=',1)->orderBy('id')->lists('title', 'id')->toArray();;
        return $cmslist;

    }

    public static function UnlinkImage($filepath,$fileName)
{
    $old_image = $filepath.$fileName;
    if (file_exists($old_image)) {
       @unlink($old_image);
    }
}
}

?>
