<?php 
return [
	'status_list' => array("1"=>"Active","0"=>"Deactive"),
	'role_id' => array("admin"=>1,"user"=>2),
	'file_max_size' => 10240,// in kb
	'image_mime_type' => 'jpeg,gif,jpg,png',// image  extention
	'html_entity_decode_option'=>array('remove' => false,'charset' => 'UTF-8','quotes' => ENT_QUOTES,'double' => true),
	'category_type' => array("main_category"=>0,"sub_category"=>1),
	'menu_type' => array("dynamic"=>0,"cms_page"=>1),
	'menu_position' => array("1"=>'Header',"2"=>'Footer'),
        'company_status_list' => array("1"=>"Individual","2"=>"HUF","3"=>"Proprietorship","4"=>"Partnership","5"=>"LLP","6"=>"Private Limited","7"=>"Public Limited"),
        'duration_list' => array(""=>"Select Duration","1"=>"2 Months","2"=>"3 Months","3"=>"6 Months","4"=>"1 year"),
        'duration_required_list' => array(""=>"Select Duration Request","1"=>"5 Days","2"=>"10 Days","3"=>"15 Days"),
        
        'duration' => array("1"=>"Daily","2"=>"Weekly","3"=>"Monthly" ),
        'time_list' => array("1:00","2:00","3:00","4:00","5:00","6:00","7:00","8:00","9:00","10:00","11:00","12:00"),
        'min_list' => array("5:00","10:00","15:00","20:00","25:00","30:00","35:00","40:00","45:00","50:00","55:00"),
        'time' => array('am' => 'am','pm'=>'pm'),
        'gender_list' => array("0"=>"Gender Category","1"=>"Male","2"=>"Female","3"=>"Tranny","4"=>"Couple"),
        'lookingfor_list' => array("0"=>"Looking For","1"=>"Male","2"=>"Female","3"=>"Tranny","4"=>"Couple"),
        'lang_list' => array("en"=>"English","it"=>"Italian","es"=>"Spanish"),
    
        'order_status_list' => array("Pending"=>"Pending","Rejected"=>"Rejected","Completed"=>"Completed","Accepted"=>"Accepted"),
];