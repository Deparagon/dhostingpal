// /**
// 			 * DESCRIPTION.
// 			 *
// 			 * Flutterwave Payment Solutions
// 			 *
// 			 *  @author    Kingsley Paragon
// 			 *  @copyright 2021 Kingsley Paragon
// 			 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License ("AFL") v. 3.0
// 			 */




// (function($) {
//   "use strict";


// $('body').on('click', '.toggleactivestate', function(){
//     let target = $(this).closest('td');
//     let value = $(this).data('value');
//     let id_currency = $(this).data('currency_id');

//    $.post(ajaxurl, {'value':value, 'typeof':'Active', 'id_currency':$(this).data('currency_id'), 'action':'ajaxCurrencyEditor'}, function(report){
//          if(report =='OK'){
//              WaveGate_showNotification(success_trans, 'Success');
//              if(value ==1){
//               target.html('<span data-currency_id="'+id_currency+'" data-value="0" class="toggleactivestate red-icon dashicons dashicons-no"></span>');
//              }
//              else{
//             target.html('<span data-currency_id="'+id_currency+'" data-value="1" class="toggleactivestate green-icon dashicons dashicons-saved"></span>');
//              }
//          }
//          else{
//           WaveGate_showNotification(report, 'Error');
//          }
//    });

// });


// $('body').on('click', '.each_image_cat_box', function(){
//     $(this).addClass('active_img');
//    $.post(ajaxurl, {'value':$(this).data('bg_img'), 'id_category':$(this).data('id_category'),'typeof':'saveBG', 'action':'ajaxCategoryFunctions'}, function(report){
//          if(report =='OK'){
//              WaveGate_showNotification(success_trans, 'Success');
//          }
//          else{
//           WaveGate_showNotification(report, 'Error');
//          }
//    });

// });







// let rows_is_have = $('#var_counted_rows').val();
// if(rows_is_have ==1){
// $('#mybills_classic_table').DataTable();
// }


// // category page updates
// $('body').on('keyup', '.bill_category_name_update', function(){
//    $.post(ajaxurl, {'value':$(this).val(), 'typeof':'Name', 'id_category':$(this).data('id_category'), 'action':'ajaxCategoryFunctions'}, function(report){
//          if(report =='OK'){
//              WaveGate_showNotification(success_trans, 'Success');
//          }
//          else{
//           WaveGate_showNotification(report, 'Error');
//          }
//    });

// });

// $('body').on('keyup', '.update_billcat_color', function(){
//    let target = $(this).closest('td');
//    let innvalue = $(this).val();
//    $.post(ajaxurl, {'value':innvalue, 'typeof':'Color', 'id_category':$(this).data('id_category'), 'action':'ajaxCategoryFunctions'}, function(report){
//          if(report =='OK'){
//              WaveGate_showNotification(success_trans, 'Success');
//              target.find('span.color-showcase').css('backgroundColor', innvalue);
//          }
//          else{
//           WaveGate_showNotification(report, 'Error');
//          }
//    });

// });

// $('body').on('keyup', '.update_billcat_bg', function(){
//   let target = $(this).closest('td');
//    let innvalue = $(this).val();
//    $.post(ajaxurl, {'value':$(this).val(), 'typeof':'Bg', 'id_category':$(this).data('id_category'), 'action':'ajaxCategoryFunctions'}, function(report){
//          if(report =='OK'){
//              WaveGate_showNotification(success_trans, 'Success');
//              target.find('span.color-showcase').css('backgroundColor', innvalue);
//          }
//          else{
//           WaveGate_showNotification(report, 'Error');
//          }
//    });

// });

// $('body').on('click', '.toggleactivecategory', function(){
//     let target = $(this).closest('td');
//     let value = $(this).data('value');
//     let id_category = $(this).data('id_category');

//    $.post(ajaxurl, {'value':value, 'typeof':'Status', 'id_category':$(this).data('id_category'), 'action':'ajaxCategoryFunctions'}, function(report){
//          if(report =='OK'){
//              WaveGate_showNotification(success_trans, 'Success');
//              if(value ==1){
//               target.html('<span data-id_category="'+id_category+'" data-value="0" class="toggleactivecategory red-icon dashicons dashicons-no"></span>');
//              }
//              else{
//             target.html('<span data-id_category="'+id_category+'" data-value="1" class="toggleactivecategory green-icon dashicons dashicons-saved"></span>');
//              }
//          }
//          else{
//           WaveGate_showNotification(report, 'Error');
//          }
//    });

// });



// $('body').on('keyup', '#search_customer', function(ev){
//      ev.preventDefault();
//     if($(this).val().length >2){
//        $.ajax({
//        type:'post',
//        url:ajaxurl,
//        data:{search_term:$(this).val(), 'request_token':'3A3792CD8D934166B6FCDFA7EA80A0B2', 'action':'ajaxBillManager'},
//        dataType:'json',
//        success:function(report){
//         if(report['status'] =='OK'){
//            $('#customer_container').html(report['contents']);
//         }
//         else{
//             WaveGate_showNotification(report['message'], 'Error');

