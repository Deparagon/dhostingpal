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
require_once ABSPATH . 'wp-admin/includes/file.php';
class AppHost_APHBaseField
{
    public $acro ='AppHost_';
    public $name;
    public $version;
    public function __construct()
    {
        $this->coreAction();
        $this->adminPages();
        $this->frontPages();
        $this->shortcode();
        $this->widget();
    }


    public function getVersion()
    {
        return $this->version;
    }

    public function directoryServer($directory, $filetype = 'php', $location = 'admin')
    {
        global $wp_filesystem;
        $phps = array();
        foreach (new DirectoryIterator($directory) as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }
            if ($fileInfo->getExtension() != $filetype) {
                continue;
            }

            $file_key = str_replace('.', '_', $fileInfo->getBasename());

            if ($filetype =='js') {
                $loadfirst = array('jquery');

                if ($file_key =='wwwadmin_js') {
                    $loadfirst = array('jquery', 'scripts_bundle_js','plugins_bundle_js','widgets_bundle_js','back_js');
                }
                wp_enqueue_script($file_key, $location.$fileInfo->getFilename(), $loadfirst, '', true);
            } elseif ($filetype =='css') {
                wp_enqueue_style($file_key, $location.$fileInfo->getFilename(), array(), $this->getVersion(), 'All');
            } elseif ($filetype =='php') {
                $phps[] =$fileInfo->getPathname();
            } elseif ($filetype =='widget') {
                require_once $fileInfo->getPathname();
                register_widget($fileInfo->getBasename());
            }
        }

        if (count($phps) > 0) {
            asort($phps);
            foreach ($phps as $php) {
                require_once $php;
            }
        }
    }

    public function adminScripts()
    {
        global $wp_filesystem;

        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'assets/js/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'assets/js/', 'js', plugins_url().'/'.$this->name.'/assets/js/');
        }
        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'admin/js/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'admin/js/', 'js', plugins_url().'/'.$this->name.'/admin/js/');
        }

        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'assets/css/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'assets/css/', 'css', plugins_url().'/'.$this->name.'/assets/css/');
        }
        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'admin/css/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'admin/css/', 'css', plugins_url().'/'.$this->name.'/admin/css/');
        }
    }



    public function adminPages()
    {
        global $wp_filesystem;
        $page = '';
        if (isset($_GET) && isset($_GET['page'])) {
            $page = esc_html($_GET['page']);
        }
        if (in_array($page, ['apphosting_settings', 'app_hostplans', 'app_hostcurrencies', 'app_customer_orders', 'app_each_order', 'app_customer_domains', 'app_customer_contacts', 'app_customers', 'app_customer', 'app_catch_all'])) {
            add_action('admin_enqueue_scripts', array($this, 'adminScripts'));
        }


        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'admin/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'admin/', 'php');
        }
    }


    public function coreAction()
    {
        global $wp_filesystem;
        WP_Filesystem();
        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'core/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'core/', 'php');
        }
    }


    public function frontScripts()
    {
        global $wp_filesystem;
        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'assets/js/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'assets/js/', 'js', plugins_url().'/'.$this->name.'/assets/js/');
        }
        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'front/js/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'front/js/', 'js', plugins_url().'/'.$this->name.'/front/js/');
        }

        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'assets/css/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'assets/css/', 'css', plugins_url().'/'.$this->name.'/assets/css/');
        }
        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'front/css/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'front/css/', 'css', plugins_url().'/'.$this->name.'/front/css/');
        }
    }


    public function frontPages()
    {
        global $wp_filesystem;
        $page_line ='';
        if (isset($_SERVER['REQUEST_URI'])) {
            $page_line = $_SERVER['REQUEST_URI'];
        }

        if (strpos($page_line, 'login') !==false  ||  strpos($page_line, 'get-started') !==false || strpos($page_line, 'my-domains') !==false || strpos($page_line, 'my-addresses') !==false || strpos($page_line, 'my-addresses') !==false || strpos($page_line, 'my-orders') !==false || strpos($page_line, 'my-profile') !==false || strpos($page_line, 'support') !==false || strpos($page_line, 'order-detail') !==false || strpos($page_line, 'sign-up') !==false || strpos($page_line, 'my-account') !==false || strpos($page_line, 'register-domain') !==false || strpos($page_line, 'replies') !==false || strpos($page_line, 'contact-us') !==false) {
            add_action('wp_enqueue_scripts', array($this, 'frontScripts'));
        }

        //add_action('wp_enqueue_scripts', array($this, 'frontScripts'));

        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'front/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'front/', 'php');
        }
    }



    public function shortcode()
    {
        global $wp_filesystem;
        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'shortcode/')) {
            require_once plugin_dir_path(dirname(__FILE__)).'shortcode/APHShortcode.php';
        }
    }

    public function widget()
    {
        add_action('widgets_init', array($this, 'widgetClass'));
    }



    public function widgetClass()
    {
        global $wp_filesystem;

        if ($wp_filesystem->is_dir(plugin_dir_path(dirname(__FILE__)).'widget/')) {
            $this->directoryServer(plugin_dir_path(dirname(__FILE__)).'widget/', 'widget');
        }
    }
}
