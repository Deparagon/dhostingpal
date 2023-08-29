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

require_once dirname(__FILE__).'/AppHost_APHCategory.php';
require_once dirname(__FILE__).'/AppHost_APHPayment.php';
require_once dirname(__FILE__).'/AppHost_APHPoint.php';
require_once dirname(__FILE__).'/APHTools.php';
require_once dirname(__FILE__).'/AppHost_APHMailBoss.php';

class AppHost_APHHostingOrder
{
    public $id_hosting_order;
    public $id_plan;
    public $session_id;
    public $sub_type;
    public $id_currency;
    public $user_id;
    public $payment_reference;
    public $active;
    public $start_date;
    public $end_date;
    public $next_reminder;
    public $last_reminder;
    public $reminder;
    public $refunded;
    public $payment_url;
    public $paid_amount;
    public $order_amount;
    public $profit;
    public $transaction_id;
    public $flw_ref;
    public $narration;
    public $payment_type;
    public $account_id;
    public $first_6digits;
    public $last_4digits;
    public $issuer;
    public $country;
    public $token;
    public $card_type;
    public $expiry;

    public $bill_response;
    public $bill_message;
    public $bill_flw_ref;
    public $bill_ref;
    public $bill_extra;
    public $name;
    public $last_update;
    public $next_update;
    public $update_status;
    public $status_message;
    public $next_in_time;


