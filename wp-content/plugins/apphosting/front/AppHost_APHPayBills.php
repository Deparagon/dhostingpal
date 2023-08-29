<?php
/**
 * DESCRIPTION.
 *
 *   app hosting WordPress Plugin for domain hosting pal
 *
 *  @author    Paragon Kingsley
 *  @copyright 2023 Paragon Kingsley
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License ("AFL") v. 3.0
 */

class AppHost_APHPayBills
{
    public function displayContent()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/AppHost_APHCategory.php';
        $bcat = new AppHost_APHCategory();
        $billcats =$bcat->getActiveBills();
        ?>


 <h2 class="bill_payment_top"><?php esc_html_e('Pay all your bills with ease', 'wave-gate'); ?> </h2>
<div class="flexy-boxy-container">
  
        <?php if (isset($billcats) && count($billcats) >0) :
            foreach ($billcats as $bill) : ?>
       <div <?php if (isset($bill->bg_img) && $bill->bg_img !='') : ?> 
            style="background-image: url(<?php echo $bill->bg_img; ?>); background-repeat: no-repeat; background-size:contain; background-position: center;"
            <?php else : ?>
style="background-color:<?php echo esc_html($bill->bg); ?>; color:<?php echo esc_html($bill->color) ;?>"
            <?php endif; ?>
        class="load_button_click_continue each-pay-boxy" data-billcountry=" <?php echo esc_html($bill->country); ?>" data-billname=" <?php echo esc_html($bill->name); ?>"> 

                <?php if (!isset($bill->bg_img) || $bill->bg_img =='') :?>
               <h4 class="top-label" style="color: <?php echo esc_html($bill->color) ;?>">  <?php echo esc_html($bill->description); ?> </h4>
               <p style="color: <?php echo esc_html($bill->color) ;?>"> <?php esc_html_e('Country:', 'wave-gate'); ?>  <?php echo  esc_html($bill->country); ?></p>
                <?php endif; ?>
       </div>
            <?php endforeach;
        endif; ?>
</div>

<!-- start modal -->
 <div class="popmodalbox-overlay display_none"></div>

  <div class="popmodalbox popmodalbox-default-new" id="modal_self_made">
    <div class="popmodalbox-content">
          <div class="popmodalbox-header">
            <a class="popmodalbox-close">X</a>
          </div>
          <div class="popmodalbox-body">
           <div class="process_type_selected"></div>
<div class="preview_form_inform_here"></div>
<form id="form_proceed_to_purchase_event" method="post" action=""></form>
 <div id="login_registration_form_content"></div>
         
          </div>
          <div class="popmodalbox-footer">
            <!-- <a href="javascript:;" class="btn-thanks-close popmodalbox-btn popmodalbox-form-btn">Close</a> -->
          </div>
  </div>
</div>

<!-- end modal -->





  
<div class="spinner_process_showcase display_none">
        <img src="<?php echo plugin_dir_url(dirname(__FILE__)).'assets/img/spinner.gif'; ?>">
</div>

<div class="shadow_box_total_overlay">
    <p class="main-spinner-all-load"><img src="<?php echo plugin_dir_url(dirname(__FILE__)).'assets/img/spinner.gif'; ?>"></p>
</div>


         <?php
    }
}
