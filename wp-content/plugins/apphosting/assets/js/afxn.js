
const showErrorDiv = (e)=>{return '<div class="alert-tag red-alert">'+e+'</div>'};
const all_place_spin = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> &nbsp;';
const singleErrorDiv = (e)=>{return '<div class="alert-tag red-alert">'+e+'</div>'};

const showSuccessDiv = (e)=>{return '<div class="alert-tag">'+e+'</div>'};

const tiny_spin_btn = '<i class="fa-solid fa-spinner fa-2xl"></i>';


const singleWarningDiv = (e)=>{return '<div class="alert-tag yellow-alert">'+e+'</div>'};
const progress_place_spin = (e)=>{return ' &nbsp; '+e+' &nbsp; <i class="fa fa-spinner fa-spin"></i><span class="sr-only">Loading...</span>'};
const all_place_spin_big = '<div class="loader_spinner_big">... &nbsp; <i class="fa fa-spinner fa-spin fa-5x"></i><span class="sr-only">Loading...</span> <div>';

function showError(message ='')
{
     $('.ajax_report_div_holder').html(showErrorDiv(message));  
}

function showSuccess(message ='')
{
     $('.ajax_report_div_holder').html(showSuccessDiv(message));  
}


function makeEditorText()
{
	  $('.textarea_note').summernote({
        placeholder: '',
        tabsize: 2,
        height: 250
      });
}





function popNotification(itext, type='error', btn_text='OK'){
	Swal.fire({
                        text: itext,
                        icon: type,
                        buttonsStyling: false,
                        confirmButtonText: btn_text,
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
}


function doObjectDeletion(element)
{
    Swal.fire({
  title: 'Are you sure you want to delete '+element.data('object'),
  showDenyButton: true,
  confirmButtonText: 'Yes',
  denyButtonText: `No`,
}).then((result) => {
  if (result.isConfirmed) {
       ajaxDeleteObject(element);
  } else if (result.isDenied) {
    
  }
});

}

function ajaxDeleteObject(element)
{
      let tr = element.parents('tr');
      contentdata = {object:element.data('object'),action:'internalActions',request_token:'APSHXFLDHIRKJAOFVQRLUKEWQTURTBKJAQCFPNJLQOUTDGVIXDMZGGFBVNSBNXLH', id:element.data('id_object')};
        $.ajax({
         url:frontAjax,
         data: contentdata,
         dataType:'json',
         type:'post',
         success:function(report){
            if(report.status=='OK'){
                tr.remove();
                popNotification(report.message, 'success', 'OK');
            }
            else{
                popNotification(report.message, 'error', 'Close');
            }

         },
         error:function(report){
                 popNotification(report.responseText, 'error', 'OK');
         }

      });
}



function ajaxObjectViewer(element)
{
      let tr = element.parents('tr');
      contentdata = {object:element.data('object'),viewtype:element.data('viewtype'),action:'internalActions',request_token:'APNHUJQFGAANFTNNAZCXTOIBJNPNLOBQXCSCQUMRBSJZFGGPOCLRZLIERFRZVSQF', id:element.data('id_object')};
        $.ajax({
         url:frontAjax,
         data: contentdata,
         dataType:'json',
         type:'post',
         success:function(report){
            if(report.status=='OK'){
                $('.ap_blank_modal_body_form').html(report.contents);
                $('#ap_blank_modal_general_purpose').modal('show');
                //popNotification(report.message, 'success', 'OK');
            }
            else{
                popNotification(report.message, 'error', 'Close');
            }

         },
         error:function(report){
                 popNotification(report.responseText, 'error', 'OK');
         }

      });
}
function doItemDelete(element)
{
    Swal.fire({
  title: 'Are you sure you want to delete '+element.data('object'),
  showDenyButton: true,
  confirmButtonText: 'Yes',
  denyButtonText: `No`,
}).then((result) => {
  if (result.isConfirmed) {
       ajaxDeletePlainItem(element);
  } else if (result.isDenied) {
    
  }
});

}

function ajaxDeletePlainItem(element)
{
      let tr = element.parents('tr');
      let named = element.data('object');
      let id = element.data('objectid');
      let frontAjax ='/account/item-delete?item='+named+'&id='+id;
      
        $.ajax({
         url:frontAjax,
         dataType:'json',
         type:'get',
         success:function(report){
            if(report.status=='OK'){
                tr.remove();
                popNotification(report.message, 'success', 'OK');
            }
            else{
                popNotification(report.message, 'error', 'Close');
            }

         },
         error:function(report){
                 popNotification(report.responseText, 'error', 'OK');
         }

      });
}



function readURL(input, img_id) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#'+img_id).attr('src', e.target.result);
      $('#'+img_id).removeClass('display_none');
    }

    reader.readAsDataURL(input.files[0]);
  }
  else{
    $('#'+img_id).addClass('display_none');
  }
}


