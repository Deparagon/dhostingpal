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

class AppHost_APHPayment
{
    public $keys;
    public $service_url;
    public $return_url;

    public function __construct($return_url)
    {
        $this->return_url = $return_url;
    }

    public function getPaymentOptions()
    {
        return 'card, ussd, mpesa,mobilemoney,paypal';
    }


    public function getAppKeys()
    {
        if (get_option('FW_FWAVE_LIVE') ==1) {
            return array('public_key' => get_option('FW_LIVE_FWAVE_KEY'), 'secret_key' => get_option('FW_LIVE_FWAVE_SECRETKEY'), 'encryption_key'=>get_option('FW_LIVE_WAVE_ENCYKEY'), 'base_url'=>'https://api.flutterwave.com', 'live'=>1);
        }

        if (get_option('FW_FWAVE_LIVE') ==0) {
            return array('public_key' => get_option('FW_TEST_FWAVE_KEY'), 'secret_key' => get_option('FW_TEST_FWAVE_SECRETKEY'), 'encryption_key'=>get_option('FW_TEST_FWAVE_ENCYKEY'), 'base_url'=>'https://api.flutterwave.com', 'live'=>0);
        }
    }



    public function getPaymentURL($user, $reference, $total, $currency, $id_wave_order, $order_note = '')
    {
        $usermeta = get_user_meta($user->ID);
        $first_name = 'John';
        $last_name = 'Doe';

        if (is_array($usermeta) && $usermeta['first_name'] !='') {
            $first_name = $usermeta['first_name'];
        }

        if (is_array($usermeta) && $usermeta['last_name'] !='') {
            $last_name = $usermeta['last_name'];
        }

        $params = array(
          'tx_ref'=>$reference,
          'amount'=>$total,
          'currency'=>$currency,
          'payment_options'=>$this->getPaymentOptions(),
          'redirect_url'=> $this->return_url,
          'meta'=>['ID'=>$id_wave_order],
          'customer'=>['email'=>$user->user_email, 'name'=>$user->display_name],
          'customizations'=>['title'=>get_bloginfo('name').' Order']

        );

        try {
            $response = $this->sendRequest('/v3/payments', $params);
            return $response;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getHeaders($endpoint)
    {
        $this->keys = $this->getAppKeys();
        $this->service_url = $this->keys['base_url'].$endpoint;
        return array(
         "Content-Type: application/json",
         "Authorization: Bearer ".$this->keys['secret_key'],
        );
    }

    public function getBillCategories()
    {
        return $this->getRequest('/v3/bill-categories');
    }

    public function getSpecificBills($vars)
    {
        return $this->obtainData($this->getRequest('/v3/bill-categories?'.$vars));
    }

    public function validateBill($item_code, $code, $customer)
    {
        $endpoint = '/v3/bill-items/'.$item_code.'/validate?code='.urlencode($code).'&customer='.urlencode($customer);
        return $this->getRequest($endpoint);
    }


    public function getBillers()
    {
        $endpoint = '/v3/billers';
        return $this->getRequest($endpoint);
    }

    public function getBillStatus($ref)
    {
        $endpoint = '/v3/bills/'.$ref;
        return $this->getRequest($endpoint);
    }



    public function getBills($from, $to, $page = 1)
    {
        $endpoint = '/v3/bills?from='.urlencode($from).'&to='.urlencode($to).'&page='.urlencode($page);
        return $this->getRequest($endpoint);
    }



    public function getBillAmount($item_code, $code)
    {
        $endpoint = '/v3/billers/'.$code.'/products/'.urlencode($item_code);
        return $this->getRequest($endpoint);
    }



    public function payBill($amount, $customer_identifier, $country, $name, $biller_name, $reference, $recurrence = 'ONCE')
    {
        $endpoint = '/v3/bills';

        $params = array(
          'country'=>$country,
          'customer'=>$customer_identifier,
          'amount'=>$amount,
          'recurrence'=>$recurrence,
          'type'=> $name,
          'biller_name'=>$biller_name,
          'reference'=>$reference);
        return  $this->sendRequest($endpoint, $params);
    }

    public function makeBillPayment($bill, $recurrence = 'ONCE')
    {
        $endpoint = '/v3/bills';

        switch (strtolower($bill->biller_type)) {
            case 'airtime':
                $biller_type = $bill->biller_name;
                break;
            case 'data_bundle':
                $biller_type = $bill->name;
                break;

            case 'cables':
                $biller_type = $bill->name;
                break;

            default:
                $biller_type = $bill->name;
                break;
        }


        $params = array(
         'country'=>$bill->country_code,
         'customer'=>$bill->customer_identifier,
         'amount'=>$bill->service_amount,
         'recurrence'=>$recurrence,
         'type'=> $biller_type,
         'biller_name'=>$bill->biller_name,
         'reference'=>$bill->bill_reference,
         'item_code'=>$bill->item_code,
         'biller_code'=>$bill->biller_code,
        );

        return  $this->sendRequest($endpoint, $params);
    }

    public function obtainData($response)
    {
        if (is_object($response)) {
            if ($response->status =='success') {
                return $response->data;
            }
            return $response->status;
        }
        return 'error';
    }

    public function sendRequest($endpoint, $data)
    {
        $headers = $this->getHeaders($endpoint);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $this->service_url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $base_response = curl_exec($ch);
        curl_close($ch);
        return json_decode($base_response);
    }

    public function getRequest($endpoint)
    {
        $headers = $this->getHeaders($endpoint);
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $this->service_url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
    public function verifyRequest($transaction_id)
    {
        $endpoint = "/v3/transactions/".$transaction_id."/verify";
        return $this->getRequest($endpoint);
    }
}
