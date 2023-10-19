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
require_once 'APHDomain.php';
class APHDomainPrice extends APHModel
{
    public $id_price;
    public $tld;
    public $registration;
    public $renewal;
    public $transfer;
    public $restore;
    public $active;
    public $deleted;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_domainprices';
    }


    public function existCheckField()
    {
        return 'tld';
    }

    public function primaryKey()
    {
        return 'id_price';
    }




    public function requiredFields()
    {
        return array('tld', 'registration', 'restore', 'renewal', 'transfer');
    }


    public function definitions()
    {
        return array(
                'id_price'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'tld'=>array('type'=>'STRING', 'validate'=>'isString'),
                'registration'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'renewal'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'transfer'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'restore'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'active'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'deleted'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }



    public static function domainPrices()
    {
        return APHDomain::domainPrices();
    }


    public function installDomainPrices()
    {
        $prices = self::domainPrices();
        $types = array('registration', 'renewal', 'transfer', 'restore');
        if (count($prices) >0) {
            foreach ($prices as $c) {
                $names = explode(' ', $c['name']);
                $tld = $names[0];
                $key = trim($names[1]);

                if (!in_array($key, $types)) {
                    continue;
                }

                $ext = array('tld'=>$tld, $key=> APHTools::sellPrice((float) $c['price']), 'created_at'=>date('Y-m-d'));
                $this->filled =  $ext;
                $this->datatypes = array('%s', '%f');
                $this->saveField();
            }
        }
    }


    public function getRegistrationPrice($domain)
    {
        global $wpdb;
        preg_match('/\.([a-z]+(\.[a-z]+)*)$/', $domain, $matches);
        $tld = $matches[1];

        $sql = $wpdb->prepare("SELECT registration FROM $this->table WHERE active =%d  AND tld =%s", 1, $tld);
        return $wpdb->get_var($sql);
    }

 public function getFullPrice($domain)
 {
     global $wpdb;
     preg_match('/\.([a-z]+(\.[a-z]+)*)$/', $domain, $matches);
     $tld = $matches[1];

     $tld = '.'.$tld;
     $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE active =%d  AND tld =%s", 1, $tld);
     return $wpdb->get_row($sql, OBJECT);
 }


   public function getDomainNamePrice($domain, $price_type='registration')
   {
       global $wpdb;
       preg_match('/\.([a-z]+(\.[a-z]+)*)$/', $domain, $matches);
       $tld = $matches[1];
       $sql = $wpdb->prepare("SELECT $price_type FROM $this->table WHERE active =%d  AND tld =%s", 1, $tld);
       return $wpdb->get_var($sql);
   }

    public function getTldPrice($tld)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE active =%d  AND tld =%s", 1, $tld);
        return $wpdb->get_row($sql, OBJECT);
    }


    public function getThePrice($tld, $price_type='registration')
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT $price_type FROM $this->table WHERE active =%d  AND tld =%s", 1, $tld);
        return $wpdb->get_var($sql);
    }



    public function getAllCountry()
    {
        return $this->getAll();
    }
}
