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

require_once 'APHModel.php';
class APHCountry extends APHModel
{
    public $id_country;
    public $name;
    public $flag;
    public $code;
    public $iso3;
    public $tld;
    public $capital;
    public $currency_code;
    public $active;
    public $deleted;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_countries';
    }


    public function existCheckField()
    {
        return 'name';
    }

    public function primaryKey()
    {
        return 'id_country';
    }




    public function requiredFields()
    {
        return array('name', 'country_code', 'currency_code',);
    }


    public function definitions()
    {
        return array(
                'id_country'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'name'=>array('type'=>'STRING', 'validate'=>'isString'),
                'flag'=>array('type'=>'STRING', 'validate'=>'isString'),
                'code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'iso3'=>array('type'=>'STRING', 'validate'=>'isString'),
                'numeric_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'calling_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'capital'=>array('type'=>'STRING', 'validate'=>'isString'),
                'currency_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'currency_name'=>array('type'=>'STRING', 'validate'=>'isString'),
                'tld'=>array('type'=>'STRING', 'validate'=>'isString'),
                'active'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'deleted'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }



    public static function getFileCountries()
    {
        global $wp_filesystem;
        $countries = $wp_filesystem->get_contents(plugin_dir_path(dirname(__FILE__)).'install/countries.json');
        return json_decode($countries);
    }


    public function installCountries()
    {
        $countries = self::getFileCountries();

        if (count($countries) >0) {
            foreach ($countries as $c) {
                $this->filled = (array) $c;
                $this->datatypes = array('%s', '%s', '%s','%s','%s','%s','%s','%s','%s',);
                $this->saveField();
            }
        }
    }


   public function codeById($id)
   {
       global $wpdb;
       $sql = $wpdb->prepare("SELECT code FROM $this->table WHERE ".$this->primaryKey()." = %d ", $id);
       return $wpdb->get_var($sql);
   }


   public static function countryCode($id)
   {
       return (new self())->codeById($id);
   }


   public function getActives()
   {
       global $wpdb;
       $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE active =%d ORDER BY ".$this->primaryKey()." ASC ", 1);
       return $wpdb->get_results($sql, OBJECT);
   }


    public function getAllCountry()
    {
        return $this->getAll();
    }
}
