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

class APHNonPriv
{
    public $return_url;
    public function noPrivActionsBaseField()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHTools.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHTicket.php';

        $request_token = APHTools::getValue('request_token');

        $this->return_url = home_url();




        if ($request_token === 'APCUKBTDRSXKVPKEAGYRUVXCUCEXPQSXYGQLUKJVFHZELUEHQKDCALJQKRBVSOLL') {
            $this->processAccountLogin();
            exit;
        }

        if ($request_token === 'APVXIMJWFRUQOBCPKWYFAAAUNWCLRLHHQTQMXLIXBSGCEUAQDQAHKLEZMBZTNGON') {
            $this->processAccountCreate();
            exit;
        }

        if ($request_token === 'APNLCUMUVHHXUASYWBEWOIOTRZBKVNJPCQIQZGEMVXPQHIKEPHJPVALIZMJRNIFL') {
            $this->processAccountRecovery();
            exit;
        }

        if ($request_token == '7ED9D5326C6C4367815CEFFB76FAFFEC') {
            $this->checkLoginProceed();
            exit;
        }
        if ($request_token == '5AF4422F1ECA47FDB33B5920B5677100') {
            $this->generateBillPaymentURL();
            exit;
        }

        if ($request_token === 'FFAD7054638B41FAA65C6A012C280B70') {
            $this->loadListofStates();
            exit;
        }

        if ($request_token === '86512A5F63404A94850EAB5BDAE85188') {
            $this->loadNetworksByCountry();
            exit;
        }

        if ($request_token === '609457CEFA424FFA8D3A9515154F2977') {
            $this->submitConversionRequest();
            exit;
        }

