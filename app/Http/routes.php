<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
//	Route::get('admin', 'Auth\AuthController@getLogin');
/* Route::get('login', 'Auth\AuthController@postLogin');
  Route::post('login', 'Auth\AuthController@postLogin');
  Route::get('logout', 'Auth\AuthController@getLogout'); */
//for admin
/* Route::get('admin', [
  'middleware' => 'auth',
  'uses' => 'Auth\AuthController@getLogin'
  ]); */

Route::group(['namespace' => 'Front'], function() {

    Route::group(['middleware' => 'web'], function() {
        //Route::get('login', ['as' => 'web.login', 'uses' => 'AuthController@getLogin']);
        Route::get('page/{id}', ['as' => 'web.cms_list', 'uses' => 'HomesController@cms_list']);
        //Route::get('newletter_post', ['as' => 'web.newletter_post', 'uses' => 'UsersController@newletter_post']);
        Route::post('newletter_post', ['as' => 'web.newletter_post', 'uses' => 'UsersController@newletter_post']);
        Route::post('login_post', ['as' => 'web.login_post', 'uses' => 'AuthController@postLogin']);
        Route::post('register', ['as' => 'web_register', 'uses' => 'AuthController@register']);
        
        Route::get('auth/Facebook', ['as' => 'facebook.login', 'uses' => 'AuthController@redirectToProvider']);
        Route::get('auth/Facebook/callback', 'AuthController@handleProviderCallback');
        
        Route::get('auth/Instagram', ['as' => 'instagram.login', 'uses' => 'AuthController@insta_login']);
        Route::get('auth/Instagram/callback', 'AuthController@callback');
        
        Route::get('logout', ['as' => 'web.logout', 'uses' => 'AuthController@getLogout']);
        Route::post('forgotPassword', ['as' => 'forgotPassword', 'uses' => 'UsersController@forgotPassword']);
        Route::get('/', ['as' => 'home', 'uses' => 'HomesController@index']);
        Route::post('lang',array(
            'Middleware'=>'LanguageSwitcher',
            'uses'=>'LanguageController@index'
        ));
       
    });
    Route::post('lang',array(
            'Middleware'=>'LanguageSwitcher',
            'uses'=>'LanguageController@index'
        ));
    //Route::get('login', ['as' => 'front_login', 'uses' => 'UsersController@getLogin']);
    //Route::post('login', ['as' => 'front_login', 'uses' => 'UsersController@postLogin']);
    Route::get('myaccount', ['as' => 'myaccount', 'uses' => 'UsersController@myaccount']);
    Route::get('account_information', ['as' => 'account_info', 'uses' => 'UsersController@account_information']);
    Route::get('address', ['as' => 'address', 'uses' => 'UsersController@address']);
    
    Route::get('edit_address/{order_id}/{ByNow}', ['as' => 'address', 'uses' => 'UsersController@edit_address']);
    Route::get('edit_address/{order_id}/{checkout}', ['as' => 'address', 'uses' => 'UsersController@edit_address']);
    
    Route::get('delivery_address/{order_id}/{order}', ['as' => 'address', 'uses' => 'OrderController@delivery_address']);
    Route::get('delivery_address/{order_id}/{guest}', ['as' => 'address', 'uses' => 'OrderController@delivery_address']);    
    Route::get('delivery_address/{order_id}/{ByNow}', ['as' => 'address', 'uses' => 'OrderController@delivery_address']);
    Route::get('delivery_address/{order_id}/{bynow}', ['as' => 'address', 'uses' => 'OrderController@delivery_address']);
    
    Route::post('updateDeliveryAddress/{id}/{guest}', ['as' => 'updateDeliveryAddress', 'uses' => 'OrderController@updateDeliveryAddress']);
    Route::post('updateDeliveryAddress/{id}/{ByNow}', ['as' => 'updateDeliveryAddress', 'uses' => 'OrderController@updateDeliveryAddress']);
    
    //Route::get('edit_address', ['as' => 'address', 'uses' => 'UsersController@edit_address']);
    Route::post('update_user_Address/{id}', ['as' => 'update_user_Address', 'uses' => 'UsersController@update_user_Address']);
    Route::post('update_user_Address/{id}/{order_id}/{ByNow}', ['as' => 'update_user_Address', 'uses' => 'UsersController@update_user_Address']);
    
    Route::post('review_post', ['as' => 'web.register_post', 'uses' => 'UsersController@postReview']);
    Route::post('pincode_post', ['as' => 'web.pincode_post', 'uses' => 'UsersController@pincodeAvail']);
    
    Route::get('changePassword', ['as' => 'change_password', 'uses' => 'UsersController@change_password']);
    Route::post('updatePassword', ['as' => 'update_password', 'uses' => 'UsersController@UpdateChangePassword']);    
    Route::get('user_wishlist', ['as' => 'wishlist', 'uses' => 'UsersController@wishlist']);
    
    Route::get('order_list', ['as' => 'user_orders', 'uses' => 'OrderController@order_list']);
    //Route::post('updatePassword', ['as' => 'update_password', 'uses' => 'UsersController@UpdateChangePassword']);    
    
    Route::get('edit', ['as' => 'edit_profile', 'uses' => 'UsersController@edit']);
    Route::post('update/{id}', ['as' => 'updateProfile', 'uses' => 'UsersController@updateProfile']);
    Route::post('update_address/{id}', ['as' => 'updateAddress', 'uses' => 'UsersController@updateAddress']);
    
    
    Route::get('wishlist', ['as' => 'wishlist_detail', 'uses' => 'ProductsController@wishlist_detail']);
    Route::post('wishlist', ['as' => 'wishlist_detail', 'uses' => 'ProductsController@wishlist_detail']);
    Route::post('delete_wishlist', ['as' => 'delete_wishlist', 'uses' => 'ProductsController@delete_wishlist']);
   
    
    Route::post('newsletter', ['as' => 'newsletter_user', 'uses' => 'UsersController@newletter_post']);
    //Route::get('productList/{slug}', ['as' => 'product_list', 'uses' => 'ProductsController@allproductList']);
    
    
     Route::get('contact', ['as' => 'contact_us', 'uses' => 'PagesController@contact']);
     Route::post('contact_post', ['as' => 'contact_us_post', 'uses' => 'PagesController@contact_post']);
    
    
     Route::post('image_prew', ['as' => 'image_prew', 'uses' => 'ProductsController@image_prew']);
    //========================Shubham Route Start here=======================//
    //Route::post('productList', ['as' => 'product_list', 'uses' => 'ProductsController@allproductList']);
    Route::post('productCat/search', ['as' => 'product_search', 'uses' => 'ProductsController@productList']);
    Route::get('productCat/search', ['as' => 'product_search', 'uses' => 'ProductsController@productList']);
    Route::get('productCat/{slug}', ['as' => 'product_cat', 'uses' => 'ProductsController@productList']);
    Route::get('productCat/{slug}/{catslug}', ['as' => 'product_cat', 'uses' => 'ProductsController@productList']);
    Route::get('productCat/{slug}/{catslug}/{subcatslug}', ['as' => 'product_cat', 'uses' => 'ProductsController@productList']);
    Route::post('productCat/{slug}/{catslug}/{subcatslug}', ['as' => 'product_cat', 'uses' => 'ProductsController@productList']);
    
    Route::get('allReviews/{id}/{slug}', ['as' => 'product_reviews', 'uses' => 'UsersController@allReviews']);
    
    Route::post('newOrderAddress', ['as' => 'web.new_address_post', 'uses' => 'ProductsController@postNewAddress']);
    
    Route::post('selectOrderAddress', ['as' => 'web.select_address_post', 'uses' => 'ProductsController@selectNewAddress']);
    
    

    Route::get('productDetail/{id}/{collection}', ['as' => 'product_detail', 'uses' => 'ProductsController@productDetail']);
    Route::post('addwishlist', ['as' => 'addwishlist', 'uses' => 'ProductsController@addwishlist']);
    Route::post('removewishlist', ['as' => 'removewishlist', 'uses' => 'ProductsController@removewishlist']);
    Route::post('addtocart', ['as' => 'addtocart', 'uses' => 'ProductsController@addtocart']);
    Route::post('check_stock', ['as' => 'check_stock', 'uses' => 'ProductsController@check_stock']);
    Route::get('cartDetail', ['as' => 'cartDetail', 'uses' => 'ProductsController@cart_detail']);
    Route::post('cartDetail', ['as' => 'cartDetail', 'uses' => 'ProductsController@cart_detail']);
    Route::get('checkout', ['as' => 'checkout', 'uses' => 'ProductsController@checkout']);
    Route::get('guest_checkout', ['as' => 'guest_checkout', 'uses' => 'ProductsController@guest_checkout']);
    
    Route::get('bynow/{order_no}', ['as' => 'by_now', 'uses' => 'ProductsController@bynow']);
    Route::get('ByNow/{order_no}', ['as' => 'by_now_checkout', 'uses' => 'ProductsController@bynow_checkout']);
    Route::post('by_now', ['as' => 'by_now_post', 'uses' => 'ProductsController@by_now_post']);
    //========================Shubham Route Start End=======================//
    Route::post('state_change/{id}', ['as' => 'state_change', 'uses' => 'UsersController@getcities']); 
    
    
    //Route::post('productList', ['as' => 'product_list', 'uses' => 'ProductsController@allproductList']);
    //Route::get('productDetail/{id}', ['as' => 'product_detail', 'uses' => 'ProductsController@productDetail']);
     Route::get('actvie-link/{email_token}', ['as' => 'front.resetAccountlink', 'uses' => 'UsersController@resetAccountlink']);
     Route::get('actvie-link-forgot/{email_token}', ['as' => 'front.resetPasswordlink', 'uses' => 'UsersController@resetPasswordlink']);
     Route::post('reset-password/{email_token}', ['as' => 'front.reset_password', 'uses' => 'UsersController@resetPasswordUpdate']);
     
     Route::post('remove_img', ['as' => 'remove_img', 'uses' => 'ProductsController@remove_img']);
     Route::post('remove_userimg', ['as' => 'remove_userimg', 'uses' => 'UsersController@remove_userimg']);
     
     Route::post('payment/status', 'OrderController@paymentCallback');
     //Route::get('payment/status', 'OrderController@paymentCallback');
     
     Route::get('status_msg/{order_no}', 'OrderController@paytm_mst');
     
     Route::post('payment', 'OrderController@order');
     Route::get('status', 'OrderController@getPaymentStatus');
     Route::get('paypal', 'OrderController@paypal');
     
     Route::post('success', 'OrderController@payusuccess');
     //Route::get('success', 'OrderController@payusuccess');
     
     Route::get('fail', 'OrderController@payufail');
     Route::post('fail', 'OrderController@payufail');
     
     Route::get('payment-cancel', 'OrderController@paypal_fail');
     Route::get('payment-success', 'OrderController@paypal_success');
     Route::get('payment-process', 'OrderController@paypal_process');
     /*Route::post('payment', function(Illuminate\Http\Request $request){
    return dd($request->all());
});*/
     
      });
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
   
    Route::resource('categories', 'CategoriesController');
    Route::get('categories/subindex/{slug}', ['as' => 'admin.subindex', 'uses' => 'CategoriesController@subindex']);
    Route::get('categories/addsubcategory/{slug}', ['as' => 'admin.addsubcategory', 'uses' => 'CategoriesController@addsubcategory']);
    Route::post('categories/addsubcategory/{slug}', ['as' => 'admin.addsubcategory.store', 'uses' => 'CategoriesController@addsubcategory_store']);
    Route::get('categories/editsubcategory/{slug}/{main}', ['as' => 'admin.editsubcategory', 'uses' => 'CategoriesController@editsubcategory']);
    Route::post('categories/editsubcategory/{slug}/{main}', ['as' => 'admin.editsubcategory.update', 'uses' => 'CategoriesController@editsubcategory_update']);
    Route::post('categories/subindex/{id}/{mainslug}', ['as' => 'admin.subindex.delete', 'uses' => 'CategoriesController@subindex_delete']);
    
    Route::get('categories/addsubsubcategory/{slug}/{subslug}', ['as' => 'admin.addsubsubcategory', 'uses' => 'CategoriesController@addsubsubcategory']);
    Route::post('categories/addsubsubcategory/{slug}/{subslug}', ['as' => 'admin.addsubsubcategory.store', 'uses' => 'CategoriesController@addsubsubcategory_store']);
    Route::get('categories/subsubindex/{subslugs}', ['as' => 'admin.subsubindex', 'uses' => 'CategoriesController@subsubindex']);
    Route::get('categories/editsubsubcategory/{slug}/{main}/{subslug}', ['as' => 'admin.editsubsubcategory', 'uses' => 'CategoriesController@editsubsubcategory']);
    Route::post('categories/editsubsubcategory/{slug}/{main}/{subslug}', ['as' => 'admin.editsubsubcategory.update', 'uses' => 'CategoriesController@editsubsubcategory_update']);
    
    
    Route::post('updateOrders/{id}', ['as' => 'orders.update', 'uses' => 'OrderController@updateOrder']);
   
    Route::resource('size', 'SizeController');
    Route::resource('brands', 'BrandController');
    Route::resource('enquiry', 'EnquiryController');
    Route::resource('pincode', 'PincodeController');
    Route::resource('colors', 'ColorsController');
    Route::group(['middleware' => 'IsNotAuthenticated'], function() {
        //Route::get('login', function() { return View::make('home'); });
        Route::get('login', ['as' => 'admin.login', 'uses' => 'AuthController@getLogin']);
        Route::post('login', ['as' => 'admin.login', 'uses' => 'AuthController@postLogin']);
        Route::get('forgot-password', ['as' => 'admin.forgot_password', 'uses' => 'UsersController@forgotPassword']);
        Route::post('forgot-password', ['as' => 'admin.forgot_password', 'uses' => 'UsersController@sendPasswordLink']);
        Route::get('reset-password/{email_token}', ['as' => 'admin.reset_password', 'uses' => 'UsersController@resetPassword']);
        Route::post('reset-password/{email_token}', ['as' => 'admin.reset_password', 'uses' => 'UsersController@resetPasswordUpdate']);
    });
    Route::get('actvie-link/{email_token}', ['as' => 'admin.resetAccountlink', 'uses' => 'UsersController@resetAccountlink']);

    Route::group(['middleware' => 'auth.admin'], function() {
        /* dashboard tab */
        Route::resource('dashboard', 'PagesController');
        Route::get('cms-status-change/{id}/{status}', ['as' => 'admin.cms.status_change', 'uses' => 'CmsController@status_change']);
        Route::resource('cms', 'CmsController');
        /* site management tab */
        Route::resource('settings', 'SettingsController');
        Route::resource('emailtemplates', 'EmailtemplatesController');
        Route::resource('emaillogs', 'EmailLogsController');

        /* users tab */
        Route::get('user-status-change/{id}/{status}', ['as' => 'admin.users.status_change', 'uses' => 'UsersController@status_change']);
        Route::get('send-credentials/{id}', ['as' => 'admin.users.send_credentials', 'uses' => 'UsersController@sendCredentials']);
        //Route::post('users/list', array('as' => 'admin_user_search', 'uses' => 'UsersController@admin_user_search'));
        //Route::get('users/list', array('as' => 'admin_user_index', 'uses' => 'UsersController@index'));
        Route::post('users/index', array('as' => 'admin_user_search', 'uses' => 'UsersController@index'));
        Route::resource('users', 'UsersController');
        Route::get('contacts/contactList', array('as' => 'admin_contacts.contact_list', 'uses' => 'UsersController@contactList'));
        Route::get('visitors', ['as' => 'admin.visitors', 'uses' => 'PagesController@visitors']);

        Route::resource('newsletter-campaign', 'NewsletterCampaignController');
		Route::resource('newsletter-subscriber', 'NewsletterSubscriberController');
		Route::resource('newsletter', 'NewsletterController');
		Route::get('campaign-status-change/{id}/{status}', ['as'=>'admin.newsletter-campaign.status_change','uses' => 'NewsletterCampaignController@status_change']);
		Route::get('campaign-delete/{id}', ['as'=>'admin.newsletter-campaign.delete','uses' => 'NewsletterCampaignController@delete']);
		Route::get('campaign-send/{id}', ['as'=>'admin.newsletter-campaign.send_mail','uses' => 'NewsletterCampaignController@sendMail']);
		Route::get('subscriber-status-change/{id}/{status}', ['as'=>'admin.newsletter-subscriber.status_change','uses' => 'NewsletterSubscriberController@status_change']);
		Route::get('newsletter-subscriber-delete/{id}', ['as'=>'admin.newsletter-subscriber.delete','uses' => 'NewsletterSubscriberController@delete']);
		Route::get('newsletter-status-change/{id}/{status}', ['as'=>'admin.newsletter.status_change','uses' => 'NewsletterController@status_change']);
		Route::get('newsletter-delete/{id}', ['as'=>'admin.newsletter.delete','uses' => 'NewsletterController@delete']);
		Route::get('manage-schedule/{id}', ['as'=>'admin.newsletter.manage_schedule','uses' => 'NewsletterController@manageSchedule']);
		Route::post('manage-schedule/{id}', ['as'=>'admin.newsletter.manageScheduleStore','uses' => 'NewsletterController@manageScheduleStore']);
		
		
		Route::get('orders', ['as'=>'admin.orders','uses' => 'OrderController@index']);
                Route::post('orders', ['as'=>'admin.orders.search','uses' => 'OrderController@index']);
		Route::get('orders/{id}/view', ['as'=>'admin.view','uses' => 'OrderController@viewOrder']);
		
		Route::post('banner/index', ['as' => 'admin.banner_search', 'uses' => 'BannerController@index']);
		Route::resource('banner', 'BannerController');
        /* admin menu */
        Route::resource('adminmenus', 'AdminMenuController');
        Route::get('adminmenu-status-change/{id}/{status}/{parent_id?}', ['as' => 'admin.adminmenus.status_change', 'uses' => 'AdminMenuController@status_change']);
        Route::get('child-adminmenu/{id?}', ['as' => 'admin.adminmenus.child_menu', 'uses' => 'AdminMenuController@childMenu']);
        Route::get('add-adminmenu/{id?}', ['as' => 'admin.adminmenus.create', 'uses' => 'AdminMenuController@create']);
        Route::post('add-adminmenu/{id?}', ['as' => 'admin.adminmenus.store', 'uses' => 'AdminMenuController@store']);
        Route::get('edit-adminmenu/{id}/{parent_id?}', ['as' => 'admin.adminmenus.edit', 'uses' => 'AdminMenuController@edit']);
        Route::post('edit-adminmenu/{id}/{parent_id?}', ['as' => 'admin.adminmenus.update', 'uses' => 'AdminMenuController@update']);
        Route::resource('menus', 'MenuController');
        Route::get('add-menu/{id?}', ['as' => 'admin.menus.create', 'uses' => 'MenuController@create']);
        Route::post('add-menu/{id?}', ['as' => 'admin.menus.store', 'uses' => 'MenuController@store']);
        Route::get('menu-status-change/{id}/{status}/{parent_id?}', ['as' => 'admin.menus.status_change', 'uses' => 'MenuController@status_change']);
        Route::get('child-menu/{id?}', ['as' => 'admin.menus.child_menu', 'uses' => 'MenuController@childMenu']);
        Route::get('edit-menu/{id}/{parent_id?}', ['as' => 'admin.menus.edit', 'uses' => 'MenuController@edit']);
        Route::post('edit-menu/{id}/{parent_id?}', ['as' => 'admin.menus.update', 'uses' => 'MenuController@update']);


        
    Route::post('category_change/{id}', ['as' => 'category_change', 'uses' => 'ProductsController@getsubcategory']);  
    Route::post('subcategory_change/{id}', ['as' => 'subcategory_change', 'uses' => 'ProductsController@getsubsubcategory']); 
    
    
    
    
    Route::get('products/addimage/{id}', ['as' => 'web.addimage', 'uses' => 'ProductsController@addimage']);
    Route::post('products/addimage/{id}', ['as' => 'web.update_image', 'uses' => 'ProductsController@update_image']);
    Route::post('remove_attachment', ['as' => 'remove_attachment', 'uses' => 'ProductsController@remove_attachment']);
    
    Route::get('products/product_parameter/{id}/{product_id}/{color_id}', ['as' => 'remove_product_parameter', 'uses' => 'ProductsController@remove_product_parameter']);
    Route::get('products/product_qtyupdate/{id}/{qty}', ['as' => 'update_product_qty', 'uses' => 'ProductsController@update_product_qty']);
    
    
    Route::post('products/index', ['as' => 'admin.products_search', 'uses' => 'ProductsController@index']);
    Route::get('product-status-change/{id}/{status}', ['as' => 'admin.products.status_change', 'uses' => 'ProductsController@status_change']);
    Route::resource('products', 'ProductsController');

  
        /* extra routes */
        Route::get('profile', ['as' => 'admin.profile', 'uses' => 'UsersController@profile']);
        Route::post('profile', ['as' => 'admin.updateProfile', 'uses' => 'UsersController@updateProfile']);
        Route::get('change-password', ['as' => 'admin.ChangePassword', 'uses' => 'UsersController@ChangePassword']);
        Route::post('change-password', ['as' => 'admin.UpdateChangePassword', 'uses' => 'UsersController@UpdateChangePassword']);
        Route::get('view-emaillogs/{id}', ['as' => 'admin.view_emaillogs', 'uses' => 'EmailLogsController@view']);
        Route::get('logout', ['as' => 'admin.logout', 'uses' => 'AuthController@getLogout']);
        Route::get('/', ['as' => 'dashboard', 'uses' => 'PagesController@index']);
        Route::get('upload-ckeditor-images', ['as' => 'upload_ckeditor_images', 'uses' => 'PagesController@uploadCkeditorImages']);
        Route::get('category/{id?}', ['as' => 'admin.category.index', 'uses' => 'CategoryController@index']);
        Route::get('edit-category/{id}/{parent_id?}', ['as' => 'admin.category.edit', 'uses' => 'CategoryController@edit']);
        Route::post('edit-category/{id}/{parent_id?}', ['as' => 'admin.category.update', 'uses' => 'CategoryController@update']);
        Route::get('add-category/{id?}', ['as' => 'admin.category.create', 'uses' => 'CategoryController@create']);
        Route::post('add-category/{id?}', ['as' => 'admin.category.store', 'uses' => 'CategoryController@store']);
        
        Route::get('category-status-change/{id}/{status}', ['as' => 'admin.category.status_change', 'uses' => 'CategoriesController@status_change']);
        /* extra routes */
    });
});
Route::group(['namespace' => 'Api'], function() {
    Route::post('api', 'ApiController@index');
});
require base_path() . '/global_constants.php';

