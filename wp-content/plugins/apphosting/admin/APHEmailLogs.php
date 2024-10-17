<?php
/**
 * DESCRIPTION.
 *
 *   App Hosting
 *
 *  @author    Paragon Kingsley
 *  @copyright 2023 Paragon Kingsley
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License ("AFL") v. 3.0
 */

if (!defined('ABSPATH')) {
    exit;
}
class APHEmailLogs
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'messageLogMenu'));
    }


        public function messageLogMenu()
        {
            add_submenu_page('apphosting_settings', 'E-mail Message Logs', 'Email Messages', 'manage_options', 'aph_emaillogs', array($this, 'thePage'), 1);
        }

     public function thePage()
     {
         if (file_exists(dirname(__FILE__).'/logs/email_logs.txt')) {
             $contents = file_get_contents(dirname(__FILE__).'/logs/email_logs.txt');
             $alltr = explode("\n\n\n", $contents);

             if (isset($alltr) && is_array($alltr) && count($alltr) >0) {
                 echo '<h1 style="text-align:center; margin-top:20px;"> E-mail Message Logs </h1>';
                 foreach ($alltr as $tr) {
                     if (trim($tr) =='') {
                         continue;
                     }
                     echo '<div style="border:4px solid #000; width:80%; margin-top:10px; margin-bottom:10px; padding:12px;">'.$tr.'

           </div>';
                 }
             }
         }
     }
}




new APHEmailLogs();