        if ($request_token ==='APERBKEYTTXDAPIRLCSYVQFVEIQXMFWITSLEKICEDJXDXVZZJSAZAJABAZHWZBHH') {
            $this->processContactPageForm();
            exit;
        }
    }

    public function processContactPageForm()
    {
        $email = APHTools::getValue('email');
        $fullname = APHTools::getValue('fullname');
        $subject = APHTools::getValue('subject');
        $message = APHTools::getValue('message');
        $t_instance = new APHTicket();
        if ($email =='') {
            APHTools::displayError('Email is required, enter a valid email');
        }
        if (!APHTools::isEmail($email)) {
            APHTools::displayError('Email is required, enter a valid email');
        }
        if ($fullname =='') {
            APHTools::displayError('Your firstname and last name is required. Fill in the name field');
        }

        if ($subject =='') {
            APHTools::displayError('Subject / Title is required. Fill in the subject field');
        }

        if ($message =='') {
            APHTools::displayError('Your message is required. Let us know why you want to contact us. Brief information about your request is required.');
        }

        $content = array('email'=>$email, 'subject'=>$subject, 'message'=>$message, 'fullname'=>$fullname, 'status'=>'Open', 'reference'=>'DHPT'.APHTools::codeGenerator(11), 'department'=>'External', 'created_at'=>date('Y-m-d H:i:s'));

        $t_instance->filled = $content;
        $t_instance->saveField();
        $ticket =  $t_instance->getLatest();

        if (is_object($ticket) && isset($ticket->id_ticket)) {
            APHTools::displaySuccess('Contact message sent to support successfully. We will get back to you soon');
        }
    }



    public function processCheckoutURL()
    {
        $waveorder = new AppHost_APHOrder();

        $currency_iso = FWTools::getIsoByID($this->thecart->id_currency);

        $total       = (float) $this->thecart->getOrderTotal(true, Cart::BOTH);
        $wavepayment = new AppHost_APHPayment($this->return_url);

        $order_obj = $waveorder->getObjectByCart($this->thecart->id);
        if (Validate::isLoadedObject($order_obj)) {
            if ($order_obj->payment_url != '' && $order_obj->status == 'Pending') {
                return array('status' => 'OK', 'url' => $order_obj->payment_url, 'message' => esc_html__('Redirecting to the payment gateway website to complete your order', 'apphosting'));
            }

            // attempt
            $response = $wavepayment->getPaymentURL($this->thecart, $order_obj->payment_reference, $total, $currency_iso, $this->customer);
        } else {
            $reference = Tools::strtoupper(Tools::passwdGen(6) . uniqid() . $this->thecart->id);
            $order_obj = $waveorder->addReference($this->thecart, $reference);
            $response  = $wavepayment->getPaymentURL($this->thecart, $reference, $total, $currency_iso, $this->customer);
        }

        if (is_object($response)) {
            if ($response->status == 'success') {
                //
                $waveorder->updateURL($order_obj, $response);
                return array('status' => 'OK', 'url' => $response->data->link, 'message' => esc_html__('Redirecting to payment gateway to complete your order', 'apphosting'));
            }
            return false;
        }

        return false;
    }

    public function checkLoginProceed()
    {
        $bill_type = APHTools::getValue('bill_type');
        $country   = APHTools::getValue('bill_country');

        if (is_user_logged_in()) {
            $this->getBillDetails($bill_type, $country);
            wp_die();
        } else {
            if (get_option('FW_FWAVE_ALLOW_ANON_GUEST') ==1) {
                $anon     = (int) get_option('wg_theAnonymousJohn');
                $anonuser = get_user_by('ID', $anon);

                if (!is_object($anonuser)) {
                    $this->getLoginForm($bill_type, $country);
                    wp_die();
                } else {
                    $this->anonLogin($anonuser);
                    $this->getBillDetails($bill_type, $country);
                    wp_die();
                }
            } else {
                $this->getLoginForm($bill_type, $country);
                wp_die();
            }
        }
    }

    public function anonLogin($anonuser)
    {
        wp_set_current_user($anonuser->ID, $anonuser->user_login);
        wp_set_auth_cookie($anonuser->ID);
        do_action('wp_login', $anonuser->user_login, $anonuser);
    }
    public function getBillDetails($bill_type, $country, $message = '')
    {
        $wavepayment = new AppHost_APHPayment('');
        $vars        = $bill_type . '=1';

        if ($bill_type == 'biller') {
            $response = $wavepayment->getBillers();
        } else {
            $response = $wavepayment->getSpecificBills($vars);
        }

        if (is_array($response) || is_object($response)) {
            $contents = $this->getDisplay($response, $bill_type, $country, $message);
            echo json_encode(array('status' => 'OK', 'message' => esc_html__('Fill in your details and proceed', 'apphosting'), 'contents' => $contents));
            exit;
        } elseif ($response == 'error') {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('Could not complete this request, try again later', 'apphosting')));
            exit;
        } else {
            echo json_encode(array('status' => 'NK', 'message' => esc_html($response)));
            exit;
        }
    }

    public function getDisplay($data, $template, $country = '', $message = '')
    {
        return $this->$template($data, $template, $country, $message);
    }

    public function submitConversionRequest()
    {
        $country                                            = APHTools::getValue('country');
        list($biller_name, $biller_code, $item_code, $name) = explode('|', APHTools::getValue('biller_name'));
        $mobile_number                                      = trim(APHTools::getValue('mobile_number'));

        $customer = wp_get_current_user();

        if (!is_object($customer)) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('You need to be logged in to access this page, try again later', 'apphosting')));
            exit;
        }

        $points = (new AppHost_APHPoint())->pointBalance($customer->ID);
        $value  = AppHost_APHPoint::getPointValue($points);

        if ($value == 0) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('You do not have enough points to complete this request', 'apphosting')));
            exit;
        }

        $id_currency = AppHost_APHOrder::getCurrencyForOrder($country);

        if ((int) $id_currency == 0) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('The currency which determines the price of this item is not active on our store. Try again later or contact our support team', 'apphosting')));
            exit;
        }

        $currency = (new AppHost_APHCurrency())->getById($id_currency);
        if (!is_object($currency)) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('The currency which determines the price of this item is not properly loaded, contact support', 'apphosting')));
            exit;
        }

        if ($currency->active == 0) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('This currency is not active and reward conversion cannot continue, try again later', 'apphosting')));
            exit;
        }

        if ((int) $id_currency !== (int) get_option('FW_FWAVE_POINT_CURRENCY')) {
            $pointcurrency = (new AppHost_APHCurrency())->getById(get_option('FW_FWAVE_POINT_CURRENCY'));
            if (is_object($pointcurrency)) {
                echo json_encode(array('status' => 'NK', 'message' => sprintf(esc_html__('%s is the only supported currency for point conversion, select bill payment service in this currency', 'apphosting'), $pointcurrency->iso_code)));
                exit;
            }

            echo json_encode(array('status' => 'NK', 'message' => esc_html__('Cannot change the point currency. Select airtime from another country that is supported', 'apphosting')));
            exit;
        }

        if ((float) $points >= (float) get_option('FW_FWAVE_MIN_CONVERTABLE_POINT')) {
            //
            $comments = sprintf(esc_html__('Point to airtime converion Total Points: %d', 'apphosting'), $value);

            (new AppHost_APHPoint())->usePoint($customer->ID, $id_currency, $value, $points, $mobile_number, $biller_name, $country, $comments);

            echo json_encode(array('status' => 'OK', 'message' => esc_html__('Your reward points to airtime conversion has been submited for approval', 'apphosting')));
            exit;
        }

        echo json_encode(array('status' => 'NK', 'message' => esc_html__('Could not complete this request. Ensure your reward points is greater or equal to  ', 'apphosting') . get_option('FW_FWAVE_MIN_CONVERTABLE_POINT')));
        exit;
    }

    public function generateBillPaymentURL()
    {
        $country                                            = APHTools::getValue('biller_country');
        $bill_type                                          = APHTools::getValue('bill_type');
        $intent                                             = APHTools::getValue('intent');
        $amount                                             = (float) APHTools::getValue('amount');
        list($biller_name, $biller_code, $item_code, $name) = explode('|', APHTools::getValue('biller_name'));
        $customer_identifier                                = trim(APHTools::getValue('customer_identifier'));

        if ($customer_identifier == '' && $bill_type != 'biller') {
            if ($bill_type == 'airtime' || $bill_type == 'data_bundle') {
                echo json_encode(array('status' => 'NK', 'message' => esc_html__('Phone number  is required', 'apphosting')));
                exit;
            } elseif ($bill_type == 'cables') {
                echo json_encode(array('status' => 'NK', 'message' => esc_html__('Smart card number  is required', 'apphosting')));
                exit;
            } else {
                echo json_encode(array('status' => 'NK', 'message' => esc_html__('Customer number  is required', 'apphosting')));
                exit;
            }
        }

        if ($amount < 1) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('Enter a valid amount', 'apphosting')));
            exit;
        }

        $wavepayment = new AppHost_APHPayment('');
        $id_currency = AppHost_APHOrder::getCurrencyForOrder($country);

        if ((int) $id_currency == 0) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('The currency which determines the price of this item is not active on our store. Try again later or contact our support team', 'apphosting')));
            exit;
        }

        $currency = (new AppHost_APHCurrency())->getById($id_currency);
        if (!is_object($currency) || $currency->active == 0) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('The currency which determines the price of this item is not properly loaded, contact support', 'apphosting')));
            exit;
        }

        $customer = wp_get_current_user();

        if (!is_object($customer)) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('Invalid account selected for order, select a valid account', 'apphosting')));
            exit;
        }

        if ($bill_type != 'biller') {
            $response = $wavepayment->validateBill($item_code, $biller_code, $customer_identifier);

            if (!is_object($response)) {
                echo json_encode(array('status' => 'NK', 'message' => esc_html__('Could not validate this billing request ensure that the fields are properly filled', 'apphosting')));
                exit;
            }

            if ($response->status != 'success') {
                echo json_encode(array('status' => 'NK', 'message' => esc_html($response->message)));
                exit;
            }

            if (isset($intent) && $intent == 'preview') {
                $contents = $this->validationContent($response, $amount);
                echo json_encode(array('status' => 'OK', 'contents' => $contents, 'message' => esc_html($response->message)));
                exit;
            }
        }

        if (in_array(strtolower($bill_type), array('power', 'internet', 'biller', 'toll'))) {
            $amount = $amount + 100;
        }

        //   process url generation here
        $response = $this->makeBillPaymentRequest($customer, $currency, $country, $bill_type, $amount, $biller_name, $biller_code, $item_code, $customer_identifier, $name);
        if (is_array($response)) {
            echo json_encode($response);
            exit;
        }

        echo json_encode(array('status' => 'NK', 'message' => esc_html__('Internal Error, bill payment request failed, try again later', 'apphosting')));
        exit;
        //

        echo json_encode(array('status' => 'NK', 'message' => esc_html__('Internal Error, could not generate cart', 'apphosting')));
        exit;
    }




    public function processAccountCreate()
    {
        foreach ($_POST as $postdata => $value) {
            $$postdata = htmlspecialchars($value);
        }

        if (!isset($email) || !isset($password)) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('Email, Username and Password, must be provided', 'apphosting')));
            wp_die();
        }


        $reg_errors = new WP_Error();

        if (empty($firstname)  || empty($lastname) || empty($email)) {
            $reg_errors->add('field', esc_html__('Required form field is missing', 'apphosting'));
        }

        $parts = explode('@', $email);
        $username = $parts[0];

        if (strlen($username) < 1) {
            $reg_errors->add('username_length', esc_html__('Username too short. At least 1 characters is required', 'apphosting'));
        }

        if (username_exists($username)) {
            $reg_errors->add('Username', esc_html__('Sorry, that username already exists!', 'apphosting'));
        }

        if (!validate_username($username)) {
            $reg_errors->add('username_invalid', esc_html__('Sorry, the username you entered is not valid', 'apphosting'));
        }

        if (strlen($password) < 5) {
            $reg_errors->add('password', esc_html__('Password length must be greater than 4', 'apphosting'));
        }

        if (!is_email($email)) {
            $reg_errors->add('email_invalid', esc_html__('Email is not valid', 'apphosting'));
        }

        if (email_exists($email)) {
            $reg_errors->add('email', esc_html__('Email Already in use', 'apphosting'));
        }

        if (is_wp_error($reg_errors)) {
            foreach ($reg_errors->get_error_messages() as $error) {
                APHTools::displayError(esc_html($error));
            }
        }

        if (count($reg_errors->get_error_messages()) < 1) {
            $userdata = array(
                'user_login' => $username,
                'user_email' => $email,
                'user_pass'  => $password,
            );

            if (isset($firstname)) {
                $userdata['first_name'] = $firstname;
            }
            if (isset($lastname)) {
                $userdata['last_name'] = $lastname;
            }
            if (isset($phone) && $phone !='') {
                $userdata['phone'] = $phone;
                update_user_meta($user->ID, 'phone', $phone, '');
            }

            $userdata['nickname'] = $firstname.' '.$lastname;

            if (isset($Bio)) {
                $userdata['description'] = $Bio;
            }

            $user = wp_insert_user($userdata);
            // login user
            //proceed to select days
            $user = wp_authenticate($username, $password);
            wp_set_current_user($user->ID, $user->user_login);
            wp_set_auth_cookie($user->ID);
            do_action('wp_login', $user->user_login, $user);

            APHTools::displaySuccessURL(get_page_link(11));
        }


        APHTools::displayError(esc_html__('Unknow error occured', 'apphosting'));
    }

    public function processAccountLogin()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHTools.php';

        if ($_POST['email'] != '') {
            $username = htmlspecialchars($_POST['email']);
        }
        if ($_POST['email'] == '') {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('Email / Username is required', 'apphosting')));
            wp_die();
        }
        if (isset($_POST['rememberme'])) {
            $rememberme = htmlspecialchars($_POST['rememberme']);
        }
        if (!isset($_POST['rememberme'])) {
            $rememberme = 'off';
        }

        if ($_POST['password'] != '') {
            $password = htmlspecialchars($_POST['password']);
        }
        if ($_POST['password'] == '') {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('Password is required', 'apphosting')));
            wp_die();
        }



        $autho = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true,
        );
        if ($rememberme == 'on') {
            $user = wp_signon($autho, false);
        } else {
            $user = wp_authenticate($username, $password);
        }

        if (is_wp_error($user)) {
            echo json_encode(array('status' => 'NK', 'message' => esc_html__('Invalid Login details, Please check and try again', 'apphosting')));
            wp_die();
        }
        if (!is_wp_error($user)) {
            wp_set_current_user($user->ID, $user->user_login);
            wp_set_auth_cookie($user->ID);
            do_action('wp_login', $user->user_login, $user);

            echo json_encode(['status' => 'OK', 'url' =>get_page_link(11) , 'message' => esc_html__('Login Successful', 'apphosting')]);
            wp_die();
        }

        echo json_encode(array('status' => 'NK', 'message' => esc_html__('Could not complete the login process, try again later', 'apphosting')));
        wp_die();
    }
}
