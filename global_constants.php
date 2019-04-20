<?php

######## DEFINE FOLDER & PATH CONSTANTS ##########
if (!defined('DS')) {
    define("DS", '/');
}

if (!defined('MAIN_FOLDER')) {
    define("MAIN_FOLDER",  basename(__DIR__).'/');
}
if (!defined('PUBLIC_FOLDER')) {
    define("PUBLIC_FOLDER",  'public/');
}
if (!defined('ADMIN_FOLDER')) {
    define('ADMIN_FOLDER', 'admin/');
}
if (!defined('SITE_ROOT_PATH')) {
    define('SITE_ROOT_PATH', base_path());
}
if (!defined('SITE_WEBROOT_PATH')) {
    define('SITE_WEBROOT_PATH', public_path().'/');
}

if (!defined('SITE_URL')) {
    define("SITE_URL",url('/'));
}

if (!defined('CURRENCY')) {
    $domains = explode('.', SITE_URL);
    if($domains['1'] == 'com'){
      $currency = '<i class="fa fa-inr" aria-hidden="true"></i>';  
    }else{
      $currency = '<i class="fa fa-usd" aria-hidden="true"></i>';    
    }
    define("CURRENCY",$currency);
}

if (!defined('ADMIN_URL')) {
    define("ADMIN_URL",SITE_URL.'/'.ADMIN_FOLDER);
}
if (!defined('WEBSITE_URL')) {
    define("WEBSITE_URL",url('/').'/');
}
if (strpos(WEBSITE_URL,'public') == false) {
   if (!defined('WEBSITE_PUBLIC_URL')) {
     define("WEBSITE_PUBLIC_URL",WEBSITE_URL.'public/');
  }
} else {
  if (!defined('WEBSITE_PUBLIC_URL')) {
     define("WEBSITE_PUBLIC_URL",WEBSITE_URL. '/');
  }
}

if (!defined('WEBSITEURL')) {
    define('WEBSITEURL', 'newshoes/');
}
if (!defined('UNIT')) {
    define('UNIT', ' cm.');
}

if (!defined('WEBSITE_ADMIN_URL')) {
    define("WEBSITE_ADMIN_URL", WEBSITE_URL . ADMIN_FOLDER);
}
if (!defined('WEBSITE_IMG_URL')) {
    define("WEBSITE_IMG_URL", WEBSITE_PUBLIC_URL . 'img' . '/');
}
if (!defined('WEBSITE_ADMIN_IMG_URL')) {
    define("WEBSITE_ADMIN_IMG_URL", WEBSITE_URL . ADMIN_FOLDER . 'img' . '/');
}











if (!defined('WEBSITE_IMG_FILE_URL')) {
    define("WEBSITE_IMG_FILE_URL", WEBSITE_PUBLIC_URL . 'image.php');
}




######## DEFINE FOLDER & PATH CONSTANTS ##########
######## COMMON CONSTANTS FOR DATE & TIME FORMAT ############

if (!defined('CONCATE_STRING')) {
    define("CONCATE_STRING", '@#@');
}
if (!defined('ENCRYPT_SLAT_STRING')) {
    define("ENCRYPT_SLAT_STRING", '@11$1^1!2*1^&^$%%@08ed7e7');
}

if (!defined('DATE_SEPERATOR')) {
    define("DATE_SEPERATOR", '/');
}
if (!defined('SQL_DATE_SEPERATOR')) {
    define("SQL_DATE_SEPERATOR", '-');
}
if (!defined('TIME_SEPERATOR')) {
    define("TIME_SEPERATOR", ':');
}
if (!defined('DATE_FORMATE')) {
    define('DATE_FORMATE', 'd' . DATE_SEPERATOR . 'm' . DATE_SEPERATOR . 'Y');
}


if (!defined('DATE_TIME_FORMATE_DATE_PICKER')) {
    define('DATE_TIME_FORMATE_DATE_PICKER', 'm' . DATE_SEPERATOR . 'd' . DATE_SEPERATOR . 'Y' . ' H' . TIME_SEPERATOR . 'i');
}

if (!defined('TIME_FORMATE')) {
    define('TIME_FORMATE', 'h' . TIME_SEPERATOR . 'i' . " A");
}

if (!defined('DATE_FORMATE_DATE_PICKER')) {
    define('DATE_FORMATE_DATE_PICKER', 'mm' . DATE_SEPERATOR . 'dd' . DATE_SEPERATOR . 'yyyy');
}
if (!defined('DATE_TIME_FORMATE')) {
    define('DATE_TIME_FORMATE', 'm' . DATE_SEPERATOR . 'd' . DATE_SEPERATOR . 'Y' . ', h' . TIME_SEPERATOR . 'i' . " A");
}
if (!defined('DATE_FORMATE_JS')) {
    define('DATE_FORMATE_JS', 'mm' . DATE_SEPERATOR . 'dd' . DATE_SEPERATOR . 'yyyy');
}

if (!defined('DATE_TIME_FORMATE_JS')) {
    define('DATE_TIME_FORMATE_JS', 'mm' . DATE_SEPERATOR . 'dd' . DATE_SEPERATOR . 'yyyy' . ' hh' . TIME_SEPERATOR . 'ii');
}

