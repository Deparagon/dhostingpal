<?php


/**
 *
 */
class APHFunction
{
    public $errors =array();

    public function __construct()
    {
        add_action('after_setup_theme', array($this, 'removeBarAction'));
        add_filter('wp_mail', array($this, 'doEmailLoginProcess'));
        add_action('init', array($this, 'redirectToNewLoginPage'));
        add_action( 'register_post', array($this, 'checkRegistrationFieldsForSpam'), 10, 3 );
    }



    public function removeBarAction()
    {
        if (!current_user_can('administrator') && !is_admin()) {
            show_admin_bar(false);
        }
    }




public function checkRegistrationFieldsForSpam( $username, $email, $errors ) {
   
    if(strpos($username, 'BINANCE')  !==false || strpos($username, 'MEXC')  !==false || strpos($username, 'SOL')  !==false||strpos($username, '  USD ') !==false  || strpos($username, 'EURO') !==false  || strpos($username, 'KUCOIN') !==false || strpos($username, 'USD BYBIT') !==false || strpos($username, 'USD TRADE') !==false || strpos($username, 'USD BINANCE') !==false || strpos($username, 'XRP')  !== false) {
        $errors->add('username_length', 'Username has some old characters, try again');
        file_put_contents(dirname(__FILE__).'/../logs/failed_reg.txt', date('Y-m-d H:i:s').' USERNAME: '.$username.'  EMAIL: '.$email."\n\n\n", FILE_APPEND);
    }


    return $errors; 
}


    public function redirectToNewLoginPage()
    {
        $login_url  = home_url('/login');
        $url = basename($_SERVER['REQUEST_URI']);
        isset($_REQUEST['redirect_to']) ? ($url   = "wp-login.php") : 0;
        if ($url  == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
            wp_redirect($login_url);
            exit;
        }
    }


    public function doEmailLoginProcess($data)
    {
        file_put_contents(dirname(__FILE__).'/logs/email_logs.txt', date('Y-m-d H:i:s').' '.$data['message']."\n\n\n", FILE_APPEND);
        return $data;
    }


    public function userCreate($data)
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHCountry.php';

        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHAddress.php';
        $userdata = array(
               'user_login' => strtolower($data['firstname']),
               'user_email' => $data['email'],
               'user_pass'  => $data['uuid'],
           );

        $userdata['first_name'] = $data['firstname'];
        if ($data['lastname'] =='') {
            $userdata['last_name'] = $data['firstname'];
        } else {
            $userdata['last_name'] = $data['lastname'];
        }

        $password = $data['uuid'];


        if ($data['phonenumber']!='') {
            $userdata['phone'] = $data['phonenumber'];
        }

        $userdata['nickname'] = $data['firstname'].' '.$data['lastname'];
        $user = wp_insert_user($userdata);
        // login user
        $user = wp_authenticate($username, $password);
        if ($data['phonenumber'] !='') {
            update_user_meta($user->ID, 'phone', $data['phonenumber'], '');
        }

        $id_country = APHCountry::getIDByCode($data['country']);

        $add = new APHAddress();

        $add->filled = array('user_id'=>$user->ID, 'address_type'=>'Billing', 'firstname'=>$data['firstname'], 'lastname'=>$data['lastname'], 'address'=>$data['address1'].' '.$data['address2'], 'city'=>$data['city'], 'postal_code'=>$data['postcode'], 'province_or_state'=>$data['state'], 'phone'=>$data['phonenumber'], 'id_country'=>$id_country, 'address_name'=>'IM_billing_'.$user->ID, 'country_code'=>$data['country'], 'email'=> $data['email']);

        $add->saveField();
        return $user->ID;
    }
    public function installUsers()
    {
        if (get_option('APH_CREATED_USERS') ==1) {
            return;
        }
        $clients = $this->getClients();
        if (count($clients) >0) {
            foreach ($clients as $c) {
                if ($c['status']  =='Active') {
                    $this->userCreate($c);
                }
            }
        }

        update_option('APH_CREATED_USERS', 1);
    }

    public function getClients()
    {
        return array();
    }
}


new APHFunction();
