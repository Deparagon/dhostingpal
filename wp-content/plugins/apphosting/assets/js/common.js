

(function($) {
  "use strict";

    
$('.languageboxchange').on('click', function(ev){
          ev.preventDefault()
   $.get('/set/lang', {'locale':$(this).data('locale'),'lang_id':$(this).data('lang_id')}, function(report){
    window.location = window.location.href
   });
});


$('body').on('click', '.go_to_page_by_click', function(ev){
            ev.preventDefault();
            console.log( $(this).data('href'));
             window.location = $(this).data('href');
});

$('body').on('click', '.load_page_onlick_box', function(ev){
        ev.preventDefault();
         window.location = $(this).data('pagelink');

});


$('body').on('click', '.close_alert', function(){
         $(this).parents('.alert').remove();
});


$('body').on('click', '.each_box_of_filter', function(ev){
           if($(this).hasClass('selected_filter')){
                   $(this).removeClass('selected_filter').find('input').prop('checked', false);

           }
           else{
                $(this).addClass('selected_filter').find('input').prop('checked', true);
           }

});


$('body').on('click', '.rating-label', function(ev){
       $(this).find('input').prop('checked', true);
});

//action_dropdown_submenu
$('body').on('click', '.btn_show_action_sub_menu', function(ev){
        $(this).parents('td').find('.action_dropdown_submenu').toggle();

});

$('body').on('click', '.date-i-span-cal', function(){
    $(this).parents('.the-date-i-input').find('input').trigger('click');
});




})(jQuery); //ready