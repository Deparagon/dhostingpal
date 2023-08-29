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

class APHPrivActions
{
    public $return_url;
    public $authuser;
    public $user_id;
    public function frontActionsBaseField()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHTools.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHPlan.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHDomain.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHDomainPrice.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHAddress.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHOrder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHInvoice.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHPaystack.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHCustomer.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHLogger.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHCountry.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHTicket.php';

        $request_token = APHTools::getValue('request_token');
        $this->return_url = home_url();

        $authuser = wp_get_current_user();
        if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0):
            $user_id = $authuser->ID;

        else:
            APHTools::displayError('Invalid access, you need to login before you can have access to this page');

        endif;
        $this->authuser = $authuser;
        $this->user_id = $authuser->ID;


        if ($request_token === 'APYJFRBCIYIBUOKHTYCLEYRSFFZSQIPLNQEJJLMERQOSUYNBVZTGYUZYVRURUMDU') {
            $this->checkDomainAvailability();
        }

        if ($request_token==='APNXGVIAFAHURTPPMJULOEJZAYERSMZUZDHRPPJILTLVJZZRPMFRJXNGLIHPXJNQ') {
            $this->showOrderSummary();
            exit;
        }

        if ($request_token==='APPGTMPSNZDJGTWAXQHHEAQIQTKZKLTNSDPLQXJGSOIDJCAPUGOBCJMELZXSBLHJ') {
            $this->createOrder();
            exit;
        }

        if ($request_token ==='APQOFYDZMAMYNJZQRHWGYATTVJNZMDWNAIKRNCWFEAOWSKCMTHTQAQQYJGAUJFGA') {
            $this->domainRegistrationShow();
            exit;
        }


        if ($request_token === 'APERBKEYTTXDAPIRLCSYVQFVEIQXMFWITSLEKICEDJXDXVZZJSAZAJABAZHWZBHH') {
            $this->processDomainOnlyOrder();
            exit;
        }

        if ($request_token === '609457CEFA424FFA8D3A9515154F2977') {
            $this->submitConversionRequest();
            exit;
        }
    }


    public function checkDomainAvailability()
    {
        $domain = APHTools::getValue('domain_name');
        $domain = trim($domain);
        if ($domain =='') {
            APHTools::displayError('Domain name is required');
        }

        $result = (new APHDomain())->domainCheck($domain);

        APHTools::sendJSON($result);
    }


    public function processDomainOnlyOrder()
    {
        $domain = APHTools::getValue('domain_name');
        $domain_type = APHTools::getValue('domain_type');
        $id_reg_address = (int) APHTools::getValue('selected_registrant_address');

        $payment_option = APHTools::getValue('payment_option_checkout');

        $domain_years = (int) APHTools::getValue('number_of_domain_years');

        $user_id = $this->user_id;


        $ext = (new APHDomainPrice())->getFullPrice($domain);
        if (!is_object($ext)) {
            APHTools::displayError('Invalid domain price result');
        }

        if ($domain_type =='Transfer') {
            $price =$ext->transfer;
        } elseif ($domain_type =='Register') {
            $price =$ext->registration;
        }


        $post_regs =[];
        $create_reg = false;
        $rfs = [];
        $regs = array('registrant_email','registrant_firstname', 'registrant_lastname', 'registrant_phone', 'registrant_postal_code', 'registrant_address','registrant_city', 'registrant_province_or_state', 'registrant_id_country', 'registrant_address_name');


        if(!isset($_POST)  || !is_array($_POST)) {
            APHTools::displayError('Submit form fields');
        }


        if($id_reg_address ==0) {
            $create_reg = true;
            $rfs = $regs;
        }

        foreach($_POST as $field => $value) {
            if(strpos($field, '_registrant') !==false) {
                $post_regs[ str_replace('_registrant', '', $field)] = $value;
            }

            if(in_array($field, $rfs)  && $value =='') {
                APHTools::displayError($field.' is required');
            }
            $$field = $value;
            $post_args[$field] = $value;
        }


        if($domain_type =='Transfer') {
            if($transfer_code =='') {
                APHTools::displayError('Transfer code / Domain EPP code is required. If you do not have the EPP code, contact your current domain registrar.');
            }
        }


        $price = $price * $domain_years;
        $total = $price;

        $total_ng = APHTools::toNg($total);


        $oaddres = new APHAddress();
        if($create_reg ==true) {
            $oaddres->validateFields($post_regs);
            $oaddres->filled['address_type'] = 'Billing';
            $oaddres->filled['user_id'] = $user_id;
            if($domain_type =='Transfer') {
                $oaddres->filled['transfer_code'] = $transfer_code;
                $oaddres->filled['transfer_note'] = $transfer_note;
            }
            $oaddres->saveField();
            $id_default_address = $oaddres->latest_id;

            $id_tech_address = $id_default_address;
            $id_reg_address = $id_default_address;
            $id_admin_address = $id_default_address;
            $id_billing_address = $id_default_address;
        } else {
            $id_tech_address = $id_reg_address;
            $id_admin_address = $id_reg_address;
            $id_billing_address = $id_reg_address;
        }


        $domain_args =array('user_id'=>$user_id, 'id_reg_address'=>$id_reg_address, 'id_admin_address'=>$id_admin_address, 'id_tech_address'=>$id_tech_address, 'id_billing_address'=>$id_billing_address, 'name'=>$domain, 'status'=>'Pending',  'price'=>$price, 'domain_state'=>$domain_type, 'first_years'=>$domain_years, 'current_years'=>$domain_years, 'created_at'=>date('Y-m-d H:i:s'));



        $domaino = new APHDomain();
        $domaino->validateFields($domain_args);
        $domaino->saveField();
        $id_domain = $domaino->latest_id;

        $reference = 'DHPO'.APHTools::codeGenerator(16);
        $payment_reference = 'DHPINV'.APHTools::codeGenerator(14);


        $args = array('user_id'=>$user_id, 'id_domain'=>$id_domain, 'id_currency'=>2, 'app_domain'=>$domain, 'order_total'=>$total_ng, 'default_total'=>$total, 'reference'=>$reference, 'created_at'=>date('Y-m-d H:i:s'));
        $ordero = new APHOrder();
        $ordero->validateFields($args);
        $ordero->saveField();
        $order= $ordero->getLatest();


        $ostack = new APHPaystack();

        $ocustomer = new APHCustomer();
        $excustomer = $ocustomer->userFirst($user_id);

        if($ocustomer->checkIfUserHas($user_id)) {
            $customer_code = $excustomer->customer_code;
        } else {
            $customer_code = $ostack->createCustomer($this->authuser, $phone);
        }


        $invoice_args = array('user_id'=>$user_id, 'id_order'=>$order->id_order, 'invoice_amount'=>$total_ng, 'default_amount'=>$total, 'status'=>'Unpaid','paid_amount'=>0.00, 'reference'=>$payment_reference, 'created_at'=>date('Y-m-d H:i:s'));

        $i_instance = new APHInvoice();
        $i_instance->validateFields($invoice_args);
        $i_instance->saveField();
        $invoice= $i_instance->getLatest();

        if(!is_object($invoice) || (int) $invoice->id_invoice ==0) {
            APHTools::displayError('Could not generate payable invoice for this order, try again, if this issue persist, please contact support');
        }


        if($payment_option =='Paystack') {
            $status = $ostack->initiatePayment($invoice, $this->authuser->user_email);
            if($status ===true) {
                $invoice = $i_instance->getById($invoice->id_invoice);
                if(is_object($invoice) && $invoice->payment_url !='') {
                    APHTools::ajaxReport('OK', 'success', '', $invoice->payment_url);
                }
            }

            APHTools::displayError('Could not generate payment information, try other payment options');
        } elseif($payment_option =='Transfer') {
            $contents = array('total'=>$total_ng, 'order_number'=>'#'.$order->id_order, 'reference'=>$payment_reference);
            APHTools::ajaxReport('OK', 'success', $contents);
        }

        APHTools::displayError('Could not process order, try again later');
    }


    public function createOrder()
    {
        $user_id = $this->user_id;
        $authuser = $this->authuser;

        $domain = APHTools::getValue('domain_name');
        $hosting_plan = (int) APHTools::getValue('hosting_plan');
        $domain_type = APHTools::getValue('domain_type');
        $has_address = APHTools::getValue('user_has_address');

        $payment_option = APHTools::getValue('payment_option_checkout');

        $domain_years = (int) APHTools::getValue('number_of_domain_years');

        $_admin = (int) APHTools::getValue('user_reg_for_admin');
        $_tech = (int) APHTools::getValue('user_reg_for_tech');
        $_billing = (int) APHTools::getValue('user_reg_for_billing');


        $id_existing_default_address = (int) APHTools::getValue('id_existing_default_address');
        $id_existing_reg_address = (int) APHTools::getValue('id_existing_reg_address');
        $id_existing_admin_address = (int) APHTools::getValue('id_existing_admin_address');
        $id_existing_billing_address = (int) APHTools::getValue('id_existing_billing_address');
        $id_existing_tech_address = (int) APHTools::getValue('id_existing_tech_address');

        if ($domain_type =='Existing') {
            $price = 0;
        } elseif ($domain_type =='Transfer') {
            $price =$ext->transfer;
        } elseif ($domain_type =='Register') {
            $price =$ext->registration;
        }


        $ext = (new APHDomainPrice())->getFullPrice($domain);
        if (!is_object($ext)) {
            APHTools::displayError('Invalid domain price result');
        }

        $plan = (new APHPlan())->getById($hosting_plan);

        if (!is_object($plan)) {
            APHTools::displayError('Select App hosting package.');
        }


        $post_args = [];
        $post_techs = [];
        $post_defaults = [];
        $post_admins = [];
        $post_regs =[];
        $post_billings = [];

        $create_type = 'DEFAULT';
        $create_tech = false;
        $create_admin = false;
        $create_billing = false;


        $admins = array('admin_email','admin_firstname', 'admin_lastname', 'admin_phone', 'admin_postal_code', 'admin_address','admin_city', 'admin_province_or_state', 'admin_id_country', 'admin_address_name');
        $billings = array('billing_email','billing_firstname', 'billing_phone', 'billing_lastname', 'billing_postal_code', 'billing_address','billing_city', 'billing_province_or_state', 'billing_id_country', 'billing_address_name');

        $techs = array('tech_email','tech_firstname', 'tech_phone', 'tech_lastname', 'tech_postal_code', 'tech_address','tech_city', 'tech_province_or_state', 'tech_id_country', 'tech_address_name');

        if(!isset($_POST)  || !is_array($_POST)) {
            APHTools::displayError('Submit form fields');
        }


        if($domain_type =='Existing'  && $has_address =="No") {
            $rfs = array('default_firstname', 'default_lastname', 'default_postal_code', 'default_address','default_city', 'default_province_or_state', 'default_id_country', 'default_phone', 'default_address_name');
            $create_type = 'DEFAULT';
        } elseif($domain_type =='Transfer' && $has_address=="No") {
            $rfs = array('default_firstname', 'default_lastname', 'default_postal_code', 'default_address','default_city', 'default_province_or_state', 'default_id_country', 'default_phone', 'default_address_name', 'transfer_code');
            $create_type = 'DEFAULT';
        } elseif($domain_type =='Register' && $has_address=='No') {
            $rfs = array('registrant_email','registrant_firstname', 'registrant_lastname', 'registrant_postal_code', 'registrant_address','registrant_city', 'registrant_phone', 'registrant_province_or_state', 'registrant_id_country', 'registrant_address_name');
            $create_type = 'REGISTRANT';

            if($_admin ==0) {
                $rfs = array_merge($rfs, $admins);
                $create_admin = true;
            }
            if($_tech ==0) {
                $rfs = array_merge($rfs, $techs);
                $create_tech = true;
            }

            if($_billing ==0) {
                $rfs = array_merge($rfs, $billings);
                $create_billing = true;
            }
        } elseif($domain_type=='Existing' && $has_address =='Yes') {
            if($id_existing_default_address ==0) {
                APHTools::displayError('Select address from the drop down list');
            }
            $rfs =array('id_existing_default_address');

            $create_type ='DEFAULTSELECTED';
        } elseif($domain_type =='Transfer' && $has_address=='Yes') {
            if($id_existing_default_address ==0) {
                APHTools::displayError('Select address from the drop down list');
            }
            $rfs =array('id_existing_default_address', 'transfer_code');
            $create_type ='DEFAULTSELECTED';
        } elseif($domain_type=='Register' && $has_address =='Yes') {
            if($id_existing_reg_address  ==0) {
                $rfs = array('registrant_email','registrant_firstname', 'registrant_lastname', 'registrant_postal_code', 'registrant_address','registrant_city', 'registrant_phone', 'registrant_province_or_state', 'registrant_id_country', 'registrant_address_name');
                $create_type = 'REGISTRANTCREATE';
            } else {
                $create_type = 'REGISTRANTSELECT';
            }


            if($_admin ==0) {
                if($id_existing_admin_address ==0) {
                    $rfs = array_merge($rfs, $admins);
                    $create_admin = true;
                }
            }
            if($_tech ==0) {
                if($id_existing_tech_address ==0) {
                    $rfs = array_merge($rfs, $techs);
                    $create_tech = true;
                }
            }

            if($_billing ==0) {
                if($id_existing_billing_address ==0) {
                    $rfs = array_merge($rfs, $billings);
                    $create_billing = true;
                }
            }
        }



        foreach($_POST as $field => $value) {
            if(strpos($field, 'admin_') !==false) {
                $post_admins[ str_replace('admin_', '', $field)] = $value;
            } elseif(strpos($field, 'registrant_') !==false) {
                $post_regs[ str_replace('admin_', '', $field)] = $value;
            } elseif(strpos($field, 'default_') !==false) {
                $post_defaults[ str_replace('default_', '', $field)] = $value;
            } elseif(strpos($field, 'tech_') !==false) {
                $post_techs[ str_replace('tech_', '', $field)] = $value;
            } elseif(strpos($field, 'billing_') !==false) {
                $post_billings[ str_replace('billing_', '', $field)] = $value;
            }

            if(in_array($field, $rfs)  && $value =='') {
                APHTools::displayError($field.' is required');
            }
            $$field = $value;
            $post_args[$field] = $value;
        }


        $price = $price * $domain_years;

        $monthly = $plan->monthly_price;
        $total = $monthly + $price;

        $total_ng = APHTools::toNg($total);


        $oaddres = new APHAddress();
        if($create_type =='DEFAULT') {
            $oaddres->validateFields($post_defaults);
            $oaddres->filled['address_type'] = 'Billing';
            $oaddres->filled['user_id'] = $user_id;
            $oaddres->saveField();
            $id_default_address = $oaddres->latest_id;

            $id_tech_address = $id_default_address;
            $id_reg_address = $id_default_address;
            $id_admin_address = $id_default_address;
            $id_billing_address = $id_default_address;
        } elseif($create_type =='DEFAULT') {
            $oaddres->validateFields($post_defaults);
            $oaddres->filled['user_id'] = $user_id;
            $oaddres->filled['address_type'] = 'Billing';
            $oaddres->saveField();
            $id_default_address = $oaddres->latest_id;

            $id_tech_address = $id_default_address;
            $id_reg_address = $id_default_address;
            $id_admin_address = $id_default_address;
            $id_billing_address = $id_default_address;
        } elseif($create_type =='REGISTRANT') {
            $oaddres->validateFields($post_regs);
            $oaddres->filled['address_type'] = 'Registrant';
            $oaddres->filled['user_id'] = $user_id;
            $oaddres->saveField();
            $id_reg_address = $oaddres->latest_id;
            $id_admin_address = $id_reg_address;
            $id_tech_address = $id_reg_address;
            $id_billing_address = $id_reg_address;

            if($create_admin ===true) {
                $oaddres->validateFields($post_admins);
                $oaddres->filled['address_type'] = 'Administrator';
                $oaddres->filled['user_id'] = $user_id;
                $oaddres->saveField();
                $id_admin_address = $oaddres->latest_id;
            }

            if($create_tech ===true) {
                $oaddres->validateFields($post_techs);
                $oaddres->filled['address_type'] = 'Technical';
                $oaddres->filled['user_id'] = $user_id;
                $oaddres->saveField();
                $id_tech_address = $oaddres->latest_id;
            }

            if($create_billing ===true) {
                $oaddres->validateFields($post_billings);
                $oaddres->filled['address_type'] = 'Billing';
                $oaddres->filled['user_id'] = $user_id;
                $oaddres->saveField();
                $id_billing_address = $oaddres->latest_id;
            }
        } elseif($create_type =='DEFAULTSELECTED') {
            $id_reg_address = $id_existing_default_address;
            $id_admin_address = $id_existing_default_address;
            $id_tech_address = $id_existing_default_address;
            $id_billing_address = $id_existing_default_address;
        } elseif($create_type =='REGISTRANTCREATE') {
            $oaddres->validateFields($post_regs);
            $oaddres->filled['address_type'] = 'Registrant';
            $oaddres->filled['user_id'] = $user_id;
            $oaddres->saveField();
            $id_reg_address = $oaddres->latest_id;
            $id_admin_address = $id_reg_address;
            $id_tech_address = $id_reg_address;
            $id_billing_address = $id_reg_address;

            if($create_admin ===true) {
                $oaddres->validateFields($post_admins);
                $oaddres->filled['address_type'] = 'Administrator';
                $oaddres->filled['user_id'] = $user_id;
                $oaddres->saveField();
                $id_admin_address = $oaddres->latest_id;
            } else {
                if($id_existing_admin_address >0) {
                    $id_admin_address = $id_existing_admin_address;
                }
            }

            if($create_tech ===true) {
                $oaddres->validateFields($post_techs);
                $oaddres->filled['address_type'] = 'Technical';
                $oaddres->filled['user_id'] = $user_id;
                $oaddres->saveField();
                $id_tech_address = $oaddres->latest_id;
            } else {
                if($id_existing_tech_address >0) {
                    $id_tech_address = $id_existing_tech_address;
                }
            }

            if($create_billing ===true) {
                $oaddres->validateFields($post_billings);
                $oaddres->filled['address_type'] = 'Billing';
                $oaddres->filled['user_id'] = $user_id;
                $oaddres->saveField();
                $id_billing_address = $oaddres->latest_id;
            } else {
                if($id_existing_billing_address >0) {
                    $id_billing_address = $id_existing_billing_address;
                }
            }
        } elseif($create_type =='REGISTRANTSELECT') {
            $id_reg_address = $id_existing_reg_address;
            $id_admin_address = $id_reg_address;
            $id_tech_address = $id_reg_address;
            $id_billing_address = $id_reg_address;

            if($create_admin ===true) {
                $oaddres->validateFields($post_admins);
                $oaddres->filled['address_type'] = 'Administrator';
                $oaddres->filled['user_id'] = $user_id;
                $oaddres->saveField();
                $id_admin_address = $oaddres->latest_id;
            } else {
                if($id_existing_admin_address >0) {
                    $id_admin_address = $id_existing_admin_address;
                }
            }

            if($create_tech ===true) {
                $oaddres->validateFields($post_techs);
                $oaddres->filled['address_type'] = 'Technical';
                $oaddres->saveField();
                $id_tech_address = $oaddres->latest_id;
            } else {
                if($id_existing_tech_address >0) {
                    $id_tech_address = $id_existing_tech_address;
                }
            }

            if($create_billing ===true) {
                $oaddres->validateFields($post_billings);

                $oaddres->filled['address_type'] = 'Billing';
                $oaddres->filled['user_id'] = $user_id;
                $oaddres->saveField();
                $id_billing_address = $oaddres->latest_id;
            } else {
                if($id_existing_billing_address >0) {
                    $id_billing_address = $id_existing_billing_address;
                }
            }
        }



        $domain_args =array('user_id'=>$user_id, 'id_reg_address'=>$id_default_address, 'id_admin_address'=>$id_admin_address, 'id_tech_address'=>$id_tech_address, 'id_billing_address'=>$id_billing_address, 'name'=>$domain, 'status'=>'Pending',  'price'=>$price, 'domain_state'=>$domain_type, 'first_years'=>$domain_years, 'current_years'=>$domain_years, 'created_at'=>date('Y-m-d H:i:s'));




        $domaino = new APHDomain();
        $domaino->validateFields($domain_args);
        $domaino->saveField();
        $id_domain = $domaino->latest_id;

        $reference = 'DHPO'.APHTools::codeGenerator(16);
        $payment_reference = 'DHPINV'.APHTools::codeGenerator(14);



        $args = array('user_id'=>$user_id, 'id_domain'=>$id_domain, 'id_plan'=>$hosting_plan, 'id_currency'=>2, 'app_domain'=>$domain, 'order_total'=>$total_ng, 'default_total'=>$total, 'reference'=>$reference, 'created_at'=>date('Y-m-d H:i:s'));
        $ordero = new APHOrder();
        $ordero->validateFields($args);
        $ordero->saveField();
        $order= $ordero->getLatest();


        $ostack = new APHPaystack();

        $ocustomer = new APHCustomer();
        $excustomer = $ocustomer->userFirst($user_id);

        if($ocustomer->checkIfUserHas($user_id)) {
            $customer_code = $excustomer->customer_code;
        } else {
            $customer_code = $ostack->createCustomer($authuser, $phone);
        }



        $invoice_args = array('user_id'=>$user_id, 'id_order'=>$order->id_order, 'invoice_amount'=>$total_ng, 'default_amount'=>$total, 'status'=>'Unpaid','paid_amount'=>0.00, 'reference'=>$payment_reference, 'created_at'=>date('Y-m-d H:i:s'));

        $i_instance = new APHInvoice();
        $i_instance->validateFields($invoice_args);
        $i_instance->saveField();
        $invoice= $i_instance->getLatest();

        if(!is_object($invoice) || (int) $invoice->id_invoice ==0) {
            APHTools::displayError('Could not generate payable invoice for this order, try again, if this issue persist, please contact support');
        }


        if($payment_option =='Paystack') {
            $status = $ostack->initiatePayment($invoice, $authuser->user_email);
            if($status ===true) {
                $invoice = $i_instance->getById($invoice->id_invoice);
                if(is_object($invoice) && $invoice->payment_url !='') {
                    APHTools::ajaxReport('OK', 'success', '', $invoice->payment_url);
                }
            }

            APHTools::displayError('Could not generate payment information, try other payment options');
        } elseif($payment_option =='Transfer') {
            $contents = array('total'=>$total_ng, 'order_number'=>'#'.$order->id_order, 'reference'=>$payment_reference);
            APHTools::ajaxReport('OK', 'success', $contents);
        }

        APHTools::displayError('Could not process order, try again later');
    }


    public function showOrderSummary()
    {
        $domain = APHTools::getValue('domain');
        $id_plan = (int) APHTools::getValue('hosting');
        $domain_type = APHTools::getValue('domaintype');

        if ($domain =='') {
            APHTools::displayError('Domain name is empty, you have to fill in domain name');
        }

        $ext = (new APHDomainPrice())->getFullPrice($domain);
        if (!is_object($ext)) {
            APHTools::displayError('Invalid domain price result');
        }


        $plan = (new APHPlan())->getById($id_plan);

        if (!is_object($plan)) {
            APHTools::displayError('Select App hosting package.');
        }

        $monthly = $plan->monthly_price;
        $yearly = $plan->yearly_price;


        if ($domain_type =='Existing') {
            $price = 0;
        } elseif ($domain_type =='Transfer') {
            $price =$ext->transfer;
        } elseif ($domain_type =='Register') {
            $price =$ext->registration;
        }

        $monthly_total = $price + $monthly;
        $yearly_total =  $price + $yearly;
        ob_start();
        ?>
         <table class="table table-striped">
        <thead><th> Package</th> <th> Price </th> <th> Total </th></thead>
         <tbody>
            <tr> <td> <strong> Domain: </strong> <span><?php echo $domain; ?> </span>  </td> 
                <td class="possible_error_line"> <span> <?php echo APHTools::displayNg($price); ?> </span>  /year <input data-domainprice="<?php echo $price; ?>" type="number" id="number_of_domain_years" name="number_of_domain_years" class="domain-years-input" value="1">  </td> <td> <span class="domain_total_span"><?php echo APHTools::displayNg($price); ?> </span> </td> </tr>
                                                    
           <tr class="monthly_price_checkout"> <td> <strong>App Hosting: </strong> <span> <?php echo $plan->name; ?> </span>  </td> <td> <span> <?php echo APHTools::displayNg($monthly); ?> </span> /Month  </td> 
                                                    <td> <span> <?php echo APHTools::displayNg($monthly); ?></span> </td> </tr>
                                                    

          <tr class="monthly_price_checkout"> <td> <strong> Total: </strong> </td> <td> </td> <td> <span class="total_to_be_paid monthly_total_display"><?php echo APHTools::displayNg($monthly_total); ?></span> </td></tr>

          <tr class="yearly_price_checkout display_none"> <td> <strong>App Hosting: </strong> <span> <?php echo $plan->name; ?> </span>  </td> <td> <span> <?php echo APHTools::displayNg($yearly); ?> </span>  </td> 
                                                    <td> <span><?php echo APHTools::displayNg($yearly); ?> </span> </td> </tr>


         <tr class="yearly_price_checkout display_none"> <td> <strong>Total:</strong></td> <td> </td> <td><span class="total_to_be_paid yearly_total_display"> <?php echo APHTools::displayNg($yearly_total); ?> </span> </td></tr>
                                                </tbody>
                                            </table>
        <?php
        $display = ob_get_contents();
        ob_clean();

        APHTools::ajaxReport('OK', 'Checkout details loaded successfully', $display);
    }



    public function domainRegistrationShow()
    {
        $domain = APHTools::getValue('domain_name');
        $domain_type = APHTools::getValue('domain_type');
        $a_instance = new APHAddress();

        if ($domain =='') {
            APHTools::displayError('Domain name is empty, you have to fill in domain name');
        }

        $ext = (new APHDomainPrice())->getFullPrice($domain);
        if (!is_object($ext)) {
            APHTools::displayError('Invalid domain price result');
        }

        if ($domain_type =='Transfer') {
            $price =$ext->transfer;
        } elseif ($domain_type =='Register') {
            $price =$ext->registration;
        }






        $myaddresses = $a_instance->getMyAddresses($this->authuser->ID);
        $countries = (new APHCountry())->getActives();

        ob_start();
        ?>
         <div class="containing_all_registrant_information">

          <div class="card card-flush">
            <div class="card-header">
                <div class="card-title">
                            <h4 class="title-top-forms">Domain Registration Information</h4>
                </div>
               
            </div>

            <div class="card-body">
    <?php if($domain_type =='Transfer'): ?>
    <div id="domain_transfer_details">
    <h4 class="title-top-forms">Domain Transfer Additional Information</h4>
     <div class="row mb-3 ">
        <div class="col-sm-12 possible_error_line">
            <div class="form-group">
                <label for="transfer_code">Domain Epp Code</label>
                <input type="text" name="transfer_code" class="form-control form-control-lg form-control-solid"/>
            </div>
        </div>
         
    </div>

     <div class="row mb-3 ">
        <div class="col-sm-12 possible_error_line">
            <div class="form-group">
                <label for="transfer_note">Transfer Note (optional)</label>
                <input type="text" name="transfer_note" class="form-control form-control-lg form-control-solid"/>
            </div>
        </div>
         
    </div>
    
</div>

    <?php endif; ?>


       <?php
                 if(count($myaddresses) >0) :?>
                 
                 <div class="form-group">
                     <label class="label_showcase" for="selected_registrant_address"> Select From Existing address</label>
                     <select class="form-control" id="ap_selected_registrant_address" name="selected_registrant_address">
                         <option value="">Select from existing address</option>
                          <?php foreach($myaddresses as $ad): ?>
                            <option value="<?php echo $ad->id_address; ?>"> <?php echo $ad->address_name.' | '.$ad->name; ?> </option>

                          <?php endforeach; ?>

                     </select>
                 </div>
                 
                         
                 <?php endif; ?>



    <div id="ap_address_registrant_complete" class="">

      <h5 class="select_or_message"> Or fill in registrant address information below</h5>
   <div class="row mb-3 ">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_email">Email</label>
                                                        <input type="email" name="registrant_email" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                 
                                            </div>

                                             <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_firstname">First Name</label>
                                                        <input type="text" name="registrant_firstname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="registrant_lastname">Last Name</label>
                                                        <input type="text" name="registrant_lastname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_address">Address</label>
                                                        <input type="text" name="registrant_address" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                 
                                                  <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_phone">Phone</label>
                                                        <input type="text" name="registrant_phone" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>


                                                
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_city">City </label>
                                                        <input type="text" name="registrant_city" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="registrant_postal_code">Postal Code</label>
                                                        <input type="text" name="registrant_postal_code" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                        <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_province_or_state">State/Province </label>
                                                        <input type="text" name="registrant_province_or_state" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="registrant_id_country">Country</label>
                                                        
                                                        
                                                        <select name="registrant_id_country" class="form-control form-control-lg form-control-solid"> 
                                                            <?php
                                                        if(count($countries) >0):
                                                            foreach($countries as $country): ?>
                                                            <option value="<?php echo $country->id_country; ?>" <?php if($country->name =='Nigeria') {
                                                                echo 'selected';
                                                            } ?>> <?php echo $country->name; ?> </option>

                                                        <?php
                                                            endforeach;
                                                        endif;
        ?>
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                           <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="registrant_company_name">Company Name (optional) </label>
                                                        <input type="text" name="registrant_company_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="registrant_address_name">Give this address a name</label>
                                                        <input type="text" name="registrant_address_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
         <table class="table table-striped">
        <thead><th> Package</th> <th> Price </th> <th> Total </th></thead>
         <tbody>
            <tr> <td> <strong> Domain: </strong> <span><?php echo $domain; ?> </span>  </td> 
                <td class="possible_error_line"> <span> <?php echo APHTools::displayNg($price); ?> </span>  /year <input data-domainprice="<?php echo $price; ?>" type="number" id="number_of_domain_years" name="number_of_domain_years" class="domain-years-input" value="1">  </td> <td> <span class="domain_total_span"><?php echo APHTools::displayNg($price); ?> </span> </td> </tr>
                                                    
          

          <tr class="monthly_price_checkout"> <td> <strong> Total: </strong> </td> <td> </td> <td> <span class="total_to_be_paid monthly_total_display"><?php echo APHTools::displayNg($price); ?></span> </td></tr>

          
                                                </tbody>
                                            </table>

                                        <div class="ap_holding_payment_section_checkout">
                                          

                                                                            


                                <div class="row mb-2 possible_error_line" data-kt-buttons="true">
                                                <!--begin::Col-->
                                                <div class="col-6">
                                                    <!--begin::Option-->
                                                    <label class="ap_select_payment_option_checkout btn btn-outline btn-outline-dashed btn-active-light-primary h-54 w-100">
                                                         <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 157 28"><defs></defs><g><path d="M22.32 2.663H1.306C.594 2.663 0 3.263 0 3.985v2.37c0 .74.594 1.324 1.307 1.324h21.012c.73 0 1.307-.602 1.324-1.323V4.002c0-.738-.594-1.34-1.323-1.34zm0 13.192H1.306a1.3 1.3 0 00-.924.388 1.33 1.33 0 00-.383.935v2.37c0 .74.594 1.323 1.307 1.323h21.012c.73 0 1.307-.584 1.324-1.322v-2.371c0-.739-.594-1.323-1.323-1.323zm-9.183 6.58H1.307c-.347 0-.68.139-.924.387a1.33 1.33 0 00-.383.935v2.37c0 .74.594 1.323 1.307 1.323H13.12c.73 0 1.307-.6 1.307-1.322v-2.371a1.29 1.29 0 00-1.29-1.323zM23.643 9.258H1.307c-.347 0-.68.14-.924.387a1.33 1.33 0 00-.383.936v2.37c0 .739.594 1.323 1.307 1.323h22.32c.73 0 1.306-.601 1.306-1.323v-2.37a1.301 1.301 0 00-1.29-1.323z" fill="#00C3F7"></path><path d="M48.101 8.005a6.927 6.927 0 00-2.274-1.563 7.041 7.041 0 00-2.716-.55 5.767 5.767 0 00-2.63.567c-.55.263-1.046.63-1.46 1.082V7.13a.876.876 0 00-.22-.567.721.721 0 00-.56-.258h-2.937a.697.697 0 00-.56.258.796.796 0 00-.221.567v19.566c0 .206.085.412.22.566a.776.776 0 00.56.224h2.971c.204 0 .39-.086.543-.224a.7.7 0 00.238-.566v-6.683c.424.464.967.808 1.561 1.014.781.292 1.596.43 2.427.43.95 0 1.884-.173 2.75-.55a6.859 6.859 0 002.308-1.58 7.45 7.45 0 001.562-2.457 8.34 8.34 0 00.577-3.213 8.761 8.761 0 00-.577-3.229A7.775 7.775 0 0048.1 8.005zm-2.681 7.077a3.33 3.33 0 01-.696 1.117 3.177 3.177 0 01-2.36 1.013c-.458 0-.899-.086-1.306-.275a3.324 3.324 0 01-1.07-.738 3.673 3.673 0 01-.713-1.117 3.837 3.837 0 010-2.748c.153-.412.408-.79.713-1.1a3.576 3.576 0 011.07-.755 2.888 2.888 0 011.306-.275c.459 0 .9.086 1.324.274.39.19.747.43 1.053.74.305.326.526.686.696 1.099a3.976 3.976 0 01-.017 2.765zm20.808-8.778h-2.953a.728.728 0 00-.543.24.823.823 0 00-.237.585v.36a4.143 4.143 0 00-1.341-1.03 5.652 5.652 0 00-2.58-.567 7.222 7.222 0 00-5.075 2.096 7.733 7.733 0 00-1.63 2.456 8.036 8.036 0 00-.61 3.23 8.15 8.15 0 00.61 3.23 7.88 7.88 0 001.613 2.456 6.959 6.959 0 005.058 2.112c.9.018 1.782-.171 2.597-.567.509-.257.984-.6 1.358-1.03v.395c0 .206.084.412.237.567.153.137.34.223.543.223h2.953a.855.855 0 00.56-.223.768.768 0 00.221-.567V7.129a.796.796 0 00-.22-.567.697.697 0 00-.56-.258zm-3.988 8.761a3.33 3.33 0 01-.696 1.117 3.83 3.83 0 01-1.052.755c-.832.378-1.8.378-2.631 0a3.575 3.575 0 01-1.07-.755 3.326 3.326 0 01-.695-1.117 3.976 3.976 0 010-2.731c.152-.412.39-.773.696-1.1.305-.309.661-.566 1.069-.755a3.194 3.194 0 012.63 0c.391.189.748.429 1.053.738.289.327.526.687.696 1.1.34.893.34 1.872 0 2.748zm33.437-1.77a4.794 4.794 0 00-1.443-.875 10.054 10.054 0 00-1.731-.516l-2.258-.446c-.577-.103-.984-.258-1.205-.447a.712.712 0 01-.305-.567c0-.24.136-.446.424-.618.39-.206.815-.31 1.256-.275.577 0 1.154.12 1.68.343.51.224 1.019.482 1.477.79.662.413 1.222.344 1.612-.12l1.087-1.236c.203-.207.322-.481.34-.773a1.06 1.06 0 00-.408-.773c-.459-.395-1.188-.825-2.156-1.237-.967-.412-2.19-.636-3.632-.636a8.343 8.343 0 00-2.597.378 6.273 6.273 0 00-1.986 1.03 4.552 4.552 0 00-1.273 1.564 4.417 4.417 0 00-.441 1.907c0 1.22.373 2.216 1.103 2.954.73.739 1.698 1.22 2.903 1.46l2.342.516c.51.086 1.018.24 1.494.464.254.103.424.36.424.652 0 .258-.136.498-.424.705-.289.206-.764.343-1.375.343a4.051 4.051 0 01-1.85-.412 6.792 6.792 0 01-1.51-.996 2.037 2.037 0 00-.68-.378c-.271-.086-.594 0-.95.292l-1.29.979a1.147 1.147 0 00-.458 1.134c.067.43.424.858 1.086 1.357a9.543 9.543 0 005.516 1.632 8.993 8.993 0 002.699-.378 6.83 6.83 0 002.087-1.048c.56-.43 1.036-.98 1.358-1.615a4.543 4.543 0 00.475-2.01 4.168 4.168 0 00-.373-1.82 4.638 4.638 0 00-1.018-1.323zm12.899 3.574a.857.857 0 00-.645-.43c-.271 0-.543.086-.764.24a2.43 2.43 0 01-1.205.396c-.136 0-.288-.017-.424-.052a.777.777 0 01-.39-.206 1.43 1.43 0 01-.323-.446 2.092 2.092 0 01-.136-.79v-5.36h3.836a.86.86 0 00.594-.258.77.77 0 00.255-.567V7.13a.773.773 0 00-.255-.584.833.833 0 00-.577-.24h-3.836v-3.66a.736.736 0 00-.237-.584.814.814 0 00-.544-.223h-2.987a.817.817 0 00-.577.223.838.838 0 00-.254.584v3.66h-1.698a.697.697 0 00-.56.257.876.876 0 00-.22.567v2.267c0 .206.084.413.22.567a.65.65 0 00.56.258h1.698v6.373a5.14 5.14 0 00.441 2.199 4.575 4.575 0 001.137 1.477c.475.395 1.035.67 1.612.842a6.125 6.125 0 001.851.275 7.73 7.73 0 002.427-.396 4.802 4.802 0 001.918-1.202.999.999 0 00.101-1.271l-1.018-1.65zm16.175-10.565h-2.953a.728.728 0 00-.543.24.822.822 0 00-.238.585v.36a4.13 4.13 0 00-1.341-1.03 5.67 5.67 0 00-2.596-.567 7.152 7.152 0 00-5.058 2.096 7.468 7.468 0 00-1.63 2.456 8.017 8.017 0 00-.611 3.212 8.156 8.156 0 00.611 3.23c.374.91.934 1.752 1.613 2.456a7.006 7.006 0 005.041 2.13 5.884 5.884 0 002.596-.55c.51-.257.985-.6 1.358-1.03v.378c.002.21.084.41.23.557a.783.783 0 00.551.233h2.97a.78.78 0 00.781-.773V7.13a.795.795 0 00-.221-.567.696.696 0 00-.56-.258zm-3.988 8.761a3.34 3.34 0 01-.696 1.117 3.83 3.83 0 01-1.053.755 2.907 2.907 0 01-1.323.275c-.459 0-.9-.103-1.307-.275a3.576 3.576 0 01-1.07-.755 3.34 3.34 0 01-.696-1.117 3.982 3.982 0 010-2.731 3.27 3.27 0 01.696-1.1c.306-.309.662-.566 1.07-.755a3.077 3.077 0 011.307-.275c.458 0 .899.086 1.323.274.391.19.747.43 1.053.74.305.326.543.686.696 1.099a3.67 3.67 0 010 2.748zm20.198 1.615l-1.698-1.306c-.322-.257-.628-.326-.899-.223a1.82 1.82 0 00-.628.447 6.03 6.03 0 01-1.29 1.168c-.509.292-1.07.43-1.647.395a3.165 3.165 0 01-1.855-.575 3.224 3.224 0 01-1.183-1.555 4.046 4.046 0 01-.237-1.34c0-.464.067-.928.237-1.374.153-.413.374-.79.679-1.1.306-.309.662-.567 1.052-.739a3.175 3.175 0 011.324-.291 3.06 3.06 0 011.647.412 5.61 5.61 0 011.29 1.168c.169.189.373.343.611.447.271.103.577.034.882-.224l1.698-1.288c.203-.138.373-.344.441-.584a.923.923 0 00-.068-.79 7.35 7.35 0 00-2.614-2.457c-1.12-.635-2.461-.962-3.955-.962a8.163 8.163 0 00-3.072.601 7.65 7.65 0 00-2.495 1.65 7.357 7.357 0 00-1.663 2.473 8.154 8.154 0 000 6.133c.39.927.95 1.769 1.663 2.456a7.876 7.876 0 005.567 2.25c1.494 0 2.835-.326 3.955-.962a7.307 7.307 0 002.631-2.473.886.886 0 00.068-.773 1.167 1.167 0 00-.441-.584zm15.716 3.057l-4.667-6.854 3.989-5.273a.978.978 0 00.169-.86c-.068-.205-.254-.429-.746-.429h-3.157a1.39 1.39 0 00-.527.12 1.058 1.058 0 00-.458.447l-3.191 4.467h-.764V.79a.794.794 0 00-.22-.567.78.78 0 00-.56-.223h-2.954a.856.856 0 00-.56.223.72.72 0 00-.237.567v19.48c0 .223.084.43.237.567a.778.778 0 00.56.223h2.954a.856.856 0 00.56-.223.794.794 0 00.22-.567v-5.153h.849l3.479 5.342c.204.378.595.618 1.019.618h3.31c.509 0 .712-.24.797-.446a.933.933 0 00-.102-.894zM83.015 6.304h-3.31a.852.852 0 00-.662.258 1.178 1.178 0 00-.305.55l-2.445 9.104H75.7l-2.613-9.104a1.54 1.54 0 00-.255-.533.756.756 0 00-.594-.275h-3.429c-.44 0-.712.138-.831.43-.085.257-.085.55 0 .807l4.192 12.798c.068.189.17.378.323.515.17.155.39.24.627.223h1.766l-.153.413-.39 1.185c-.12.36-.34.687-.645.927a1.58 1.58 0 01-.985.327c-.305 0-.61-.069-.882-.19a3.618 3.618 0 01-.781-.463 1.29 1.29 0 00-.747-.24h-.034a.908.908 0 00-.747.463l-1.052 1.546c-.424.67-.187 1.1.085 1.34a5.36 5.36 0 001.952 1.151 7.679 7.679 0 002.495.412c1.51 0 2.783-.412 3.75-1.236a7.067 7.067 0 002.122-3.333l4.855-15.838c.102-.275.119-.567.017-.842-.085-.189-.272-.395-.73-.395z" fill="#011B33"></path></g></svg>
                                                        <input type="radio" class="btn-check" name="payment_option_checkout" value="Paystack" />
                                                        <span class="fw-bold">Credit Card/Debit Card/</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>

                                                 <div class="col-6">
                                                    <!--begin::Option-->
                                                    <label class="ap_select_payment_option_checkout btn btn-outline btn-outline-dashed btn-active-light-primary h-54 w-100">
                                                    <?xml version="1.0" encoding="iso-8859-1"?>
                                                    <svg version="1.1" style="height:70px;" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                                         viewBox="0 0 512 512" xml:space="preserve">
                                                    <circle style="fill:#88C5CC;" cx="256" cy="256" r="256"/>
                                                    <rect x="124" y="200" style="fill:#406A80;" width="264" height="232"/>
                                                    <rect x="108" y="216" style="fill:#E6E6E6;" width="64" height="200"/>
                                                    <g>
                                                        <rect x="116" y="216" style="fill:#CCCCCC;" width="8" height="200"/>
                                                        <rect x="136" y="216" style="fill:#CCCCCC;" width="8" height="200"/>
                                                        <rect x="156" y="216" style="fill:#CCCCCC;" width="8" height="200"/>
                                                    </g>
                                                    <g>
                                                        <rect x="340" y="216" style="fill:#E6E6E6;" width="64" height="200"/>
                                                        <path style="fill:#E6E6E6;" d="M40,512v-32c0-4.4,3.6-8,8-8h416c4.4,0,8,3.6,8,8v32H40z"/>
                                                        <path style="fill:#E6E6E6;" d="M64,472v-32c0-4.4,3.6-8,8-8h368c4.4,0,8,3.6,8,8v32H64z"/>
                                                    </g>
                                                    <path style="fill:#F5F5F5;" d="M433.656,170.344l-176-120C256.096,48.784,254.048,48,252,48s-4.096,0.784-5.656,2.344l-176,120
                                                        c-1.548,1.544-2.328,3.628-2.344,5.656c-0.016,2.068,0.764,4.08,2.344,5.656C71.908,183.22,73.952,184,76,184h176h176
                                                        c2.048,0,4.092-0.78,5.656-2.344c1.58-1.58,2.36-3.588,2.344-5.656C435.984,173.972,435.204,171.888,433.656,170.344z"/>
                                                    <g>
                                                        <polygon style="fill:#CCCCCC;" points="102.184,168 252,65.852 401.816,168   "/>
                                                        <path style="fill:#CCCCCC;" d="M452,192c0,4.4-3.6,8-8,8H60c-4.4,0-8-3.6-8-8l0,0c0-4.4,3.6-8,8-8h384C448.4,184,452,187.6,452,192
                                                            L452,192z"/>
                                                    </g>
                                                    <rect x="224" y="216" style="fill:#E6E6E6;" width="64" height="200"/>
                                                    <g>
                                                        <rect x="232" y="216" style="fill:#CCCCCC;" width="8" height="200"/>
                                                        <rect x="252" y="216" style="fill:#CCCCCC;" width="8" height="200"/>
                                                        <rect x="272" y="216" style="fill:#CCCCCC;" width="8" height="200"/>
                                                        <rect x="348" y="216" style="fill:#CCCCCC;" width="8" height="200"/>
                                                        <rect x="368" y="216" style="fill:#CCCCCC;" width="8" height="200"/>
                                                        <rect x="388" y="216" style="fill:#CCCCCC;" width="8" height="200"/>
                                                    </g>
                                                    <g>
                                                        <path style="fill:#F5F5F5;" d="M180,424c0,4.4-3.6,8-8,8h-64c-4.4,0-8-3.6-8-8l0,0c0-4.4,3.6-8,8-8h64C176.4,416,180,419.6,180,424
                                                            L180,424z"/>
                                                        <path style="fill:#F5F5F5;" d="M180,208c0,4.4-3.6,8-8,8h-64c-4.4,0-8-3.6-8-8l0,0c0-4.4,3.6-8,8-8h64C176.4,200,180,203.6,180,208
                                                            L180,208z"/>
                                                        <path style="fill:#F5F5F5;" d="M296,424c0,4.4-3.6,8-8,8h-64c-4.4,0-8-3.6-8-8l0,0c0-4.4,3.6-8,8-8h64C292.4,416,296,419.6,296,424
                                                            L296,424z"/>
                                                        <path style="fill:#F5F5F5;" d="M296,208c0,4.4-3.6,8-8,8h-64c-4.4,0-8-3.6-8-8l0,0c0-4.4,3.6-8,8-8h64C292.4,200,296,203.6,296,208
                                                            L296,208z"/>
                                                        <path style="fill:#F5F5F5;" d="M412,424c0,4.4-3.6,8-8,8h-64c-4.4,0-8-3.6-8-8l0,0c0-4.4,3.6-8,8-8h64C408.4,416,412,419.6,412,424
                                                            L412,424z"/>
                                                        <path style="fill:#F5F5F5;" d="M412,208c0,4.4-3.6,8-8,8h-64c-4.4,0-8-3.6-8-8l0,0c0-4.4,3.6-8,8-8h64C408.4,200,412,203.6,412,208
                                                            L412,208z"/>
                                                    </g>
                                                    <rect x="64" y="468" style="fill:#CCCCCC;" width="384" height="4"/>
                                                    <g>
                                                        <path style="fill:#2179A6;" d="M252,140c-6.616,0-12-5.384-12-12c0-2.208,1.792-4,4-4s4,1.792,4,4c0,2.204,1.796,4,4,4s4-1.796,4-4
                                                            s-1.796-4-4-4c-6.616,0-12-5.384-12-12s5.384-12,12-12s12,5.384,12,12c0,2.208-1.792,4-4,4s-4-1.792-4-4c0-2.204-1.796-4-4-4
                                                            s-4,1.796-4,4s1.796,4,4,4c6.616,0,12,5.384,12,12S258.616,140,252,140z"/>
                                                        <path style="fill:#2179A6;" d="M252,108c-2.208,0-4-1.792-4-4v-8c0-2.208,1.792-4,4-4s4,1.792,4,4v8
                                                            C256,106.208,254.208,108,252,108z"/>
                                                        <path style="fill:#2179A6;" d="M252,148c-2.208,0-4-1.792-4-4v-8c0-2.208,1.792-4,4-4s4,1.792,4,4v8
                                                            C256,146.208,254.208,148,252,148z"/>
                                                    </g>
                                                    </svg>
                                                    <input type="radio" class="btn-check" name="payment_option_checkout" value="Transfer" />
                                                        <span class="fw-bold">Bank Transfer</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>


                                        </div>

                                       </div>
                                   </div>
                               </div>


                                </div>
        <?php
        $display = ob_get_contents();
        ob_clean();

        APHTools::ajaxReport('OK', 'Checkout details loaded successfully', $display);
    }
}