//         }
           
//        }
//        ,
//        error:function(report){
//           WaveGate_showNotification(report.responseText, 'Error');
//        }

// });

//     }
// });



// $('body').on('click', '.load_button_click_continue', function(){
//          // fetch field;
//    let bill_type = $(this).data('billname');
//    let bill_country = $(this).data('billcountry');
//     WaveGate_scrollToPointB();
//     WaveGate_startBillPayment(bill_type, bill_country);

// });



// $('body').on('change', '#selected_network_name', function(ev){
//     WaveGate_setDataSubscription($(this));
// });

// $('body').on('change', '#selected_biller_name', function(ev){
//        let el = $(this);
//        WaveGate_resetCableList(el);
 
// });

// $('body').on('change', '#internet_sub_biller', function(ev){
//        let el = $(this);
//        WaveGate_setInternetSubscription(el);
 
// });






// $('body').on('change', '#data_network_selector', function(ev){
//        let c_network = $(this).val();
       
//        if(c_network =='All'){
//              $('#selected_network_name').find('option').removeClass('display_none');
//        }
//        else{
//         $('#selected_network_name').find('option').addClass('display_none');
//         $('#selected_network_name').find('option').each(function(a, b){
//             if( $(this).data('biller_code') ==c_network){
//               $(this).removeClass('display_none');
//             }

//         });
//        }
// });



// $('body').on('click', '#proceed_to_purchase_code', function(){
//     $('#form_proceed_to_purchase_event').submit();
// })
// $('body').on('submit', '#form_proceed_to_purchase_event', function(ev){ 
//       let btn_name = $('#proceed_to_purchase_code');
//       btn_name.prop('disabled', true);
//       $('.spinner_process_showcase').removeClass('display_none');
//       ev.preventDefault();
//     let formdata = $(this).serialize()+'&request_token=7C3249B783974BA9B2FBB2DF27DD0F13&action=ajaxBillManager';
//     $.ajax({
//           url:ajaxurl,
//           type:'post',
//           data:formdata,
//           dataType:'json',
//           success:function(report){
//              $('.spinner_process_showcase').addClass('display_none');
//              btn_name.prop('disabled', false);
//             if(report['status'] =='OK'){
//                $('.process_type_selected').html(WaveGate_msgDiv(report['message'], 'Success'));
//                setTimeout(function(){
//                  window.location = report['url'];
//                }, 3000);
              
//             }
//             else{

//                $('.process_type_selected').html(WaveGate_msgDiv(report['message'], 'Error'));
//             }

//           },
//           error:function(report){
//              btn_name.prop('disabled', false);
//              $('.spinner_process_showcase').addClass('display_none');
//            $('.process_type_selected').html(WaveGate_msgDiv(report.responseText, 'Error'));
//           }


//     });
// });

// $('#create_payment_url').on('click', function(ev){
//  ev.preventDefault();
// let cbtn = $(this);
// let btn_name = $(this).html();
// $(this).html('..........').prop('disabled', true);
// $.ajax({
//        type:'post',
//        url:ajaxurl,
//        data:$('#create_digital_pos_wave_payurl').serialize()+'&request_token=114911C6BE8E478782F39D8BDCE2D494&action=ajaxPOSManager',
//        dataType:'json',
//        success:function(report){
//         cbtn.html(btn_name).prop('disabled', false);

//         if(report['status'] =='OK'){
//            WaveGate_showNotification(report['message'], 'Success');
//            $('.show_ajax_request_response').html('<div class="alert alert-success">'+report['message']+'</div>');
//           setTimeout(function(){
//                  window.location = report['adminurl'];
//                }, 3000);  
          
//         }
//         else{
//           $('.show_ajax_request_response').html('<div class="alert alert-danger">'+report['message']+'</div>');
//             WaveGate_showNotification(report['message'], 'Error');
//         }
           
//        }
//        ,
//        error:function(report){
//           WaveGate_showNotification(report.responseText, 'Error');
//           $('.show_ajax_request_response').html('<div class="alert alert-danger">'+report.responseText+'</div>');
//           cbtn.html(btn_name).prop('disabled', false);


//        }

// });


// });

// $('body').on('click', '.copytheinput_above', function(){
//     console.log('starting copy process now');
//     let cbtni = $(this);
//     let sTextC = $(this).parent().find('.copy_input_text_content_class');
//   sTextC.select();
//   // sTextC.setSelectionRange(0, 99999); 
//   document.execCommand("copy");
//   $(cbtni).html('Copied');
//   setTimeout(function(){
//    $(cbtni).html('Copy Link');
//   }, 2000);


// });

// $('body').on('click', '.proceed_point_approval_request', function(ev){
//     ev.preventDefault();
//     let formdata = {id_wave_point:$(this).data('id_wave_point'), action:'ajaxCustomerRewards'};
//     $.ajax({
//           url:ajaxurl,
//           type:'post',
//           data:formdata,
//           dataType:'json',
//           success:function(report){
//             if(report['status'] =='OK'){
//              $('.response_ajax').html(report['message'], 'Success');
//              setTimeout(function(){
//                 window.location.reload();
//              },2000);
//             }
//             else{
//                $('.response_ajax').html(WaveGate_msgDiv(report['message'], 'Error'));
//             }

