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

class AppHost_APHCurrency
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
    public $date_add;
    public $date_upd;


    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_currencies';
    }

    public function addCurrency($args)
    {
        global $wpdb;
        $inserted = $wpdb->insert($this->table, $args, array('%d', '%d', '%s', '%s', '%s', '%s', '%s'));
        if ($inserted == 1) {
            return true;
        }
    }


    public static function currencyList()
    {
        return  array(
          array('is_default'=>1, 'rate'=>1.00, 'country_code'=>'US', 'name'=>'United States Dollars', 'description'=>'United States Dollars', 'iso_code'=>'USD', 'sign'=>'$'),

          array('is_default'=>0, 'rate'=>486.00, 'country_code'=>'NG', 'name'=>'Nigerian Naira', 'description'=>'Nigerian Naira', 'iso_code'=>'NGN', 'sign'=>'₦'),

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

    public function updateCurrency($key, $value, $id_wave_currency)
    {
        global $wpdb;
        $updated = $wpdb->update(
            $this->table,
            array($key => $value

                      ),
            array('id_wave_currency' => $id_wave_currency),
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


    public function setDefault($id_wave_currency)
    {
        global $wpdb;
        $updated = $wpdb->update($this->table, array('is_default' => 1,  'active'=>1), array('id_wave_currency' => $id_wave_currency), array('%d', '%d'), array('%d'));
        if ($updated == 1) {
            return true;
        }

        return false;
    }

    public function updateField($id_wave_currency, $field, $value)
    {
        global $wpdb;
        $updated = $wpdb->update($this->table, array($field => $value), array('id_wave_currency' => $id_wave_currency), array('%s'), array('%d'));
        if ($updated == 1) {
            return true;
        }

        return false;
    }

    public function getActiveCurrencies()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE active =%d ORDER BY id_wave_currency ASC ", 1);
        return $wpdb->get_results($sql, OBJECT);
    }




    public function getById($id_wave_currency)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE id_wave_currency = %d", $id_wave_currency);
        $row = $wpdb->get_row($sql, OBJECT);

        return $row;
    }


    public function isoByID($id)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT iso_code FROM $this->table WHERE id_wave_currency = %d ", $id);
        $row = $wpdb->get_row($sql, OBJECT);
        if (is_object($row)) {
            return $row->iso_code;
        }

        return false;
    }


    public function getIdByIso($iso)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT id_wave_currency FROM $this->table WHERE iso_code = %s ", $iso);
        $row = $wpdb->get_row($sql, OBJECT);
        if (is_object($row)) {
            return $row->id_wave_currency;
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
            return $row->id_wave_currency;
        }

        return false;
    }

    public static function currencyByCountryCode($iso)
    {
        return (new self())->currencyByCountryCodeFX($iso);
    }



    public function getBySessionID($sessionid = '')
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE sessionid = %s", $sessionid);
        $row = $wpdb->get_row($sql, OBJECT);

        return $row;
    }

    public function lastestByUser($user_id)
    {
        global $wpdb;

        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE user_id = %d ORDER BY id_wave_currency DESC ", $user_id);
        $result = $wpdb->get_row($sql);
        return $result;
    }


    public function fetchAll()
    {
        global $wpdb;

        $sql = $wpdb->prepare("SELECT id_wave_currency, reference, user_id, display_name, user_email, phone, payment_status, status, total_price, total_mms  FROM $this->table a INNER JOIN ".$wpdb->prefix."users u ON u.ID = a.user_id  WHERE %d ORDER BY id_wave_currency DESC ", 1);
        $result = $wpdb->get_results($sql);
        return $result;
    }



    public function fetchByField($user_id, $field, $value, $lmt = '')
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE user_id = %d AND $field =%s ORDER BY id_wave_currency ASC ".$lmt, $user_id, $value);
        $result = $wpdb->get_results($sql);

        return $result;
    }


    public function fetchByUser($user_id, $lmt = '')
    {
        global $wpdb;

        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE user_id = %d  ORDER BY id_wave_currency ASC ".$lmt, $user_id);
        $result = $wpdb->get_results($sql);

        return $result;
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
        $del = $wpdb->delete($this->table, array('id_wave_currency' => $id), array('%d'));
        if ($del == 1) {
            return true;
        }

        return false;
    }


    public function existRows()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT COUNT(id_wave_currency) FROM $this->table WHERE %d  ", 1);
        $total = $wpdb->get_var($sql);
        if ((int) $total >0) {
            return true;
        }
        return false;
    }




    public function countByUser($user_id)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT COUNT(id_wave_currency) FROM $this->table WHERE user_id = %d  ", $user_id);
        $total = $wpdb->get_var($sql);
        return $total;
    }

    public function countByStatus($user_id, $status)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT COUNT(id_wave_currency) FROM $this->table WHERE user_id = %d AND status =%s  ", $user_id, $status);
        $total = $wpdb->get_var($sql);
        return $total;
    }

    public function countByPayment($user_id, $payment)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT COUNT(id_wave_currency) FROM $this->table WHERE user_id = %d AND payment_status =%s  ", $user_id, $payment);
        $total = $wpdb->get_var($sql);

        return $total;
    }
}
