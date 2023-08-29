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


class AppHost_APHMessage
{
    public function displayContent()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHTools.php';
        $alerti = APHTools::getValue('alerti');
        $message = APHTools::getValue('message');
        ?>
         
          <div class="card">
            <div class="card-body">
           <div class="row">
               <div class="col-sm-12">
                    <h2>Payment Status</h2>
                    <?php if (isset($alerti) && (int)$alerti ===1) {
                        echo '<div class="alert alert-error redbar">'.esc_html($message).'</div>';
                    } elseif (isset($alerti)  && (int) $alerti ===0) {
                        echo '<div class="alert alert-success greenbar">'.esc_html($message).'</div>';
                    }
        ?>
               </div>
           </div>
         </div>
       </div>

        <?php
    }
}
