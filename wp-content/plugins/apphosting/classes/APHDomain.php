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

require_once dirname(__FILE__).'/APHModel.php';
require_once dirname(__FILE__).'/APHAddress.php';
require_once dirname(__FILE__).'/APHCountry.php';
require_once dirname(__FILE__).'/APHLogger.php';
require_once dirname(__FILE__).'/APHTools.php';
require_once 'InternetBS.php';

class APHDomain extends APHModel
{
    public $id_domain;
    public $user_id;
    public $id_reg_address;
    public $id_admin_address;
    public $id_tech_address;
    public $id_billing_address;
    public $first_years;
    public $current_years;
    public $name;
    public $active;
    public $status;
    public $domain_state;
    public $transfer_code;
    public $transfer_note;
    public $client_ip;
    public $transaction_id;
    public $cost_price;
    public $price;
    public $paid_amount;
    public $dns1;
    public $dns2;
    public $dns3;
    public $dns4;
    public $domain_start;
    public $domain_end;
    public $last_cron;
    public $payload;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_domains';
    }



    public function existCheckField()
    {
        return 'name';
    }

    public function primaryKey()
    {
        return 'id_domain';
    }




    public function requiredFields()
    {
        return array('user_id', 'id_reg_address', 'id_admin_address', 'id_tech_address', 'id_billing_address', 'name', 'status');
    }

     public function otherFields()
     {
         return array('user_id', 'id_reg_address', 'id_admin_address', 'id_tech_address', 'id_billing_address', 'name', 'active', 'status', 'domain_state', 'transfer_code', 'transfer_note', 'client_ip', 'transaction_id', 'cost_price', 'price', 'paid_amount');
     }

    public function definitions()
    {
        return array(
                'user_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_reg_address'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_admin_address'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_tech_address'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_billing_address'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'name'=>array('type'=>'STRING', 'validate'=>'isString'),
                'active'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'first_years'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'current_years'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'status'=>array('type'=>'STRING', 'validate'=>'isString'),
                'domain_state'=>array('type'=>'STRING', 'validate'=>'isString'),
                'transfer_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'transfer_note'=>array('type'=>'STRING', 'validate'=>'isString'),
                'client_ip'=>array('type'=>'HTML', 'validate'=>'isString'),
                'transaction_id'=>array('type'=>'STRING', 'validate'=>'isString'),
                'cost_price'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'price'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'paid_amount'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),

                'dns1'=>array('type'=>'STRING', 'validate'=>'isString'),
                'dns2'=>array('type'=>'STRING', 'validate'=>'isString'),
                'dns3'=>array('type'=>'STRING', 'validate'=>'isString'),
                'dns4'=>array('type'=>'STRING', 'validate'=>'isString'),
                'domain_start'=>array('type'=>'STRING', 'validate'=>'isString'),
                'domain_end'=>array('type'=>'STRING', 'validate'=>'isString'),
                'last_cron'=>array('type'=>'STRING', 'validate'=>'isString'),
                'payload'=>array('type'=>'STRING', 'validate'=>'isString'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }




    public function getAllDomains()
    {
        return $this->getAll();
    }


    public function countMineByState($id, $type='Register')
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE user_id = %d AND domain_state = %s", $id, $type);
        return  $wpdb->get_var($sql);
    }






    public static function fieldUpdate($id, $field, $value, $t = '%s')
    {
        return (new self())->updateKey($id, $field, $value, $t);
    }


    public function addressToContact($id_address)
    {
        $aph = new APHAddress();
        $address = $aph->getById($id_address);
        $country = (new APHCountry())->getById($address->id_country);

        if (is_object($country) && (int) $country->id_country > 0) {
            $sub = substr($address->phone, 0, 1);
            if ($sub =='0') {
                $phone = $country->calling_code.substr($address->phone, 1, strlen($address->phone));
            } else {
                $phone = $country->calling_code.$address->phone;
            }
            $country_code = $country->code;
        }


        $contact = array(
           'Firstname'    => $address->firstname,
        'Lastname'     => $address->lastname,
        'CountryCode'  => $country_code,
        'State'        => $address->province_or_state,
        'City'         => $address->city,
        'Email'        => $address->email,
        'PostalCode'        => $address->postal_code);

        if (strlen($address->address) >32) {
            $contact['Street'] = substr($address->address, 0, 32);
            $contact['Street2'] = substr($address->address, 33, strlen($address->address));
        } else {
            $contact['Street'] = $address->address;
        }
        $contact['PhoneNumber'] = $phone;

        return $contact;
    }

    public function processDomainOrder($id_domain)
    {
        $aph = $this->getById($id_domain);
        if (is_object($aph) && (int) $aph->id_domain > 0) {
            $response = $this-> registerDomain($aph);
            if (is_array($response) && isset($response['status']) && $response['status'] =='OK') {
                self::fieldUpdate($id_domain, 'active', 1);
                self::fieldUpdate($id_domain, 'domain_start', date('Y-m-d H:i:s'));
                self::fieldUpdate($id_domain, 'domain_end', date('Y-m-d', $response['expiry_date']));
                self::fieldUpdate($id_domain, 'paid_amount', $aph->price);
                self::fieldUpdate($id_domain, 'dns1', 'ns-canada.topdns.com ');
                self::fieldUpdate($id_domain, 'dns2', 'ns-uk.topdns.com ');
                self::fieldUpdate($id_domain, 'dns3', 'ns-usa.topdns.com');
                self::fieldUpdate($id_domain, 'dns4', 'ns-usa.topdns.com');

                APHLogger::log('Domain registration completed successfully with message '. $response['message'], 'Domain Registration');

                return true;
            }

            APHLogger::log('Domain registration failed: '.$response['message'], 'Domain Registration');
        }


        APHLogger::log('Domain registration failed, invalid domain aph object ', 'Domain Registration');
        return false;
    }

    public function processDomainRenewal()
    {
    }

    public function processDomainTransfer()
    {
    }



    public function domainCheck($domain)
    {
        if (get_option('APH_INTERNETBS_REG_STATUS') =='Live') {
            InternetBS::init(get_option('APH_INTERNETBS_KEY'), get_option('APH_INTERNETBS_PASSWORD'));
        }

        try {
            if (InternetBS::api()->domainCheck($domain)) {
                return ['status'=>'OK', 'available'=>'Yes', 'message'=>'Domain is available'];
            } else {
                return ['status'=>'OK', 'available'=>'No', 'message'=>'Domain is not available'];
            }


            //print_r(InternetBS::api()->accountPriceListGet('USD'));
        } catch (Exception $e) {
            APHLogger::log('Domain check failed with error '.$e->getMessage(), 'Domain Check');
            return ['status'=>'NK', 'available'=>'No', 'message'=>$e->getMessage()];
        }
    }

    public function registerDomain($aph)
    {
        try {
            $contacts = array(
                'Registrant' => $this->addressToContact($aph->id_reg_address),
                'Admin'      => $this->addressToContact($aph->id_admin_address),
                'Technical'  => $this->addressToContact($aph->id_tech_address),
                'Billing'    => $this->addressToContact($aph->id_billing_address),
            );
            $expirationDate1 = InternetBS::api()->domainCreate($aph->name, $contacts, 3, array('Ns_list' => 'ns-canada.topdns.com,ns-uk.topdns.com,ns-usa.topdns.com'));

            return ['status'=>'OK', 'registered'=>'Yes', 'expiry_date'=>$expirationDate1, 'message'=>"Domain ".$domain." registered, expiration date is ".date('Y-m-d', $expirationDate1)];
        } catch(Exception $e) {
            APHLogger::log('Domain registration failed with error '.$e->getMessage(), 'Domain Registration');
            return ['status'=>'NK',  'message'=>$e->getMessage()];
        }
    }


    public function getDomainPrices()
    {
        if (get_option('APH_INTERNETBS_REG_STATUS') =='Live') {
            InternetBS::init(get_option('APH_INTERNETBS_KEY'), get_option('APH_INTERNETBS_PASSWORD'));
        }
        try {
            $prices = InternetBS::api()->accountPriceListGet('USD');
            return $prices;
        } catch (Exception $e) {
            return ['status'=>'NK',  'message'=>$e->getMessage()];
        }
    }


    public static function domainPrices()
    {
        return (new self())->getDomainPrices();
    }



    public function renewDomain($domain, $years = 1)
    {
        try {
            $expiration_date = InternetBS::api()->domainRenew($domain, $years, date('Y-m-d', $expiration_date));
            return ['status'=>'OK',  'message'=>'New expiration date is '.$expiration_date];
        } catch(Exception $e) {
            return ['status'=>'NK',  'message'=>$e->getMessage()];
        }
    }
}
