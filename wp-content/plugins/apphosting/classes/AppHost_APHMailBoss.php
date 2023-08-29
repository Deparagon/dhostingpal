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

require_once ABSPATH.'wp-includes/pluggable.php';
class AppHost_APHMailBoss
{
    public $plugin_name = 'wave-gate';
    public function post($to, $subject, $message, $mainurl, $button_text, $display_name)
    {
        return $this->sendBasic($to, $subject, $message, $mainurl, $button_text, $display_name);
    }



    public function prepareBody($subject, $message, $mainurl, $button_text, $display_name)
    {
        $vars = $this->getVar();
        $vars['[:mainlink:]'] = $mainurl;
        $vars['[:button_one_text:]'] = $button_text;
        $vars['[:subject:]'] = $subject;
        $vars['[:message:]'] = $message;
        $vars['[:display_name:]'] = $display_name;
        return $this->generateTemplate($vars);
    }
    public function sendBasic($to, $subject, $message, $mainurl, $button_text, $display_name)
    {
        require_once ABSPATH.'wp-includes/pluggable.php';

        $body = $this->prepareBody($subject, $message, $mainurl, $button_text, $display_name);
        $headers = array('Content-Type: text/html; charset=UTF-8');
        return \wp_mail($to, $subject, $body, $headers);
    }


    public function getVar()
    {
        return [
          '[:sitename:]'=> get_bloginfo('name'),
          '[:siteurl:]'=>get_bloginfo('url'),
          '[:yeartext:]'=>date('Y'),
          '[:sitelogo:]'=>esc_url(wp_get_attachment_url(get_theme_mod('custom_logo'))),
          '[:imagebanner:]'=>plugins_url().'/'.$this->plugin_name.'/mail/img/bg.jpg',
          '[:faimageurl:]'=>plugins_url().'/'.$this->plugin_name.'/mail/img/',
           '<script>'=>' ', '</script>'=>' '];
    }


    public function generateTemplate($t_vars)
    {
        global $wp_filesystem;
        try {
            $c =$wp_filesystem->get_contents(plugins_url().'/'.$this->plugin_name.'/mail/en.html');
        } catch (Exception $e) {
            return ' Could not load mail template ';
        }
         $t_keys = array_keys($t_vars);
        $t_values = array_values($t_vars);
        $content =  str_replace($t_keys, $t_values, $c);
        return $content;
    }
}
