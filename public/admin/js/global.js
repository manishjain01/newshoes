$(document).ready(function(){

  
        
 if($('.autocomplete1').length>0){       
    $(".autocomplete1").select2({
        placeholder : "Please Select",
        width: '220'		
    });
 }
if($('.minimal').length>0){   
 $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
	/* END PASSWORD STRENGTH INDICATOR */

 }
 });
  jQuery(window).load(function() {
        jQuery('.loading-cntant').fadeOut(1000);
    });
function blockUI(){

    
     jQuery('.loading-cntant').fadeIn(1000);
}

function unblockUI()
{

    jQuery('.loading-cntant').fadeOut(1000);
}


$(document).on('click', '.btn-delete', function(){

    $this=  $(this);
    
   
            bootbox.confirm($this.attr('data-alert'), function(result) {
                if(result){
                   blockUI();
                  
                                $this.children(".delete_form").submit();
                       
                }
            });
});
$(document).on('click', '.confirm_link', function(event){
 event.preventDefault()
    $this=  $(this);
    
   
            bootbox.confirm($this.attr('data-alert'), function(result) {
                if(result){
                   blockUI();
                    window.location.href = $this.attr('href');
                             
                       
                }
            });
            return false;
});

function customer_signup(){
    blockUI();
    var url	= $("#customer_signup").attr("href");
    $.ajax({
        url:url,
        async : true,
        success:function(data){
            $('#customer_signup_popup').html('');
            $('#customer_signup_popup').html(data);
            $('#customer_signup_popup').modal('show');
            $('.default').dropkick();
            $('.dk_container').first().focus();
            unblockUI();
        }
    });   
    return false;
}


function showSuccessMessageBottomRight(msg)
{
    noty({
        layout : 'bottomRight', 
        theme : 'noty_theme_default', 
        type : 'success',     
        text: msg ,     
        timeout : 10000,
        closeButton:true,
        animation : {
            easing: 'swing',
            speed: 150 // opening & closing animation speed
        }		
    });
}
function showErrorMessageBottomRight(msg){
    noty({
        layout : 'bottomRight', 
        theme : 'noty_theme_default', 
        type : 'error',     
        text: msg ,     
        timeout : 10000,
        closeButton:true,
        animation : {
            easing: 'swing',
            speed: 150 // opening & closing animation speed
        }		
    });
}


function showSuccessMessageTopCenter(msg)
{
    noty({
        layout : 'Top', 
        theme : 'noty_theme_default', 
        type : 'success',     
        text: msg ,     
        timeout : 10000,
        closeButton:true,
        animation : {
            easing: 'swing',
            speed: 150 // opening & closing animation speed
        }		
    });
}
function showErrorMessageTopCenter(msg){
    noty({
        layout : 'Top', 
        theme : 'noty_theme_default', 
        type : 'error',     
        text: msg ,     
        timeout : 10000,
        closeButton:true,
        animation : {
            easing: 'swing',
            speed: 150 // opening & closing animation speed
        }		
    });
}



function showSuccessMessageTopRight(msg){
    noty({
        layout : 'topRight', 
        theme : 'noty_theme_default', 
        type : 'success',     
        text: msg ,     
        timeout : 10000,
        closeButton:true,
        animation : {
            easing: 'swing',
            speed: 150 // opening & closing animation speed
        }		
    });
}
