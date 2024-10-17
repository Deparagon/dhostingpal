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
class APHCustomer extends APHModel
{
    public $id_customer;
    public $user_id;
    public $customer_code;
    public $customer_id;
    public $integration;
    public $active;
    public $deleted;
    public $payload;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_customers';
    }


    public function existCheckField()
    {
        return 'user_id';
    }

    public function primaryKey()
    {
        return 'id_customer';
    }




    public function requiredFields()
    {
        return array('user_id', 'customer_code', 'customer_id');
    }

    public function definitions()
    {
        return array(
                'id_customer'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'user_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'customer_code'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'customer_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'country_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'integration'=>array('type'=>'STRING', 'validate'=>'isString'),
                'active'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'deleted'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),

                'payload'=>array('type'=>'HTML', 'validate'=>'isString'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }



   

   public function getAboveThree()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT u.ID, u.user_login, u.display_name, u.user_email FROM ".$wpdb->prefix."users u WHERE u.ID > 299 ORDER BY u.ID DESC LIMIT 1000 ", 1);
        $result = $wpdb->get_results($sql);
        return $result;
    }


    public function getAllCustomers()
    {
        return $this->getAll();
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




    public function getWPUsers()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT u.ID, u.user_login, u.display_name, u.user_email FROM ".$wpdb->prefix."users u ORDER BY u.ID DESC ", 1);
        $result = $wpdb->get_results($sql);
        return $result;
    }


    public function leftCombineThisUser($user_id)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT c.*,  u.ID, u.user_login, u.display_name, u.user_email FROM ".$wpdb->prefix."users u LEFT JOIN ".$this->table." c ON c.user_id = u.ID WHERE u.ID =%d ", $user_id);
        $result = $wpdb->get_row($sql);
        return $result;
    }
}
