/**
 * DESCRIPTION.
 *
 * Flutterwave Payment Solutions
 *
 *  @author    Kingsley Paragon
 *  @copyright 2023 Kingsley Paragon
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License ("AFL") v. 3.0
 */

 (function($) {
    "use strict";


$('body').on('click', '#load_forgot_password_form', function(ev){
       ev.preventDefault();
       $('#app_hosting_password_recovery').removeClass('display_none');
       $('#app_hosting_login_form').addClass('display_none');

});


$('body').on('click', '#ap_load_login_form', function(ev){
       ev.preventDefault();
       $('#app_hosting_password_recovery').addClass('display_none');
       $('#app_hosting_login_form').removeClass('display_none');

});

// LOGIN TO ACCOUNT NOW 

$('body').on('submit', '#app_hosting_login_form', function(ev){
       ev.preventDefault();
      let loginformdata =$(this).serialize()+'&action=noPrivActionsBaseField&request_token=APCUKBTDRSXKVPKEAGYRUVXCUCEXPQSXYGQLUKJVFHZELUEHQKDCALJQKRBVSOLL';
      let ajbtn = $('#ap_login_to_account_btn');
      let btn_text = ajbtn.html();
       ajbtn.html( btn_text+'..........').prop('disabled', true);

      $.ajax({
           url:frontAjax,
           type:"post",
           data:loginformdata,
           dataType:'json',
           success:function(report){
            ajbtn.html(btn_text).prop('disabled', false);
            if(report['status'] =='OK'){
              popNotification(report.message, 'success');
               window.location = report.url;
            }
            else{
                popNotification(report.message, 'error');
            }

           },
           error:function(report){
            ajbtn.html(btn_text).prop('disabled', false);
             popNotification(report.responseText, 'error'); 
           }

      });

});




// REGISTER ACCOUNT NOW

$('body').on('submit', '#app_hosting_account_creation_form', function(ev){
       ev.preventDefault();
      let accountformdata =$(this).serialize()+'&action=noPrivActionsBaseField&request_token=APVXIMJWFRUQOBCPKWYFAAAUNWCLRLHHQTQMXLIXBSGCEUAQDQAHKLEZMBZTNGON';
      let ajbtn = $('#ap_create_an_account_btn');
      let btn_text = ajbtn.html();
       ajbtn.html( btn_text+'..........').prop('disabled', true);
      $.ajax({
           url:frontAjax,
           type:"post",
           data:accountformdata,
           dataType:'json',
           success:function(report){
            ajbtn.html(btn_text).prop('disabled', false);
            if(report['status'] =='OK'){
              popNotification(report.message, 'success');
               window.location = report.url;

            }
            else{
             popNotification(report.message, 'error');
            }

           },
           error:function(report){
             ajbtn.html(btn_text).prop('disabled', false);
             popNotification(report.responseText, 'error');  
           }

      });

});


$('body').on('submit', '#app_hosting_password_recovery', function(ev){
       ev.preventDefault();
      let recformdata =$(this).serialize()+'&action=noPrivActionsBaseField&request_token=APKVQSMDSOTHBPSAZMQJAXTVGBINBTBIDKXAKRCQSSCMLPKPKQOJFDCSLUKQXOOO';
      let ajbtn = $('#ap_recovery_password_btn');
      let btn_text = ajbtn.html();
       ajbtn.html( btn_text+'..........').prop('disabled', true);
      $.ajax({
           url:frontAjax,
           type:"post",
           data:recformdata,
           dataType:'json',
           success:function(report){
            ajbtn.html(btn_text).prop('disabled', false);
            if(report['status'] =='OK'){
               popNotification(report.message, 'success');

            }
            else{
             popNotification(report.message, 'error'); 
            }

           },
           error:function(report){
             ajbtn.html(btn_text).prop('disabled', false);
             popNotification(report.responseText, 'error'); 
             
           }

      });

});




// $(document).on('ajaxStart', function(){
//     $('.spinner_process_showcase').removeClass('display_none');
// });


// $(document).on('ajaxComplete', function(){
//     $('.spinner_process_showcase').addClass('display_none'); 
// });


$('body').on('submit', '#ap_contact_form', function(ev){
       ev.preventDefault();
      let recformdata =$(this).serialize()+'&action=noPrivActionsBaseField&request_token=APERBKEYTTXDAPIRLCSYVQFVEIQXMFWITSLEKICEDJXDXVZZJSAZAJABAZHWZBHH';
      let ajbtn = $(this).find('button').find('.indicator-label');
      let btn_text = ajbtn.html();
       ajbtn.html( btn_text+'..........').prop('disabled', true);
      $.ajax({
           url:frontAjax,
           type:"post",
           data:recformdata,
           dataType:'json',
           success:function(report){
            ajbtn.html(btn_text).prop('disabled', false);
            if(report['status'] =='OK'){
               popNotification(report.message, 'success');

            }
            else{
             popNotification(report.message, 'error'); 
            }

           },
           error:function(report){
             ajbtn.html(btn_text).prop('disabled', false);
             popNotification(report.responseText, 'error'); 
             
           }

      });

});

















})(jQuery);//ready

