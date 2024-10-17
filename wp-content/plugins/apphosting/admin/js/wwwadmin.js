/*

   document starts


*/


(function($) {
  "use strict";


	$('body').on('submit', '#ap_modal_create_plan_form', function(ev){
		      ev.preventDefault();
		  let btn = $(this).find('button[type="submit"]');
		  let btn_name = btn.html();
		   btn.html(btn_name + all_place_spin).prop('disabled', true);

          let req_data = $(this).serialize()+'&action=manageHostingPlans&request_token=APLVXSTFPLBRZNXFGYUWNDPIQCEFOGJEWLTEIIIVFWKWKYAMWYMZRKDRUETRULKG';
		   $.ajax({
		   	   url:ajaxurl,
		   	   type:'post',
		   	   dataType:'json',
		   	   data:req_data,
		   	   success:function(report){
		   	   	 btn.html(btn_name).prop('disabled', false);
                  if(report.status =='OK'){
                      popNotification(report.message, 'success');
                  }
                  else{
                  	popNotification(report.message, 'error');
                  }
		   	   },
		   	   error:function(report){
		   	   	      btn.html(btn_name).prop('disabled', false);
                      popNotification(report.responseText, 'error');
		   	   }
		   })

	});


$('body').on('click', '.ap_edit_object_plan_btn', function(ev){
	  ev.preventDefault();
	  $.ajax({
	  	 url:ajaxurl,
	  	 dataType:'json',
	  	 data: {'id_plan': $(this).data('object_id'),'action':'manageHostingPlans','request_token':'APVWUMEQKQEPSXBPUZTLAHILUXEDYFHUVWOHFFBXEGZPKHLJETZNHWMLJLYNEWOW'},
	  	 type:'post',
	  	 success:function(report){
	  	 	if(report.status=='OK'){
	  	 		$('#ap_content_editor_load_ajax').html(report.contents);
	  	 		$('#ap_edit_plan_modal').modal('show');
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

// edit plan
	$('body').on('submit', '#ap_modal_edit_plan_form', function(ev){
		      ev.preventDefault();
		  let btn = $(this).find('button[type="submit"]');
		  let btn_name = btn.html();
		   btn.html(btn_name + all_place_spin).prop('disabled', true);

          let req_data = $(this).serialize()+'&action=manageHostingPlans&request_token=APBRVQKCEWJNSYZXFKVHSMCJMXCWYQSNGBXNIQVOTOLGEKKSOPOXBXDEOFQJAHEL';
		   $.ajax({
		   	   url:ajaxurl,
		   	   type:'post',
		   	   dataType:'json',
		   	   data:req_data,
		   	   success:function(report){
		   	   	 btn.html(btn_name).prop('disabled', false);
                  if(report.status =='OK'){
                      popNotification(report.message, 'success');
                  }
                  else{
                  	popNotification(report.message, 'error');
                  }
		   	   },
		   	   error:function(report){
		   	   	      btn.html(btn_name).prop('disabled', false);
                      popNotification(report.responseText, 'error');
		   	   }
		   })

	});
//continued



// ORDERING BACKEND

	$('body').on('click', '#app_review_order_button', function(ev){
		      ev.preventDefault();
		  let btn = $(this);
		  let btn_name = btn.html();
		   btn.html(btn_name + all_place_spin).prop('disabled', true);

          let req_data = $('#ap_modal_create_order_form').serialize()+'&action=manageHostingOrders&request_token=APKJNRJWLGGDFTUETTDIWRXGGGHEELOFJWIVMTLLFMPRBTQOCXXXUQUFFQGJWHZM';
		   $.ajax({
		   	   url:ajaxurl,
		   	   type:'post',
		   	   dataType:'json',
		   	   data:req_data,
		   	   success:function(report){
		   	   	 btn.html(btn_name).prop('disabled', false);
                  if(report.status =='OK'){
                      popNotification(report.message, 'success');
                      $('#ajax_return_values_innerline').html(report.contents);
                  }
                  else{
                  	popNotification(report.message, 'error');
                  }
		   	   },
		   	   error:function(report){
		   	   	      btn.html(btn_name).prop('disabled', false);
                      popNotification(report.responseText, 'error');
		   	   }
		   })

	});



	$('body').on('click', '#ap_create_new_order', function(ev){
		      ev.preventDefault();
		  let btn = $(this);
		  let btn_name = btn.html();
		   btn.html(btn_name + all_place_spin).prop('disabled', true);

          let req_data = $('#ap_modal_create_order_form').serialize()+'&action=manageHostingOrders&request_token=APNOLSBPAJWRLKTPCFCGTXARACZSKALILUTUJNMATOAABXNGDPVVLIWOUXUNTFXB';
		   $.ajax({
		   	   url:ajaxurl,
		   	   type:'post',
		   	   dataType:'json',
		   	   data:req_data,
		   	   success:function(report){
		   	   	 btn.html(btn_name).prop('disabled', false);
                  if(report.status =='OK'){
                      popNotification(report.message, 'success');
                      $('#ajax_return_values_innerline').html(report.contents);
                  }
                  else{
                  	popNotification(report.message, 'error');
                  }
		   	   },
		   	   error:function(report){
		   	   	      btn.html(btn_name).prop('disabled', false);
                      popNotification(report.responseText, 'error');
		   	   }
		   })

	});






$('body').on('click', '.button_open_new_c_form', function(){
    $('#hidden_add_new_currency_form').toggleClass('display_none');
});

$('body').on('click', '.toggledefaultcurrency', function(){
    let target = $(this).closest('td');
    let value = $(this).data('value');
    let id_currency = $(this).data('currency_id');

   $.post(ajaxurl, {'value':value, 'typeof':'Isdefault', 'id_currency':$(this).data('currency_id'), 'action':'ajaxCurrencyEditor'}, function(report){
         if(report =='OK'){
             popNotification(success_trans, 'success');
             if(value ==1){
              target.html('<button type="button"  data-currency_id="'+id_currency+'" data-value="0" class="toggledefaultcurrency btn btn-xs btn-danger">'+no_trans+'</button>');
             }
             else{
            target.html('<button type="button" data-currency_id="'+id_currency+'" data-value="1" class="toggledefaultcurrency btn btn-xs btn-success">'+yes_trans+'</button>');
             }
         }
         else{
          popNotification(report, 'error');
         }
   });

});

let success_trans = $('#success_trans').html();
let yes_trans = $('#yes_trans').html();
let no_trans = $('#no_trans').html();

$('body').on('keyup', '.currency_rate_value', function(){
   $.post(ajaxurl, {'value':$(this).val(), 'typeof':'Rate', 'id_currency':$(this).data('currency_id'), 'action':'ajaxCurrencyEditor'}, function(report){
         if(report =='OK'){
             popNotification(success_trans, 'success');
         }
         else{
          popNotification(report, 'error');
         }
   });

});


$('body').on('submit', '#add_new_currency_form', function(ev){
    ev.preventDefault();
    $.ajax({
         url:ajaxurl,
         type:'post',
         data:$(this).serialize()+'&action=ajaxCurrencyEditor&typeof=newCurrency',
         dataType:'text',
         success:function(report){
           if(report =='OK'){
             popNotification(success_trans, 'success');
             setTimeout(function(){
              window.location.reload();
             }, 2000);
         }
         else{
          popNotification(report, 'error');
         }

         },
         error:function(report){
          popNotification(report.responseText, 'error');
         }
    })

});



$('body').on('click', '.go_to_page_by_click', function(ev){
	    ev.preventDefault();
	     window.location = $(this).prop('href');

});


$('body').find('.aph_account_menu_item').addClass('display_none');
$('body').find('.over_view_box').removeClass('display_none');

$('body').on('click', '.nav-link', function(){
	let thelink = $(this).data('link');
	$('.nav-link').removeClass('active');
	$(this).addClass('active');

   $('body').find('.aph_account_menu_item').addClass('display_none');
   $('body').find('.'+thelink).removeClass('display_none');
});



// CUSTOMER ADMIN PAGE 

$('body').on('click', '#save_customer_new_address', function(ev){
	  ev.preventDefault();

	  let formaddress = $('#aph_modal_add_address_form').serialize()+'&action=manageHostingCustomer&request_token=APOCREOZIGNXFPVEPCOLSCYHPIXCPCPCKRCDPKDXKXVAOWKBXKUSRQFKZSABYSFY';
         console.log(formaddress);
         let btn = $(this);
         let btn_name = btn.html();
         btn.html('Loading.......');
	  $.ajax({
	  	 url:ajaxurl,
	  	 data:formaddress,
	  	 dataType:'json',
	  	 type:'post',
	  	 success:function(report){
	  	 	btn.html(btn_name);
	  	 	if(report.status=='OK'){
	  	 		popNotification(report.message, 'success','Close');
	  	 		window.location.reload();
	  	 	}
	  	 	else{
	  	 		popNotification(report.message, 'error', 'Close');
	  	 	}

	  	 },
	  	 error:function(report){
	  	 	btn.html(btn_name);
                 popNotification(report.responseText, 'error', 'OK');
	  	 }

	  });

});





$('body').on('click', '.delete_object_action_call', function(ev){
	  ev.preventDefault();
	   let rowline = $(this).parents('tr');
	   let reqcontent = {object:$(this).data('object'), id: $(this).data('object_id'), 'action':'manageHostingCustomer', 'request_token':'APYEWTKZCAPESLRBLICIRSFZDUHQVZSSVQPZRKAAPHCORESJSKMDFIDZJNSPGWGV'};

	  $.ajax({
	  	 url:ajaxurl,
	  	 dataType:'json',
	  	 data:reqcontent,
	  	 type:'post',
	  	 success:function(report){
	  	 	if(report.status=='OK'){
	  	 		popNotification(report.message, 'success', 'OK');
	  	 		rowline.remove();
	  	
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


$('body').on('click', '#aph_save_update_customer_details', function(ev){
	                ev.preventDefault();
      
       let customerdata = $('#aph_save_customer_details_form').serialize()+'&action=manageHostingCustomer&request_token=APPMHNOQAORYYVRTWZVRIJLVYPSCAWLJYUEYOVXKBEUJJRBUVERQHGLNDIEEESWS';
      	$.ajax({
      		 url:ajaxurl,
      		 data:customerdata,
      		 dataType:'json',
      		 type:'post',
      		 success:function(report){

      		 	if(report.status=='OK'){
      		 		popNotification(report.message, 'success', 'OK');
      		 	}
      		 	else{
      		 		popNotification(report.message, 'error', 'Close');
      		 	}

      		 },
      		 error:function(report){
                    popNotification(report.responseText, 'error', 'Close');
      		 }
      	})
      
});


$('body').on('submit', '#ap_modal_create_customer_form', function(ev){
	                ev.preventDefault();
      
       let customerdata = $('#ap_modal_create_customer_form').serialize()+'&action=manageHostingCustomers&request_token=APSIUOGNCYSRHUARXNRRHIACQUMMBKKRTZOACXEFBPCHWJITWYJTFJOVIQTLKGGE';
      	$.ajax({
      		 url:ajaxurl,
      		 data:customerdata,
      		 dataType:'json',
      		 type:'post',
      		 success:function(report){

      		 	if(report.status=='OK'){
      		 		popNotification(report.message, 'success', 'OK');
      		 	}
      		 	else{
      		 		popNotification(report.message, 'error', 'Close');
      		 	}

      		 },
      		 error:function(report){
                    popNotification(report.responseText, 'error', 'Close');
      		 }
      	})
      
});





$('body').on('click', '.delete_object_row', function(ev){
	  ev.preventDefault();
	  let element = $(this);
	  doObjectDeletion(element);
});

$('body').on('change', '.content_lang_selector', function(){
    let c_lang_id = $(this).val();
$('body').find('.each_language_container').addClass('display_none');

$('body').find('.current_lanugage_box_'+c_lang_id).removeClass('display_none');
});


$('body').on('change', '.content_lang_edit_selector', function(){
    let c_lang_id = $(this).val();
$('body').find('.each_language_editor_container').addClass('display_none');

$('body').find('.current_lanugage_editor_box_'+c_lang_id).removeClass('display_none');
});




$('body').on('click', '#rattachments_select', function(){
      $('#rattachment_file').trigger('click');
});

$("body").on('change', '#rattachment_file', function() {
  readURL(this, 'holding_rattachment_img');
});

$('body').on('click', '#start_attachment_process', function(){
      $('#support_attachment').trigger('click');
});

$("body").on('change', '#support_attachment', function() {
  readURL(this, 'holding_attachment_img');
});


$('body').on('click', '.reply_scroll_btn', function(ev){
	  ev.preventDefault();
	  scrollToThisDiv();

});


$('body').on('change', '#send_to', function(ev){
	  if($(this).val() =='Emails'){
	  	 $('.show_specific_email_addresses').removeClass('display_none');
	  }
	  else{
	  	 $('.show_specific_email_addresses').addClass('display_none');
	  }

});


$('body').on('click', '.generate_new_password', function(ev){
	               ev.preventDefault();
         $.ajax({
         	 url:'/generate/password',
         	 type:'get',
         	 dataType:'json',
         	 success:function(report){
         	 	  if(report.status =='OK'){
                    $('#confirm_new_password').val(report.contents);
                    $('#new_password').val(report.contents);
                    popNotification(report.message, 'success');
                  
         	 	  }
         	 	  else{
         	 	  	 popNotification(report.message, 'error');
         	 	  }
              
         	 },
         	 error:function(report){
                    popNotification(report.message, 'error');
         	 }


         });
});


$('body').on('click', '#uploadable_img_trigger', function(ev){
	         ev.preventDefault();
	         $('#the_file_input_field').trigger('click');

});

$('body').on('change', '#the_file_input_field', function(){
         readURL(this, 'hidden_image_keeper');
});


$('body').on('click', '#delete_account_now', function(){
	  
     $('#deletion_form_account_out').toggleClass('display_none');
});

$('body').on('change', '.change_language_selector', function(ev){
         ev.preventDefault();
         $('#trans_language_changer_form').submit();
});


$('body').on('click', '.copytheinput_above', function(){
    console.log('starting copy process now');
    let cbtni = $(this);
    let sTextC = $(this).parent().find('.copy_input_text_content_class');
  sTextC.select();
  // sTextC.setSelectionRange(0, 99999); 
  document.execCommand("copy");
  $(cbtni).html('Copied');
  setTimeout(function(){
   $(cbtni).html('Copy Link');
  }, 2000);


});


$('body').on('click', '.note-btn', function(ev){
	   //ev.preventDefault();

      let btn_ul = $(this).parents('.note-btn-group').find('.note-dropdown-menu');
           btn_ul.css('display','inline-block');

});

$('body').on('click', '.note-dropdown-menu', function(ev){
	    $(this).css('display','none');
});

$('body').on('click', '.note-palette', function(ev){
	    $('.note-dropdown-menu').css('display','none');
});

$('body').on('click', '.note-editable', function(ev){
	    $('.note-dropdown-menu').css('display','none');
});


$('body').on('click', '#submit_all_translated', function(ev){
	               ev.preventDefault();

	     $('body').find('#tableTranslateLangs_filter').find('input[type="search"]').val('');
	     $('body').find('#tableTranslateLangs_filter').find('input[type="search"]').trigger('keyup');

        let formcontent = $('#cardium_translateform_fields_form').serialize();

        $.ajax({
        	 url:'admin/translations/save',
        	 type:'post',
        	 data: formcontent,
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




})(jQuery); //ready



