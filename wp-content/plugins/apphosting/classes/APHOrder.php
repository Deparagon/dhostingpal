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
require_once 'InternetBS.php';

class APHOrder extends APHModel
{
    public $id_order;
    public $user_id;
    public $id_plan;
    public $id_currency;
    public $id_domain;
    public $session_id;
    public $sub_type;
    public $app_domain;
    public $active;
    public $start_date;
    public $end_date;
    public $next_reminder;
    public $last_reminder;
    public $refunded;
    public $payment_reference;
    public $payment_url;
    public $payment_type;
    public $access_code;
    public $paid_amount;
    public $default_total;
    public $recurrent_amount;
    public $order_total;
    public $profit;
    public $transaction_id;
    public $flw_ref;
    public $order_note;
    public $first_6digits;
    public $last_4digits;
    public $issuer;
    public $token;
    public $card_type;
    public $expiry;
    public $status;
    public $status_message;
    public $last_update;
    public $next_update;
    public $update_status;
    public $payload;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_orders';
    }



    public function existCheckField()
    {
        return 'id_order';
    }

    public function primaryKey()
    {
        return 'id_order';
    }




    public function requiredFields()
    {
        return array('user_id', 'id_domain', 'id_currency', 'app_domain');
    }


    public function definitions()
    {
        return array(
                'user_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_plan'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_domain'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_currency'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'session_id'=>array('type'=>'STRING', 'validate'=>'isString'),
                'app_domain'=>array('type'=>'STRING', 'validate'=>'isString'),
                'sub_type'=>array('type'=>'STRING', 'validate'=>'isString'),
                'payment_date'=>array('type'=>'STRING', 'validate'=>'isString'),
                'activation_date'=>array('type'=>'STRING', 'validate'=>'isString'),
                'current_billing_start'=>array('type'=>'STRING', 'validate'=>'isString'),
                'current_billing_end'=>array('type'=>'STRING', 'validate'=>'isString'),
                'next_reminder'=>array('type'=>'STRING', 'validate'=>'isString'),
                'last_reminder'=>array('type'=>'STRING', 'validate'=>'isString'),

                'refunded'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'reference'=>array('type'=>'STRING', 'validate'=>'isString'),
                'flw_reference'=>array('type'=>'STRING', 'validate'=>'isString'),
                'stack_reference'=>array('type'=>'STRING', 'validate'=>'isString'),
                'payment_url'=>array('type'=>'STRING', 'validate'=>'isString'),
                'access_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'default_total'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'recurrent_amount'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'order_total'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'paid_amount'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'profit'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'transaction_id'=>array('type'=>'STRING', 'validate'=>'isString'),
                'signature'=>array('type'=>'STRING', 'validate'=>'isString'),
                'order_note'=>array('type'=>'STRING', 'validate'=>'isString'),
                'payment_type'=>array('type'=>'STRING', 'validate'=>'isString'),
                'first_6digits'=>array('type'=>'STRING', 'validate'=>'isString'),
                'last_4digits'=>array('type'=>'STRING', 'validate'=>'isString'),
                'issuer'=>array('type'=>'HTML', 'validate'=>'isString'),
                'token'=>array('type'=>'STRING', 'validate'=>'isString'),
                'card_type'=>array('type'=>'STRING', 'validate'=>'isString'),
                'expiry'=>array('type'=>'STRING', 'validate'=>'isString'),
                'status'=>array('type'=>'STRING', 'validate'=>'isString'),
                'status_message'=>array('type'=>'STRING', 'validate'=>'isString'),
                'update_status'=>array('type'=>'STRING', 'validate'=>'isString'),
                'payload'=>array('type'=>'STRING', 'validate'=>'isString'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }



    public static function fieldUpdate($id, $field, $value, $t = '%s')
    {
        return (new self())->updateKey($id, $field, $value, $t);
    }


    public function processFirstPaidOrder($id_order)
    {
        $order = $this->getById($id_order);
        if (is_object($order) &&  (int) $order->id_order >0) {
            self::fieldUpdate($id_order, 'activation_date', date('Y-m-d'));
            self::fieldUpdate($id_order, 'current_billing_start', date('Y-m-d'));
            self::fieldUpdate($id_order, 'next_reminder', APHTools::futureDate(' 3 weeks '));
            self::fieldUpdate($id_order, 'last_reminder', date('Y-m-d'));
            self::fieldUpdate($id_order, 'active', 1);
            self::fieldUpdate($id_order, 'current_billing_end', APHTools::futureDate('1 month'));
            self::fieldUpdate($id_order, 'status', 'Completed');

            return true;
        }
    }



        public function processRenewals($id_order)
        {
            $order = $this->getById($id_order);
            if (is_object($order) &&  (int) $order->id_order >0) {
                self::fieldUpdate($id_order, 'current_billing_start', date('Y-m-d'));
                self::fieldUpdate($id_order, 'next_reminder', APHTools::futureDate(' 3 weeks '));
                self::fieldUpdate($id_order, 'last_reminder', date('Y-m-d'));
                self::fieldUpdate($id_order, 'active', 1);

                self::fieldUpdate($id_order, 'current_billing_end', APHTools::futureDate('1 month'));
                self::fieldUpdate($id_order, 'status', 'Completed');

                return true;
            }
        }







    public function getAllOrders()
    {
        return $this->getAll();
    }
}
