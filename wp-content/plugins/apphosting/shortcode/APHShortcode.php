<?php
/**
 * DESCRIPTION.
 *
 *   App hosting WordPress Plugin for domain hosting pal
 *
 *  @author    Paragon Kingsley
 *  @copyright 2023 Paragon Kingsley
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License ("AFL") v. 3.0
 */

if (!defined('ABSPATH')) {
    exit;
}
class APHShortCode
{
    public function __construct()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'front/APHPrivActions.php';
        require_once plugin_dir_path(dirname(__FILE__)).'front/APHNonPriv.php';
        require_once plugin_dir_path(dirname(__FILE__)).'front/APHInternalActions.php';
        add_action('wp_footer', array($this, 'allJSNeededForShortCode'));

        // INSIDE
        add_action('wp_ajax_frontActionsBaseField', function () {
            $requester = new APHPrivActions();
            $requester->frontActionsBaseField();
        });


        // INTERNAL
        add_action('wp_ajax_internalActions', function () {
            $requester = new APHInternalActions();
            $requester->internalActions();
        });


        //OUTSIDE
        add_action('wp_ajax_nopriv_noPrivActionsBaseField', function () {
            $requester = new APHNonPriv();
            $requester->noPrivActionsBaseField();
        });
    }




    public function allJSNeededForShortCode()
    {
        ?>
        <script>  
        var frontAjax = "<?php echo esc_url(admin_url().'admin-ajax.php');
        ?>";
        </script>
        <?php
    }
}


new APHShortCode();