    public $status;
    public $payload;
    public $created_at;
    public $updated_at;


    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'AppHost_APH_orders';
    }


    public function addReference($user_id, $id_currency, $amount, $payment_reference)
    {
        global $wpdb;
        $args = array('id_cart'=>$id_cart, 'id_order'=>$id_order, 'id_currency'=>$id_currency, 'user_id'=>$user_id, 'payment_reference'=>$payment_reference, 'wave_type'=>'Order', 'amount'=>$amount, 'status'=>'Pending', 'date_add'=>date('Y-m-d'));

        $inserted = $wpdb->insert($this->table, $args, array('%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s'));
        if ($inserted == 1) {
            return $wpdb->insert_id;
        }
    }

    public function addPOSReference($user, $currency, $amount, $payment_reference, $payment_description)
    {
        global $wpdb;
        $args = array('id_cart'=>0, 'id_currency'=>$currency->id_wave_currency, 'user_id'=>$user->ID, 'payment_reference'=>$payment_reference, 'payment_description'=>$payment_description, 'wave_type'=>'Digital_POS', 'amount'=>$amount, 'status'=>'Pending', 'date_add'=>date('Y-m-d'));

        $inserted = $wpdb->insert($this->table, $args, array('%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s'));
        if ($inserted == 1) {
            return $wpdb->insert_id;
        }
    }


    public function addBillReference($user, $id_currency, $reference, $country_code, $biller_type, $amount, $biller_name, $biller_code, $item_code, $customer_identifier, $name)
    {
        $p = new self();

        if (in_array($biller_type, array('airtime', 'data_bundle'))) {
            $service_amount = $amount;
        } else {
            $service_amount = $amount - 100;
        }

        $billref = strtoupper(APHTools::codeGenerator(16).$amount.APHTools::codeGenerator(16));

        global $wpdb;
        $args = array('id_cart'=>0, 'id_currency'=>$id_currency, 'user_id'=>$user->ID, 'payment_reference'=>$reference, 'bill_reference'=>$billref, 'country_code'=>$country_code, 'name'=>$name, 'biller_type'=>$biller_type, 'biller_name'=>$biller_name,'biller_code'=>$biller_code, 'item_code'=>$item_code, 'customer_identifier'=>$customer_identifier,  'wave_type'=>'Bill_Payment', 'amount'=>$amount,'service_amount'=>$service_amount, 'status'=>'Pending', 'date_add'=>date('Y-m-d'), 'occurence'=>'ONCE');

        $inserted = $wpdb->insert($this->table, $args, array('%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
        if ($inserted == 1) {
            return $wpdb->insert_id;
        }
    }




    public function addBillPoint($point, $reference, $biller_type, $status, $response)
    {
        $p = new self();


        $paymentref = strtoupper(APHTools::codeGenerator(8).APHTools::codeGenerator(12));


        global $wpdb;
        $args = array('id_currency'=>$point->id_currency, 'user_id'=>$point->user_id, 'payment_reference'=>$paymentref, 'bill_reference'=>$reference, 'country_code'=>$point->country_code, 'biller_type'=>$point->biller_type, 'biller_name'=>$point->biller_name, 'customer_identifier'=>$point->mobile_number,  'wave_type'=>'Bill_Payment', 'amount'=>$point->service_amount,'service_amount'=>$point->service_amount, 'status'=>$status, 'bill_response'=>$response->status, 'bill_message'=>$response->message, 'bill_ref'=>$response->data->reference,  'date_add'=>date('Y-m-d'));

        $inserted = $wpdb->insert($this->table, $args, array('%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
        if ($inserted == 1) {
            return $wpdb->insert_id;
        }
    }


    public function updateURL($idobj, $response)
    {
        global $wpdb;
        if (is_object($idobj)) {
            $updated = $wpdb->update($this->table, array('payment_url' => $response->data->link, 'status'=>'Processed'), array('id_wave_order' => $idobj->id_wave_order), array('%s','%s'), array('%d'));
            if ($updated == 1) {
                return true;
            }
        }


        $updated = $wpdb->update($this->table, array('payment_url' => $response->data->link, 'status'=>'Processed'), array('id_wave_order' => $idobj), array('%s','%s'), array('%d'));
        if ($updated == 1) {
            return true;
        }


        return true;
    }


    public function updateStatus($id_wave_order, $id_order, $response, $status)
    {
        global $wpdb;
        $updated = $wpdb->update($this->table, array('status' => $status, 'id_order'=>$id_order, 'transaction_id'=>$response->id, 'flw_ref'=>$response->flw_ref, 'payment_type'=>$response->payment_type), array('id_wave_order' => $id_wave_order), array('%s', '%d', '%s', '%s', '%s'), array('%d'));
        if ($updated == 1) {
            return true;
        }
        return false;
    }


    public function updateStatusAdmin($id_wave_order, $id_order, $status)
    {
        global $wpdb;
        $updated = $wpdb->update($this->table, array('status' => $status, 'id_order'=>$id_order), array('id_wave_order' => $id_wave_order), array('%s', '%d'), array('%d'));
        if ($updated == 1) {
            return true;
        }
        return false;
    }


    public function byPaymentReference($payment_reference)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE payment_reference = %s ", $payment_reference);
        $row = $wpdb->get_row($sql, OBJECT);
        if (is_object($row)) {
            return $row;
        }

        return false;
    }




    public function completeBillingOrder($wave_vars)
    {
        $wavepayment = new AppHost_APHPayment('');
        $response = $wavepayment->makeBillPayment($wave_vars);

        if (is_object($response) && $response->status =='success') {
                //

            $this->updateKey($wave_vars->id_wave_order, 'bill_response', $response->status);
            $this->updateKey($wave_vars->id_wave_order, 'bill_message', $response->message);
            $this->updateKey($wave_vars->id_wave_order, 'bill_flw_ref', $response->data->flw_ref);
            $this->updateKey($wave_vars->id_wave_order, 'bill_ref', $response->data->reference);

            if (isset($response->data->extra)) {
                $this->updateKey($wave_vars->id_wave_order, 'bill_extra', $response->data->extra);
            }

            $this->updateStatusAdmin($wave_vars->id_wave_order, 0, 'Completed');

            $this->billPaymentEmail($wave_vars->id_wave_order);

            $this->addCustomerPoints($wave_vars);

            return ['status'=>'OK', 'response'=>$response->message];
        }
        $this->updateKey($wave_vars->id_wave_order, 'bill_response', $response->status);
        $this->updateKey($wave_vars->id_wave_order, 'bill_message', $response->message);
        if (is_object($response)) {
            return  ['status'=>'NK', 'response'=>$response->message];
            ;
        }
        return false;
    }
    public function getObjectByCart($id_cart)
    {
        $id = (int) Db::getInstance()->getValue('SELECT id_wave_order FROM '._DB_PREFIX_.'AppHost_APH_orders WHERE id_cart = '.(int) $id_cart);
        if ((int) $id >0) {
            return new self($id);
        }
        return false;
    }



    public function addCustomerPoints($wave_vars)
    {
        if (get_option('FW_FWAVE_CUSTOMER_POINTS') ==1) {
            (new AppHost_APHPoint())->addT($wave_vars);
            return true;
        }
    }







    public function customerBills($user_id)
    {
        global $wpdb;

        $sql = $wpdb->prepare("SELECT  b.*, c.iso_code, c.sign FROM $this->table b INNER JOIN ".$wpdb->prefix."AppHost_APH_currencies c ON c.id_wave_currency = b.id_currency  WHERE user_id = %d AND wave_type= %s ORDER BY id_wave_currency DESC ", $user_id, 'Bill_Payment');
        $result = $wpdb->get_results($sql);
        return $result;
    }
    public static function getAll()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT  b.*, c.iso_code, c.sign FROM $this->table b INNER JOIN ".$wpdb->prefix."AppHost_APH_currencies c ON c.id_wave_currency = b.id_currency  WHERE %d ORDER BY id_wave_order DESC ", 1);
        $result = $wpdb->get_results($sql);
        return $result;
    }


    public function getWithUsers()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT  b.*, c.iso_code, c.sign, display_name, user_email FROM $this->table b INNER JOIN ".$wpdb->prefix."AppHost_APH_currencies c ON c.id_wave_currency = b.id_currency INNER JOIN ".$wpdb->prefix."users u ON u.ID = b.user_id  WHERE %d ORDER BY id_wave_order DESC ", 1);
        $result = $wpdb->get_results($sql);
        return $result;
    }



    public function billsWithUsers()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT  b.*, c.iso_code, c.sign, display_name, user_email FROM $this->table b INNER JOIN ".$wpdb->prefix."AppHost_APH_currencies c ON c.id_wave_currency = b.id_currency INNER JOIN ".$wpdb->prefix."users u ON u.ID = b.user_id  WHERE wave_type = %s ORDER BY id_wave_order DESC ", 'Bill_Payment');
        $result = $wpdb->get_results($sql);
        return $result;
    }


    public function posWithUsers()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT  b.*, c.iso_code, c.sign, display_name, user_email FROM $this->table b INNER JOIN ".$wpdb->prefix."AppHost_APH_currencies c ON c.id_wave_currency = b.id_currency INNER JOIN ".$wpdb->prefix."users u ON u.ID = b.user_id  WHERE wave_type = %s ORDER BY id_wave_order DESC ", 'Digital_POS');
        $result = $wpdb->get_results($sql);
        return $result;
    }





    public function getByID($id)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE id_wave_order = %d", $id);
        $result = $wpdb->get_row($sql, OBJECT);
        return $result;
    }


    public static function byOrderID($id)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE id_order = %d", $id);
        $result = $wpdb->get_results($sql, OBJECT);
        return $result;
    }



    public function getAwaitingCompletion()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE status = %s", "Paid");
        $result = $wpdb->get_results($sql, OBJECT);
        return $result;
    }





    public function updateKey($id, $key, $value, $t = '%s')
    {
        global $wpdb;
        $updated = $wpdb->update($this->table, array($key => $value), array('id_wave_order' => $id), array($t), array('%d'));
        if ($updated == 1) {
            return true;
        }

        return false;
    }



    public function deleteD($id)
    {
        global $wpdb;
        $del = $wpdb->delete($this->table, array('id_wave_order' => $id), array('%d'));
        if ($del == 1) {
            return true;
        }

        return false;
    }



    public static function getCurrencyForOrder($country)
    {
        $codes =array('NG'=>'NGN', 'US'=>'USD', 'GH'=>'GHS', 'KE'=>'KES', 'UG'=>'UGX');
        $iso =  $codes[$country];

        return AppHost_APHCurrency::currencyByCountryCode($iso);
    }



    public function billPaymentEmail($id_wave_order)
    {
        $worder = (new self())->getByID($id_wave_order);
        if (!is_object($worder)) {
            return;
        }
        if (strtolower($worder->biller_type) !='power') {
            return;
        }

        if ($worder->bill_extra =='') {
            return;
        }

        $customer = get_user_by('ID', $worder->user_id);
        if (!is_object($customer)) {
            return;
        }
        $mainurl = get_bloginfo('url');
        $message = '<p> <strong> Bill Reference: </strong>'.$worder->bill_reference. '</p>';
        $message.= '<p> <strong> Response: </strong>'.$worder->bill_message. '</p>';
        $message.= '<p> <strong> Token: </strong>'.$worder->bill_extra. '</p>';
        $message.= '<p> <strong> '.$worder->bill_name.' </strong></p>';
        (new AppHost_APHMailBoss())->post($customer->user_email, 'Electricity /Power Bill Payment Token', $message, $mainurl, 'Know More', $customer->display_name);


        return true;
    }
}
