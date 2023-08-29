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
class APHCurrency extends APHModel
{
    public $id_currency;
    public $is_default;
    public $rate;
    public $country_code;
    public $name;
    public $description;
    public $iso_code;
    public $sign;
    public $active;
    public $deleted;
    public $payload;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_currencies';
    }


    public function existCheckField()
    {
        return 'name';
    }

    public function primaryKey()
    {
        return 'id_currency';
    }




    public function requiredFields()
    {
        return array('id_currency', 'is_default', 'rate', 'country_code', 'name', 'iso_code', 'sign', 'active');
    }

    public function definitions()
    {
        return array(
                'id_currency'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'is_default'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'rate'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),

                'country_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'name'=>array('type'=>'STRING', 'validate'=>'isString'),
                'description'=>array('type'=>'STRING', 'validate'=>'isString'),
                'iso_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'sign'=>array('type'=>'STRING', 'validate'=>'isString'),
                'active'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'deleted'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),

                'payload'=>array('type'=>'HTML', 'validate'=>'isString'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }






    public function getAllCurrencies()
    {
        return $this->getAll();
    }

     public function addCurrency($args)
     {
         global $wpdb;
         $inserted = $wpdb->insert($this->table, $args, array('%d', '%f', '%s', '%s', '%s', '%s', '%s'));
         if ($inserted == 1) {
             return true;
         }
     }


    public static function currencyList()
    {
        return  array(
          array('is_default'=>1, 'rate'=>1.00, 'country_code'=>'US', 'name'=>'United States Dollars', 'description'=>'United States Dollars', 'iso_code'=>'USD', 'sign'=>'$'),

          array('is_default'=>0, 'rate'=>860.00, 'country_code'=>'NG', 'name'=>'Nigerian Naira', 'description'=>'Nigerian Naira', 'iso_code'=>'NGN', 'sign'=>'₦'),

          array('is_default'=>0, 'rate'=>108.50, 'country_code'=>'KE', 'name'=>'Kenya Shilling', 'description'=>'Kenya Shilling', 'iso_code'=>'KES', 'sign'=>'KSh'),

          array('is_default'=>0, 'rate'=>5.78, 'country_code'=>'GH', 'name'=>'Ghana Cedis', 'description'=>'Ghana Cedis', 'iso_code'=>'GHS', 'sign'=>'GH₵'),

          array('is_default'=>0, 'rate'=>3603.88, 'country_code'=>'UG', 'name'=>'Uganda Shilling', 'description'=>'Uganda Shilling', 'iso_code'=>'UGX', 'sign'=>'USh'),
         );
    }


    public function installVars()
    {
        if ($this->existRows() ==true) {
            return true;
        }

        $vars = $this->currencyList();
        if (count($vars) >0) {
            foreach ($vars as $v) {
                $this->addCurrency($v);
            }
        }

        return true;
    }

    public function getCurrencies()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE %d", 1);
        $result = $wpdb->get_results($sql, OBJECT);
        return $result;
    }

    public function getDefault()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE is_default = %d", 1);
        $result = $wpdb->get_row($sql, OBJECT);
        return $result;
    }

    public static function getWordCurrencies()
    {
        global $wp_filesystem;
        $currencies = $wp_filesystem->get_contents(plugin_dir_path(dirname(__FILE__)).'install/currencies.json');
        return json_decode($currencies);
    }
    public static function getISos()
    {
        $isos = array();
        $currencies = (new self())->getCurrencies();
        if (count($currencies) >0) {
            foreach ($currencies as $cur) {
                $isos[] = $cur->iso_code;
            }
        }
        return $isos;
    }

    public function updateCurrency($key, $value, $id_currency)
    {
        global $wpdb;
        $updated = $wpdb->update(
            $this->table,
            array($key => $value

                      ),
            array('id_currency' => $id_currency),
            array(),
            array('%d')
        );
        if ($updated == 1) {
            return true;
        }

        return false;
    }

    public function removeDefault()
    {
        global $wpdb;
        $updated = $wpdb->update($this->table, array('is_default' => 0), array('is_default' => 1), array('%d'), array('%d'));
        if ($updated == 1) {
            return true;
        }

        return false;
    }


    public function setDefault($id_currency)
    {
        global $wpdb;
        $updated = $wpdb->update($this->table, array('is_default' => 1,  'active'=>1), array($this->primaryKey() => $id_currency), array('%d', '%d'), array('%d'));
        if ($updated == 1) {
            return true;
        }

        return false;
    }

    public function updateField($id_currency, $field, $value)
    {
        global $wpdb;
        $updated = $wpdb->update($this->table, array($field => $value), array($this->primaryKey() => $id_currency), array('%s'), array('%d'));
        if ($updated == 1) {
            return true;
        }

        return false;
    }

    public function getActiveCurrencies()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE active =%d ORDER BY ".$this->primaryKey()." ASC ", 1);
        return $wpdb->get_results($sql, OBJECT);
    }




    public function getById($id)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE ".$this->primaryKey()." = %d", $id);
        $row = $wpdb->get_row($sql, OBJECT);

        return $row;
    }


    public function isoByID($id)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT iso_code FROM $this->table WHERE ".$this->primaryKey()." = %d ", $id);
        $row = $wpdb->get_row($sql, OBJECT);
        if (is_object($row)) {
            return $row->iso_code;
        }

        return false;
    }

    public function getRateByISO($iso_code)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT rate FROM $this->table WHERE iso_code = %s ", $iso_code);
        return (float) $wpdb->get_var($sql);
    }


    public static function getRate($iso_code)
    {
        return (new self())->getRateByISO($iso_code);
    }




    public function getIdByIso($iso)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT ".$this->primaryKey()." FROM $this->table WHERE iso_code = %s ", $iso);
        $row = $wpdb->get_row($sql, OBJECT);
        if (is_object($row)) {
            return $row->id_currency;
        }

        return 0;
    }



    public static function getIsoByID($id)
    {
        return (new self())->isoByID($id);
    }

    public function currencyByCountryCodeFX($iso)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE iso_code = %s AND active = %d ", $iso, 1);
        $row = $wpdb->get_row($sql, OBJECT);
        if (is_object($row)) {
            return $row->id_currency;
        }

        return false;
    }

    public static function currencyByCountryCode($iso)
    {
        return (new self())->currencyByCountryCodeFX($iso);
    }





    public function dropCurrencies()
    {
        global $wpdb;
        require_once ABSPATH.'wp-admin/includes/upgrade.php';
        dbDelta('TRUNCATE TABLE '.$this->table);
        return true;
    }






    public function deleteMessage($id = '')
    {
        global $wpdb;
        $del = $wpdb->delete($this->table, array( $this->primaryKey() => $id), array('%d'));
        if ($del == 1) {
            return true;
        }

        return false;
    }


    public function existRows()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE %d  ", 1);
        $total = $wpdb->get_var($sql);
        if ((int) $total >0) {
            return true;
        }
        return false;
    }
}
