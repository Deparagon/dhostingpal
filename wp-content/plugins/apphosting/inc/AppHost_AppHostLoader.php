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

require_once dirname(__FILE__).'/AppHost_APHBaseField.php';
class AppHost_AppHostLoader extends AppHost_APHBaseField
{
    public function __construct()
    {
        $this->name = 'apphosting';
        $this->version = '1.0';
        $this->acro = 'AH';
        parent::__construct();
    }


    public function widget()
    {
    }

    public function shortcode()
    {
        return  parent::shortcode();
    }
}