if (!defined('MESSAGE_DATE_FORMATE')) {
    define('MESSAGE_DATE_FORMATE', 'M. d, Y');
}
if (!defined('MESSAGE_TIME_FORMATE')) {
    define('MESSAGE_TIME_FORMATE', 'h:i a');
}
if (!defined('MESSAGE_DATE_TIME_FORMATE')) {
    define('MESSAGE_DATE_TIME_FORMATE', 'M. d, Y h:i a');
}

if (!defined('COMMENT_DATE_FORMATE')) {
    define('COMMENT_DATE_FORMATE', 'F j, Y \a\t h:i a');
}


if (!defined('WEDDING_DATE_FORMATE')) {
    define('WEDDING_DATE_FORMATE', 'j F Y');
}

######## COMMON CONSTANTS FOR DATE & TIME FORMAT ############

######## CONSTANTS FOR IMAGES START HERE ############

if (!defined('STUFF_ROOT_PATH')) {
    define('STUFF_ROOT_PATH', SITE_WEBROOT_PATH . 'stuff');
}
if (!defined('UPLOADS_ROOT_PATH')) {
    define('UPLOADS_ROOT_PATH', SITE_WEBROOT_PATH . 'uploads');
}
if (!defined('STUFF_FOLDER_URL')) {
    define('STUFF_FOLDER_URL', WEBSITE_URL . 'stuff/');
}
if (!defined('IMAGE_URL')) {
    define('IMAGE_URL', WEBSITE_URL . 'public/uploads/');
}
if (!defined('BANNER_IMAGE_URL')) {
    define('BANNER_IMAGE_URL', WEBSITE_URL . 'public/uploads/banner/');
}

if (!defined('PRODUCT_IMAGE_URL')) {
    define('PRODUCT_IMAGE_URL', WEBSITE_URL . 'public/uploads/products/');
}

if (!defined('USER_IMAGE_URL')) {
    define('USER_IMAGE_URL', WEBSITE_URL . 'public/uploads/user/');
}

if (!defined('ONTHEFLY_IMAGE_ROOT_PATH')) {
    define('ONTHEFLY_IMAGE_ROOT_PATH', 'stuff/');
}
if (!defined('ONTHEFLY_IMAGE_ROOT_PATH_UPLOADS')) {
    define('ONTHEFLY_IMAGE_ROOT_PATH_UPLOADS', 'uploads/');
}

/* SYSTEM IMAGES */
if (!defined('SYSTEM_IMAGE_URL')) {
    define('SYSTEM_IMAGE_URL', STUFF_FOLDER_URL . 'system_images/');
}

if (!defined('SYSTEM_IMAGES_UPLOAD_DIRECTROY_PATH')) {
    define('SYSTEM_IMAGES_UPLOAD_DIRECTROY_PATH', STUFF_ROOT_PATH . DS . 'system_images' . DS);
}
if (!defined('SYSTEM_IMAGE_ONTHEFLY_IMAGE_PATH')) {
    define('SYSTEM_IMAGE_ONTHEFLY_IMAGE_PATH', ONTHEFLY_IMAGE_ROOT_PATH . "system_images/");
}

/* Profile Image */
if (!defined('PROFILE_IMAGES_URL')) {
    define('PROFILE_IMAGES_URL', STUFF_FOLDER_URL . 'profile_image/');
}

if (!defined('PROFILE_IMAGES_UPLOAD_DIRECTROY_PATH')) {
    define('PROFILE_IMAGES_UPLOAD_DIRECTROY_PATH', UPLOADS_ROOT_PATH . DS );
}
if (!defined('PROFILE_IMAGES_ONTHEFLY_IMAGE_PATH')) {
    define('PROFILE_IMAGES_ONTHEFLY_IMAGE_PATH', ONTHEFLY_IMAGE_ROOT_PATH_UPLOADS . "/");
}

/* Blog Image */
if (!defined('BLOG_IMAGES_URL')) {
    define('BLOG_IMAGES_URL', STUFF_FOLDER_URL . 'blog_image/');
}

if (!defined('BLOG_IMAGES_UPLOAD_DIRECTROY_PATH')) {
    define('BLOG_IMAGES_UPLOAD_DIRECTROY_PATH', STUFF_ROOT_PATH . DS . 'blog_image' . DS);
}
if (!defined('BLOG_IMAGES_ONTHEFLY_IMAGE_PATH')) {
    define('BLOG_IMAGES_ONTHEFLY_IMAGE_PATH', ONTHEFLY_IMAGE_ROOT_PATH . "blog_image/");
}
/* Admin Menu Image */
if (!defined('MENU_IMAGES_URL')) {
    define('MENU_IMAGES_URL', STUFF_FOLDER_URL . 'admin_menu/');
}

if (!defined('MENU_IMAGES_UPLOAD_DIRECTROY_PATH')) {
    define('MENU_IMAGES_UPLOAD_DIRECTROY_PATH', STUFF_ROOT_PATH . DS . 'admin_menu' . DS);
}
if (!defined('MENU_IMAGES_ONTHEFLY_IMAGE_PATH')) {
    define('MENU_IMAGES_ONTHEFLY_IMAGE_PATH', ONTHEFLY_IMAGE_ROOT_PATH . "admin_menu/");
}