function playFormInProgress(element, type='Form')
{
    if(type =='Form'){
       element.find('button').find('span:nth-child(1)').addClass('display_none');
       element.find('button').find('span:nth-child(2)').removeClass('indicator-progress');
    }
    else{
    element.find('span:nth-child(1)').addClass('display_none');
    element.find('span:nth-child(2)').removeClass('indicator-progress');
    }
    

}

function putBackSubmit(element, type='Form')
{
    if(type=='Form'){
    element.find('button').find('span:nth-child(1)').removeClass('display_none');
    element.find('button').find('span:nth-child(2)').addClass('indicator-progress');
    }
    else{
    element.find('span:nth-child(1)').removeClass('display_none');
    element.find('span:nth-child(2)').addClass('indicator-progress');
    }
    
}

function scrollToThisDiv(element =$('.message_place'))
{

   $('html, body').animate({

        scrollTop: element.offset().top-60

    }, 2000);

}


 function scrollToPointB()
 {
    $('html, body').animate({
        scrollTop: $("#login_registration_form_content").offset().top
    }, 2000);

 }



 function msgDiv(message, type='Success')
 {
   if(type =='Success'){
    return `<div class="alert alert-success" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>${message}</div>`;

   }
   else if(type =='Error'){
    return `<div class="alert alert-danger" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>${message}</div>`;
   }

 else if(type =='Info'){
   return `<div class="alert alert-info" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>${message}</div>`;
 }
 else{
   return `<div class="alert alert-info" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>${message}</div>`;
 }
 }


function hasPhone(mytext)
{
var phoneExp = /(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/img
return phoneExp.test(mytext);
}

function hasEmail(mytext)
{
  var emailExp = /(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/;
return emailExp.test(mytext);
}

function getShowPriceDetails()
{
     let domaintype = $('.domain_type_change:checked').val();
     let domain = $('#domain_name').val();
     let hosting = $('input[name="hosting_plan"]:checked').val();

         $.ajax({
         url:frontAjax,
         data:{'domain':domain, 'domaintype':domaintype, 'hosting':hosting,'action':'frontActionsBaseField', 'request_token':'APNXGVIAFAHURTPPMJULOEJZAYERSMZUZDHRPPJILTLVJZZRPMFRJXNGLIHPXJNQ'},
         dataType:'json',
         type:'post',
         success:function(report){
            $('.ap_holding_payment_section_checkout').prop('style', '');
            if(report.status=='OK'){
              $('#display_content_of_checkout_summary').html(report.contents);
            }
            else{
                popNotification(report.message, 'error', 'Close');
            }

         },
         error:function(report){
                $('.ap_holding_payment_section_checkout').prop('style', '');
                 popNotification(report.responseText, 'error', 'OK');
         }

      });

}
function showFormByDomainType()
{
    let domaintype = $('.domain_type_change:checked').val();
    console.log(domaintype);
    let hasaddress = $('#user_has_address').val();
    console.log(hasaddress);
    if(domaintype =='Register'){
        $('#domain_new_registration_request_section').removeClass('display_none');
        $('#domain_transfer_details').addClass('display_none');
        $('#only_checkout_address_for_newuser').addClass('display_none');
    }
    else if(domaintype =='Transfer'){
        $('#domain_transfer_details').removeClass('display_none');
        $('#domain_new_registration_request_section').addClass('display_none'); 

        if(hasaddress =="No"){
          $('#only_checkout_address_for_newuser').removeClass('display_none');
        }
        else{
           $('#only_checkout_address_for_newuser').addClass('display_none');
        }
    }
    else if(domaintype =='Existing'){
        $('#domain_transfer_details').addClass('display_none');
        $('#domain_new_registration_request_section').addClass('display_none'); 

        if(hasaddress =="No"){
          $('#only_checkout_address_for_newuser').removeClass('display_none');
        }
        else{
           $('#only_checkout_address_for_newuser').addClass('display_none');
        }
    }
    
}