//           },
//           error:function(report){
//            $('.response_ajax').html(WaveGate_msgDiv(report.responseText, 'Error'));
//           }


//     });
// });


// //possible fxns
// function WaveGate_showBoxMessage(msg, msgtype ='Alert')
// {
//    if(msgtype =='Error'){
//        return `<div class="alert alert-danger" role="alert">${msg} </div>`;
//    }

//    if(msgtype =='Success'){
//        return `<div class="alert alert-success" role="alert">${msg} </div>`;
//    }

//    if(msgtype =='Info'){
//        return `<div class="alert alert-info" role="alert">${msg} </div>`;
//    }

//    if(msgtype =='Alert'){
//        return msg;
//    }
// }


//  function WaveGate_scrollToPointB()
//  {
//     $('html, body').animate({
//         scrollTop: $("#form_proceed_to_purchase_event").offset().top
//     }, 2000);

//  }


//  function WaveGate_resetCableList(element)
//  {
//      let html_index = element.find('option')[element.prop('selectedIndex')];
//       let name = $(html_index).closest('option').data('name');
//       let money =  $(html_index).closest('option').data('money');
//       $('#amount_of_subscription').val(money);
//       if(name =='DSTV Payment' || name =='DSTV Box Office bill'){
//        $('#amount_of_subscription').parent().removeClass('display_none');
//       }
//       else{
//         $('#amount_of_subscription').parent().addClass('display_none');
//       }
//  }


//  function WaveGate_setInternetSubscription(element)
//  {
//      let html_index = element.find('option')[element.prop('selectedIndex')];
//       let money =  $(html_index).closest('option').data('money');
//       $('#internet_sub_amount').val(money);

//  }

//  function WaveGate_setDataSubscription(element)
//  {
      
//      let html_index = element.find('option')[element.prop('selectedIndex')];
//       let money =  $(html_index).closest('option').data('money');
//       $('#total_data_amount').val(money);

//  }

//  function WaveGate_resetCableList(element)
//  {
//      let html_index = element.find('option')[element.prop('selectedIndex')];
//       let name = $(html_index).closest('option').data('name');
//       let money =  $(html_index).closest('option').data('money');
//       $('#amount_of_subscription').val(money);
//       if(name =='DSTV Payment' || name =='DSTV Box Office bill'){
//        $('#amount_of_subscription').parent().removeClass('display_none');
//       }
//       else{
//         $('#amount_of_subscription').parent().addClass('display_none');
//       }
//  }





//   function WaveGate_startBillPayment(bill_type, country)
//  {
//    $('.spinner_process_showcase').removeClass('display_none');
//    $.ajax({
//        url:ajaxurl,
//        type:'post',
//        data:{'bill_type':bill_type, bill_country:country, 'request_token':'30E7F01CFFE84FA59B8DB671028D80E1', 'action':'ajaxBillManager'},
//        dataType:'json',
//        success:function(report){
//         $('.spinner_process_showcase').addClass('display_none');
//         $('.process_type_selected').html(WaveGate_msgDiv(report['message']));
//         if(report['status'] =='OK'){
//           $('#form_proceed_to_purchase_event').html(report['contents']);
//           if(bill_type.trim() =='cables'){
//             let ele = $('#selected_biller_name');
//              WaveGate_resetCableList(ele);
//           }
//           else if(bill_type =='internet'){
//                let in_ele = $('#internet_sub_biller');
//                 WaveGate_setInternetSubscription(in_ele);
//           }
//         }
//         else{
//            $('.process_type_selected').html(WaveGate_msgDiv(report['message'], 'Error'));
//         }

//        },
//        error:function(report){ 
//         $('.spinner_process_showcase').addClass('display_none');
//          $('.process_type_selected').html(WaveGate_msgDiv(report.responseText, 'Error'));
//        }
//    })
//  }


//  function WaveGate_msgDiv(message, type='Success')
//  {
//    if(type =='Success'){
//     return `<div class="alert alert-success" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//   <span aria-hidden="true">&times;</span>
// </button>${message}</div>`;

//    }
//    else if(type =='Error'){
//     return `<div class="alert alert-danger" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//   <span aria-hidden="true">&times;</span>
// </button>${message}</div>`;
//    }

//  else if(type =='Info'){
//    return `<div class="alert alert-info" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//   <span aria-hidden="true">&times;</span>
// </button>${message}</div>`;
//  }
//  else{
//    return `<div class="alert alert-info" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//   <span aria-hidden="true">&times;</span>
// </button>${message}</div>`;
//  }
//  }

// function WaveGate_showNotification( msgm, msgtype='Alert')
// {     
//       let m = WaveGate_showBoxMessage(msgm, msgtype);
//        $('.right_side_alert_message').show();
//        $('.right_side_alert_message').html(m);
//        $('.right_side_alert_message').fadeOut(6000, function(){

//        });

      
// }


// })(jQuery); //ready





