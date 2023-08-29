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

class AppHost_APHActivation
{
    public static function run()
    {
        self::createRequiredTables();
        // self::createLivePages();
        self::prefillData();


        return true;
    }


    public static function createRequiredTables()
    {
        global $wpdb;
        global $wp_filesystem;
        require_once ABSPATH.'wp-admin/includes/upgrade.php';

        $sql = $wp_filesystem->get_contents(plugin_dir_path(dirname(__FILE__)).'install/install.sql');
        $sql_content = str_replace(['PREFIX_'], [$wpdb->prefix], $sql);
        $sqls = explode(';', $sql_content);
        if (count($sqls)>0) {
            foreach ($sqls as $sq) {
                dbDelta($sq);
            }
        }

        return true;
    }


    public static function upgradeTableTwo()
    {
        $v =  (int) get_option('APP_HOST_DB_UP_VERSION');
        if ($v ==2) {
            return true;
        }
        global $wpdb;
        global $wp_filesystem;
        require_once ABSPATH.'wp-admin/includes/upgrade.php';

        $sql = $wp_filesystem->get_contents(plugin_dir_path(dirname(__FILE__)).'install/upgrade_1_2.sql');
        $sql_content = str_replace(['PREFIX_'], [$wpdb->prefix], $sql);
        $sqls = explode(';', $sql_content);
        if (count($sqls)>0) {
            foreach ($sqls as $sq) {
                if ($sq !='') {
                    $wpdb->query($sq);
                }
            }
        }
        update_option('APP_HOST_DB_UP_VERSION', 2);
        return true;
    }


    public static function prefillData()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHCurrency.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHDomainPrice.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHCountry.php';
        (new APHCurrency())->installVars();
        (new APHDomainPrice())->installDomainPrices();
        (new APHCountry())->installCountries();

        return true;
    }


    public static function createAnonUser()
    {
        $userdata = array(
           'user_login' => 'Anonymous'.rand(rand(60, 1000), 2000),
           'user_email' => 'client'.rand(1, 200).'@anonymousWavebillPayment.com',
           'user_pass' => 'anonymous'.rand(20, 1000),
           'last_name'=>'Doe',
           'first_name'=>'John',
           'description'=>'Checkout as anonymous'
           );

        $user_id = wp_insert_user($userdata);
        if (is_int($user_id)) {
            update_option('wg_theAnonymousJohn', $user_id);
            return true;
        }
        return false;
    }


    public static function createLivePages()
    {
        $livepages = array('wavepaybills', 'wavemybills','wavemyrewards', 'wavemessages');

        foreach ($livepages as $page) {
            switch ($page) {
                case 'wavepaybills':
                    $pagetitle = esc_html__('Pay Bills', 'wave-gate');
                    break;

                case 'wavemybills':
                    $pagetitle = esc_html__('My Bills', 'wave-gate');
                    break;

                case 'wavemyrewards':
                    $pagetitle = esc_html__('My Rewards', 'wave-gate');
                    break;

                case 'wavemessages':
                    $pagetitle = esc_html__('Notifications', 'wave-gate');
                    break;

                default:
                    $pagetitle = $page.' page';
                    break;
            }
            if (!get_option('wg_'.$page)) {
                $pagecreator = array(
                'post_title' => $pagetitle,
                'post_content' => '['.$page.']',
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_author' => get_current_user_id(),
                'post_date' => date('Y-m-d H:i:s'),
                );
                $pageid = wp_insert_post($pagecreator);
                update_option('wg_'.$page, $pageid);
            }
        }
    }
}
