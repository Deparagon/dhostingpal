/**
 * DESCRIPTION.
 *
 * app hosting : Domain Hosting Pal
 *
 *  @author    Kingsley Paragon
 *  @copyright 2023 Kingsley Paragon
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License ("AFL") v. 3.0
 */

 (function($) {
    "use strict";

$('body').on('click', '.delete_item_from_the_list', function(ev){
	    ev.preventDefault();
	    doObjectDeletion($(this));

});

$('body').on('click', '.item_view_edit_process_btn', function(ev){
	   ev.preventDefault();
	   ajaxObjectViewer( $(this));

});


$('body').on('submit', '#ap_submit_address_update_form', function(ev){
	  ev.preventDefault();
	  $.ajax({
	  	 url:frontAjax,
	  	 dataType:'json',
	  	 data:$(this).serialize()+'&action=internalActions&request_token=APTPYAVGNYCXXEHSJHXBPFESGAHUFWFZMNHSQYQSSTNPPLDISJXDCGKDLENBHOTV',
	  	 type:'post',
	  	 success:function(report){
	  	 	if(report.status=='OK'){
	  	 		popNotification(report.message, 'success', 'Close');
	  	 	}
	  	 	else{
	  	 		popNotification(report.message, 'error', 'Close');
	  	 	}

	  	 },
	  	 error:function(report){
                 popNotification(report.responseText, 'error', 'OK');
	  	 }

	  });

});



$('body').on('click', '.ap_domain_type_change', function(ev){
	//$(this).prop('checked', true);
	   if( $(this).val() =='Register'){
            $('.ap_holding_domain_input_box').removeClass('display_none');
            $('.ap_domain_check_report_group').removeClass('display_none');
            $('#proceed_to_next_action').addClass('disabled').prop('disabled', true);

	   }
	   else{
           $('.ap_holding_domain_input_box').removeClass('display_none');
           $('.ap_domain_check_report_group').addClass('display_none');
           $('#proceed_to_next_action').removeClass('disabled').prop('disabled', false);
	   }

});


 $('body').on('click', '#domain_availability_checker_btn',function(ev){
                   ev.preventDefault();
   
		if( $('#domain_name').val().length < 1){
             return false;
		}

	  let ajbtn = $(this);
      let btn_text = ajbtn.html();
       ajbtn.html( btn_text+'..........').prop('disabled', true);

		$('#proceed_to_next_action').addClass('disabled').prop('disabled', true);
		$.ajax({
			url:frontAjax,
			type:'post',
			data:{'domain_name':$('#domain_name').val(), 'action':'frontActionsBaseField', 'request_token':'APYJFRBCIYIBUOKHTYCLEYRSFFZSQIPLNQEJJLMERQOSUYNBVZTGYUZYVRURUMDU'}, 
			dataType:'json',
			success:function(report){
				ajbtn.html(btn_text).prop('disabled', false);
				if(report.status=='OK'){
					
					$('.ap_domain_check_response_box').html(report.contents);
					if(report.available =='Yes'){
						popNotification(report.message, 'success');
						$('#proceed_to_next_action').removeClass('disabled').prop('disabled', false);
					}
					else{
						popNotification(report.message, 'error');
						$('#proceed_to_next_action').addClass('disabled').prop('disabled', true);
					}
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


$('body').on('click', '#proceed_to_next_action', function(ev){
	          ev.preventDefault();
	    	  let ajbtn = $(this);
      let btn_text = ajbtn.html();
      ajbtn.html( btn_text+'..........').prop('disabled', true);
       var domainType = $('.ap_domain_type_change:checked').val();
	  $.ajax({
	  		url:frontAjax,
			type:'post',
			data:{'domain_name':$('#domain_name').val(), 'domain_type': domainType, 'action':'frontActionsBaseField', 'request_token':'APQOFYDZMAMYNJZQRHWGYATTVJNZMDWNAIKRNCWFEAOWSKCMTHTQAQQYJGAUJFGA'}, 
			dataType:'json',
			success:function(report){
				ajbtn.html(btn_text).prop('disabled', false);
				if(report.status=='OK'){
					
					$('#report_ajax_domain_progress_sucess').html(report.contents);
					$('#proceed_to_next_action').addClass('display_none');
					$('#proceed_to_domain_registration_only').removeClass('display_none');
					
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

$('body').on('click', '#proceed_to_domain_registration_only', function(ev){
	  ev.preventDefault();
	  $('#domain_registration_payment_process').submit();

});

$('body').on('submit', '#domain_registration_payment_process', function(ev){
        ev.preventDefault();
       let ajbtn = $('#proceed_to_domain_registration_only');
      let btn_text = ajbtn.html();
       ajbtn.html( btn_text+'..........').prop('disabled', true);
	  $.ajax({
	  		url:frontAjax,
			type:'post',
			data:$(this).serialize()+'&action=frontActionsBaseField&request_token=APERBKEYTTXDAPIRLCSYVQFVEIQXMFWITSLEKICEDJXDXVZZJSAZAJABAZHWZBHH', 
			dataType:'json',
			success:function(report){
				ajbtn.html(btn_text).prop('disabled', false);
				if(report.status=='OK'){
					$('.ap_bank_payment_details_dws').addClass('display_none');
					if(report.url !=''){
                               window.location = report.url;
                               }
                               else{
                               	// show bank payment here
                               $('.ap_bank_payment_details_dws').removeClass('display_none');
                               }
					
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


$('body').on('change', '#ap_selected_registrant_address', function(ev){
	     ev.preventDefault();
          if( parseInt($(this).val()) > 0 ){
          	  $('#ap_address_registrant_complete').addClass('display_none');
          }
          else{
          	$('#ap_address_registrant_complete').removeClass('display_none');
          }

});

// create_ticket_form


$('body').on('submit', '#ap_create_ticket_form', function(ev){
	     ev.preventDefault();
   
    let deform = document.getElementById("ap_create_ticket_form");
    let fdata = new FormData(deform );
     $.ajax({
 	  url:frontAjax,
 	  type:'post',
 	  dataType:'json',
 	  data: fdata,
	  processData: false,
        contentType: false,
 	  success:function(report){
      if(report.status =='OK'){
 	   popNotification(report.message, 'success', 'OK');

 	   setTimeout(function(){
               window.location.reload();
 	   }, 2000);
 	}
 	else{
 	 popNotification(report.message, 'error', 'OK');
 	}
 	
 	  },
 	  error:function(report){
           	popNotification(report.responseText, 'error', 'OK');
 	  }
 });

});



$('body').on('click', '.ap_perform_ticket_actions', function(ev){
	  ev.preventDefault();
	   let datainfo = {'object':$(this).data('object'), 'id':$(this).data('id_object'), 'viewtype':$(this).data('viewtype'), 'request_token':'APNOLSBPAJWRLKTPCFCGTXARACZSKALILUTUJNMATOAABXNGDPVVLIWOUXUNTFXB', 'action':'internalActions'}
	  $.ajax({
	  	 url:frontAjax,
	  	 dataType:'json',
	  	 type:'post',
	  	 data:datainfo,
	  	 success:function(report){
	  	 	if(report.status=='OK'){
	  	 		
	  	popNotification(report.message, 'success', 'Close');
	  	 	}
	  	 	else{
	  	 		popNotification(report.message, 'error', 'Close');
	  	 	}

	  	 },
	  	 error:function(report){
                 popNotification(report.responseText, 'error', 'OK');
	  	 }

	  });

});


$('body').on('submit', '#ap_inbox_reply_form', function(ev){
	     ev.preventDefault();
   
    let deform = document.getElementById("ap_inbox_reply_form");
    let fdata = new FormData(deform);
     $.ajax({
 	  url:frontAjax,
 	  type:'post',
 	  dataType:'json',
 	  data: fdata,
	  processData: false,
        contentType: false,
 	  success:function(report){
      if(report.status =='OK'){
 	   popNotification(report.message, 'success', 'OK');
 	}
 	else{
 	 popNotification(report.message, 'error', 'OK');
 	}
 	
 	  },
 	  error:function(report){
           	popNotification(report.responseText, 'error', 'OK');
 	  }
 });

});


$('body').on('click', '#rattachments_select', function(){
      $('#rattachment_file').trigger('click');
});

$("body").on('change', '#rattachment_file', function() {
  readURL(this, 'holding_rattachment_img');
});


    const handlePreviewText = () => {
        // Get all messages
        const accordions = document.querySelectorAll('[data-kt-inbox-message="message_wrapper"]');
        accordions.forEach(accordion => {
            // Set variables
            const header = accordion.querySelector('[data-kt-inbox-message="header"]');
            const previewText = accordion.querySelector('[data-kt-inbox-message="preview"]');
            const details = accordion.querySelector('[data-kt-inbox-message="details"]');
            const message = accordion.querySelector('[data-kt-inbox-message="message"]');

            // Init bootstrap collapse -- more info: https://getbootstrap.com/docs/5.1/components/collapse/#via-javascript
            const collapse = new bootstrap.Collapse(message, { toggle: false });

            // Handle header click action
            header.addEventListener('click', e => {
                // Return if KTMenu or buttons are clicked
                if (e.target.closest('[data-kt-menu-trigger="click"]') || e.target.closest('.btn')) {
                    return;
                } else {
                    previewText.classList.toggle('d-none');
                    details.classList.toggle('d-none');
                    collapse.toggle();
                }
            });
        });
    }


var ap_is_reply_page = $('#ap_is_reply_page').val();
if(ap_is_reply_page !=undefined  && ap_is_reply_page =='1'){
	handlePreviewText();
}


$('body').on('submit', '#ap_account_profile_details_form', function(ev){
	   ev.preventDefault();
	  let btn_s = $(this).find('button');
	  let btn_text = btn_s.html();
	  btn_s.html(btn_text+' '+tiny_spin_btn);

	  let formprofile = $(this).serialize()+'&action=internalActions&request_token=APCUHHFTXIMXTRDHFCOIRBPDVHSQQJWZPWWPUOMSHXJLNEDRXZAWYMZWGZHWUTDQ';

	  $.ajax({
	  	 url:frontAjax,
	  	 dataType:'json',
	  	 type:'post',
	  	 data:formprofile,
	  	 success:function(report){
	  	 	btn_s.html(btn_text);
	  	 	if(report.status=='OK'){
	  	 		popNotification(report.message, 'success', 'OK');
	  	 	}
	  	 	else{
	  	 		popNotification(report.message, 'error', 'Close');
	  	 	}

	  	 },
	  	 error:function(report){
	  	 	btn_s.html(btn_text);
                 popNotification(report.responseText, 'error', 'OK');
	  	 }

	  });


})


})(jQuery);//ready




$(document).ready(function(){








$('body').on('keyup', '.search_object_display_result', function(ev){
      if( $(this).val().length >2){
       let ajaxurl = $(this).data('url');
      	$.ajax({
      		 url:ajaxurl,
      		 data:{'search_term':$(this).val()},
      		 dataType:'json',
      		 type:'get',
      		 success:function(report){

      		 	if(report.status=='OK'){
      		 		$('#searchable_tbody_contents').html(report.contents);
      		 	}
      		 	else{
      		 		popNotification(report.message, 'error', 'Close');
      		 	}

      		 },
      		 error:function(report){
                    popNotification(report.responseText, 'error', 'Close');
      		 }
      	})
      }
});





$('body').on('click', '#resend_email_verification_link', function(ev){
	   ev.preventDefault();
      $.ajax({
      	 url:'/auth/verification-link/'+$(this).data('account_id'),
      	 type:'get',
      	 dataType:'json',
      	 success:function(report){
      	 	if(report.status=='OK'){
                      popNotification(report.message, 'success');
      	 	}
      	 	else{
                    popNotification(report.message, 'error');
      	 	}

      	 },
      	 error:function(report){
                popNotification(report.responseText, 'error');
      	 }
      })

});


$('body').on('click', '#kt_signin_email_button', function(){
      $('#kt_signin_email_edit').removeClass('d-none');
      $('#just_signin_email').addClass('d-none');
      $(this).addClass('d-none');
});

$('body').on('click', '#just_signin_password_button', function(){
      $('#just_signin_password_edit').removeClass('d-none');
      $('#just_signin_password').addClass('d-none');
      $(this).addClass('d-none');
});

$('body').on('click', '#just_password_cancel', function(){
      $('#just_signin_password_edit').addClass('d-none');
      $('#just_signin_password').removeClass('d-none');
      $('#just_signin_password_button').removeClass('d-none');
});




$('body').on('click', '.reply_scroll_btn', function(ev){
	  ev.preventDefault();
	  scrollToThisDiv();

});

$('body').on('click', '.scroll_to_password_div', function(ev){
	  ev.preventDefault();
	  $("html, body").animate({ scrollTop: $(document).height()-500 }, 1000);
	 
});

});//ready