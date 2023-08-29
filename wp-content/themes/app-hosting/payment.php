<?php
/**
 * Template Name:  My Payment
 * Description: The app hosting payment.
 *
 */

$authuser = wp_get_current_user();
if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0):
    get_header();
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHPlan.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHCountry.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHAddress.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHDomain.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHDomainPrice.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHOrder.php';

    require_once(dirname(__FILE__).'/after_header.php');
    $ins_order = new APHOrder();
    $ins_domain = new APHDomain();
    ?>

   
<div class="others">

</div>

	



<?php
            require_once(dirname(__FILE__).'/before_footer.php');

    get_footer();

else:

    wp_redirect(get_page_link(13));
    exit;

endif;

?>