Route::resource('cms', 'CmsController');

  Route::get('cms-status-change/{id}/{status}', ['as'=>'admin.cms.status_change','uses' => 'CmsController@status_change']);
  ?>
<?php /* ?>     
  Route::get('campaign-status-change/{id}/{status}', ['as'=>'admin.newsletter-campaign.status_change','uses' => 'NewsletterCampaignController@status_change']);
  Route::get('campaign-delete/{id}', ['as'=>'admin.newsletter-campaign.delete','uses' => 'NewsletterCampaignController@delete']);
  Route::get('campaign-send/{id}', ['as'=>'admin.newsletter-campaign.send_mail','uses' => 'NewsletterCampaignController@sendMail']);
  Route::get('visitor-history/{id}', ['as' => 'admin.visitor_history', 'uses' => 'PagesController@visitorHistory']);
  Route::get('blog-status-change/{id}/{status}', ['as'=>'admin.blog.status_change','uses' => 'BlogController@status_change']);
  Route::get('blog-delete/{id}', ['as'=>'admin.blog.delete','uses' => 'BlogController@delete']);
  Route::get('subscriber-status-change/{id}/{status}', ['as'=>'admin.newsletter-subscriber.status_change','uses' => 'NewsletterSubscriberController@status_change']);
  Route::get('newsletter-subscriber-delete/{id}', ['as'=>'admin.newsletter-subscriber.delete','uses' => 'NewsletterSubscriberController@delete']);
  Route::get('newsletter-status-change/{id}/{status}', ['as'=>'admin.newsletter.status_change','uses' => 'NewsletterController@status_change']);
  Route::get('newsletter-delete/{id}', ['as'=>'admin.newsletter.delete','uses' => 'NewsletterController@delete']);
  Route::get('manage-schedule/{id}', ['as'=>'admin.newsletter.manage_schedule','uses' => 'NewsletterController@manageSchedule']);
  Route::post('manage-schedule/{id}', ['as'=>'admin.newsletter.manageScheduleStore','uses' => 'NewsletterController@manageScheduleStore']);
  Route::resource('cms', 'CmsController');
  Route::get('cms-status-change/{id}/{status}', ['as'=>'admin.cms.status_change','uses' => 'CmsController@status_change']);
  });
  });
  <?php */ ?>


