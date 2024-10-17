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
class APHDeleteBadAccounts
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'messageWasteAccount'));
    }


        public function messageWasteAccount()
        {
            add_submenu_page('apphosting_settings', 'Account Waster', 'Spam Account Waster', 'manage_options', 'aph_wastespam', array($this, 'thePage'), 1);
        }

     public function thePage()
     {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHCustomer.php';
        
        $users_deleted = [];
        $obju = new APHCustomer();
        $users = $obju->getAboveThree();
        if(count($users) >0){
             foreach($users as $u){
                $names = 'Name: '.$u->user_login.' ID: '.$u->ID.' Email: '.$u->user_email;
                wp_delete_user($u->ID);
                $users_deleted[] = $names;
             }
        }

        print_r($users_deleted);
        exit;
         
     }
}




new APHDeleteBadAccounts();
