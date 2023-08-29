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

class APHInvoice extends APHModel
{
    public $id_invoice;
    public $id_order;
    public $user_id;
    public $id_plan;
    public $id_currency;
    public $id_domain;
    public $active;
    public $billing_start;
    public $billing_end;
    public $refunded;
    public $reference;
    public $payment_url;
    public $payment_type;
    public $access_code;
    public $invoice_amount;
    public $default_amount;
    public $paid_amount;
    public $transaction_id;
    public $first_6digits;
    public $last_4digits;
    public $issuer;
    public $token;
    public $card_type;
    public $expiry;
    public $status;
    public $status_message;
    public $payload;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_invoices';
    }




    public function existCheckField()
    {
        return 'reference';
    }

    public function primaryKey()
    {
        return 'id_invoice';
    }




    public function requiredFields()
    {
        return array('user_id','id_order', 'invoice_amount', 'default_amount', 'status');
    }


    public function definitions()
    {
        return array(
                'invoice_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'user_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_plan'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_domain'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_currency'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'payment_date'=>array('type'=>'STRING', 'validate'=>'isString'),
                'billing_start'=>array('type'=>'STRING', 'validate'=>'isString'),
                'billing_end'=>array('type'=>'STRING', 'validate'=>'isString'),
                'refunded'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'reference'=>array('type'=>'STRING', 'validate'=>'isString'),
                'payment_url'=>array('type'=>'STRING', 'validate'=>'isString'),
                'access_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'payment_type'=>array('type'=>'STRING', 'validate'=>'isString'),
                'default_amount'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'invoice_amount'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'paid_amount'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'transaction_id'=>array('type'=>'STRING', 'validate'=>'isString'),
                'signature'=>array('type'=>'STRING', 'validate'=>'isString'),
                'first_6digits'=>array('type'=>'STRING', 'validate'=>'isString'),
                'last_4digits'=>array('type'=>'STRING', 'validate'=>'isString'),
                'issuer'=>array('type'=>'HTML', 'validate'=>'isString'),
                'token'=>array('type'=>'STRING', 'validate'=>'isString'),
                'card_type'=>array('type'=>'STRING', 'validate'=>'isString'),
                'expiry'=>array('type'=>'STRING', 'validate'=>'isString'),
                'status'=>array('type'=>'STRING', 'validate'=>'isString'),
                'status_message'=>array('type'=>'STRING', 'validate'=>'isString'),
                'payload'=>array('type'=>'STRING', 'validate'=>'isString'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }



    public static function fieldUpdate($id, $field, $value, $t = '%s')
    {
        return (new self())->updateKey($id, $field, $value, $t);
    }


    public function getOrderInvoices($id_order)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE id_order = %d", $id);
        return  $wpdb->get_results($sql);
    }



     public function lastUpaidInvoice($id_order)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE id_order = %d AND status =%s ORDER BY id_invoice DESC ", $id);
         return  $wpdb->get_row($sql);
     }


     public function countStatusByMe($id, $status="Paid")
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE active = %d AND user_id = %d AND status = %s", 1, $id, $status);
         return  $wpdb->get_var($sql);
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
                self::fieldUpdate($id_order, 'next_invoice', APHTools::futureDate(' 3 weeks '));
                self::fieldUpdate($id_order, 'last_invoice', date('Y-m-d'));
                self::fieldUpdate($id_order, 'active', 1);

                self::fieldUpdate($id_order, 'current_billing_end', APHTools::futureDate('1 month'));
                self::fieldUpdate($id_order, 'status', 'Completed');

                return true;
            }
        }




    public function getAllInvoices()
    {
        return $this->getAll();
    }
}
