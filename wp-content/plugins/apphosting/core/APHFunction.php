<?php


/**
 *
 */
class APHFunction
{
    public $errors =array();

    public function __construct()
    {
        add_action('after_setup_theme', array($this, 'removeBarAction'));
    }



    public function removeBarAction()
    {
        if (!current_user_can('administrator') && !is_admin()) {
            show_admin_bar(false);
        }
    }
}


new APHFunction();
