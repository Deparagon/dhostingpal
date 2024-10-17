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

if (!defined('ABSPATH')) {
    exit;
}
class APHOrdersPage
{
    public $page_link;
    public $return_url;
    public $extra_message;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'addMenu'));
        add_action('wp_ajax_manageHostingOrders', array($this, 'manageHostingOrders'));
    }

    public function addMenu()
    {
        add_submenu_page('apphosting_settings', esc_html__('Orders', 'apphost'), esc_html__('Orders', 'apphost'), 'manage_options', 'app_customer_orders', array($this, 'display'));
    }

    public function display()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHOrder.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHPlan.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHCustomer.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHDomain.php';
        $inobj = new APHOrder();

        $cobj = new APHCustomer();
        $pobj = new APHPlan();
        $orders =$inobj->allWithUsers();




        $users = $cobj->getWPUsers();

        $plans = $pobj->getActivePlans();

        ?>

   

<div class="admin-main-container-wave">
<div class="card">
    <div class="card-header bg-white"><?php esc_html_e('Orders', 'apphost'); ?> 
       
       <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#ap_create_new_order_modal">Add New Order</a>
</div>
  <div class="card-body">
    <div class="table-responsive">
    <table id="mybills_classic_table" class="table table-striped table-bordered">
        <thead>
            <th><?php esc_html_e('ID', 'apphost'); ?> </th>  <th><?php esc_html_e('By', 'apphost'); ?> </th>  <th><?php esc_html_e('Email', 'apphost'); ?> </th>  <th><?php esc_html_e('Start', 'apphost'); ?> </th>  <th><?php esc_html_e('End', 'apphost'); ?> </th>  <th><?php esc_html_e('Amount', 'apphost'); ?> </th> <th><?php esc_html_e('Status', 'apphost'); ?> </th> <th><?php esc_html_e('Date', 'apphost'); ?> </th> <th>Edit </th> <th>Delete </th>
        </thead>
        <tbody>
            <?php if (count($orders) >0) :
                foreach ($orders as $order) : ?>
                    <tr>
                    <td><?php echo esc_html($order->id_order); ?></td>
                    <td><?php echo esc_html($order->display_name); ?></td>
                    <td><?php echo esc_html($order->user_email); ?></td>
                    <td><?php echo esc_html($order->start_date); ?></td>
                    <td><?php echo esc_html($order->end_date); ?></td>
                    <td><?php echo esc_html(number_format($order->order_total, 2)); ?></td>
                    
                   </td>
                    
                    <td><?php
                    if ($order->status =='active') {
                        echo '<span class="btn btn-block btn-success">'.esc_html($order->status).'</span>';
                    } elseif ($order->status=='inactive') {
                        echo '<span class="btn btn-block btn-danger">'.esc_html($order->status).'</span>';
                    } elseif ($order->status =='draft') {
                        echo '<span class="btn btn-block btn-warning">'.esc_html($order->status).'</span>';
                    } else {
                        echo esc_html($order->status);
                    }
                    ;
                    ?></td>

                    <td><?php echo APHTools::slashDate($plan->created_at); ?></td>

                    <td><button data-object="Order" data-object_id="<?php echo $order->id_order; ?>" class="btn btn-primary btn-xs ap_edit_object_plan_btn"><i class="fa fa-eye"> </i></button></td>
                    
                    <td><button data-object="Order" data-object_id="<?php echo $order->id_order; ?>" class="btn btn-danger btn-xs ap_delete_object_order_btn"><i class="fa fa-trash"> </i></button></td>
                </tr>

                <?php endforeach;
        else :
            ?>
                 <tr> <td colspan="10"><?php esc_html_e('No Order, Invite customers to place orders', 'apphost'); ?></td></tr>
            <?php endif; ?>

            
        </tbody>
    </table>
</div>

  </div>
</div>
</div>

<a href="#" id="ap_modal_btn_load_new_order" class="display_none" data-bs-toggle="modal" data-bs-target="#ap_add_new_modal">Add New Order</a>

<div class="modal fade" id="ap_create_new_order_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header" id="ap_modal_create_api_key_header">
                        <!--begin::Modal title-->
                        <h2>Create Order</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Form-->
                    <form id="ap_modal_create_order_form" class="form" action="#">
                        <!--begin::Modal body-->
                        <div class="modal-body py-10 px-lg-17">
                            <!--begin::Scroll-->
                            <div class="scroll-y me-n7 pe-7" id="ap_modal_create_api_key_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#ap_modal_create_api_key_header" data-kt-scroll-wrappers="#ap_modal_create_api_key_scroll" data-kt-scroll-offset="300px">
                       
                                <!--begin::Input group-->
                                <div class="row">
                                    <div class="col-sm-6"> 
                                     <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Customer </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select  class="form-control form-control-solid" placeholder="Customer" name="user_id">

                                         <?php if(count($users) >0):
                                             foreach($users as $u): ?>

                                        <option value="<?php echo $u->ID; ?>"> <?php echo $u->user_email.' | '.$u->display_name; ?></option>
                                    <?php  endforeach; endif;
        ?>

                                    </select>
                                    <!--end::Input-->

                                   
                                </div>
                                <!--end::Input group--></div>
                                    <div class="col-sm-6">  <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Plan</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid" placeholder="Plan" name="id_plan">

                                          <?php if(count($plans) >0):
                                              foreach($plans as $p): ?>

                                        <option value="<?php echo $p->id_plan; ?>"> <?php echo $p->name.' | '.$p->plan_type. ' | '.$p->app_type; ?></option>
                                    <?php  endforeach; endif;
        ?>

                                    </select>

                                    <!--end::Input-->
                                </div>
                                <!--end::Input group--></div>
                                </div>

                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Domain</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Domain" name="domain_name" />
                                    <!--end::Input-->
                                </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Years</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select type="text" class="form-control form-control-solid" placeholder="" name="number_of_domain_years">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Domain Action</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select type="text" class="form-control form-control-solid" placeholder="" name="domain_action">
                                        <option value="Register">Register</option>
                                        <option value="Transter">Transfer</option>
                                        <option value="Add">Add</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                    </div>


                                </div>

                      


             
                              
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-5 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2"> Order Note</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-solid" rows="3" name="order_note" placeholder="Order note"></textarea>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
              

                      
                                <!--end::Input group-->
                                <!--begin::Input group-->
                             
                                <!--end::Input group-->
                            </div>
                            <!--end::Scroll-->

                            <div id="ajax_return_values_innerline"></div>



                        </div>
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer flex-center">
                            <!--begin::Button-->
                            <button type="reset" id="app_review_order_button" class="btn btn-light me-3">Review Order</button>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="ap_create_new_order" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                        <!--end::Modal footer-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>

  


  





        <?php
    }

    public function manageHostingOrders()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHTools.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHPlan.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHDomain.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHDomainPrice.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHPaystack.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHOrder.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHAddress.php';
        $oplan = new APHPlan();



        $request_token = APHTools::getValue('request_token');
        if ($request_token =='APKJNRJWLGGDFTUETTDIWRXGGGHEELOFJWIVMTLLFMPRBTQOCXXXUQUFFQGJWHZM') {
            $user_id = (int) APHTools::getValue('user_id');
            $id_plan = (int) APHTools::getValue('id_plan');
            $domain_name = APHTools::getValue('domain_name');
            $domain_action = APHTools::getValue('domain_action');
            $number_of_domain_years = (int) APHTools::getValue('number_of_domain_years');

            if($domain_name =='') {
                APHTools::displayError('Enter a valid domain name');
            }

            $ext = explode('.', $domain_name);

            if(!isset($ext[1])) {
                APHTools::displayError('Fill in the domain extention');
            }


            $domain_price =0;


            $user = get_user_by('ID', $user_id);
            if(!is_object($user)) {
                APHTools::displayError('Select a valid user');
            }


            $plan =  $oplan->getById($id_plan);

            if($domain_action =='Register') {
                $domaininfo = (new APHDomain())->domainCheck($domain_name);

                file_put_contents(dirname(__FILE__).'/heregoput.txt', print_r($domaininfo, true));

                if(is_array($domaininfo) && $domaininfo['available'] !="Yes") {
                    APHTools::displayError('Domain is not available, check another domain');
                }

                if(!is_array($domaininfo)) {
                    APHTools::displayError('Could not check domain availability, try again later');
                }
            }


            if($domain_action =='Register' || $domain_action =='Transfer') {
                $domain_price = (new APHDomainPrice())->getDomainNamePrice($domain_name);

                if((float) $domain_price ==0) {
                    APHTools::displayError('Could not calculate domain price, try again later');
                }

                $domain_total = $domain_price * $number_of_domain_years;
            }



            $price = 0;
            if(is_object($plan) && isset($plan->id_plan)) {
                $price+=$plan->monthly_price;
                $plan_name = $plan->name.' '.$plan->app_type;
            }

            $total = $price+ $domain_total;


            ob_start();
            ?>

                 <table class="table table-striped table-bordered">
                     <tr>
                         <td>Domain</td> <td> <?php echo $domain_name; ?></td> <td> <strong> <?php echo $domain_price; ?> </strong></td>
                     </tr>

                      <tr>
                         <td>Hosting</td> <td> <?php if(isset($plan_name)) {
                             echo $plan_name;
                         } ?></td> <td> <?php echo $price; ?></td>
                     </tr>

                     <tr>
                         <td>Total</td> <td colspan="2"> <strong><?php echo $total; ?> </strong> </td>
                     </tr>
                 </table>



                <?php

                $contents_info = ob_get_contents();
            ob_clean();

            APHTools::ajaxReport('OK', 'Successful review', $contents_info);
        } elseif($request_token =='APNOLSBPAJWRLKTPCFCGTXARACZSKALILUTUJNMATOAABXNGDPVVLIWOUXUNTFXB') {
            $user_id = (int) APHTools::getValue('user_id');
            $id_plan = (int) APHTools::getValue('id_plan');
            $domain_name = APHTools::getValue('domain_name');
            $domain_action = APHTools::getValue('domain_action');
            $number_of_domain_years = APHTools::getValue('number_of_domain_years');

            if($domain_name =='') {
                APHTools::displayError('Enter a valid domain name');
            }

            $ext = explode('.', $domain_name);

            if(!isset($ext[1])) {
                APHTools::displayError('Fill in the domain extention');
            }


            $domain_price =0;


            $user = get_user_by('ID', $user_id);
            if(!is_object($user)) {
                APHTools::displayError('Select a valid user');
            }


            $plan =  $oplan->getById($id_plan);

            if($domain_action =='Register') {
                $domaininfo = (new APHDomain())->domainCheck($domain_name);



                if(is_array($domaininfo) && $domaininfo['available'] !="Yes") {
                    APHTools::displayError('Domain is not available, check another domain');
                }

                if(!is_array($domaininfo)) {
                    APHTools::displayError('Could not check domain availability, try again later');
                }
            }


            if($domain_action =='Register' || $domain_action =='Transfer') {
                $domain_price = (new APHDomainPrice())->getDomainNamePrice($domain_name);

                if((float) $domain_price ==0) {
                    APHTools::displayError('Could not calculate domain price, try again later');
                }

                $domain_total =  $domain_price * $number_of_domain_years;
            }



            $price = 0;
            if(is_object($plan) && isset($plan->id_plan)) {
                $price+=$plan->monthly_price;
                $plan_name = $plan->name.' '.$plan->app_type;
            }

            $total = $price+ $domain_total;



            $addresses = (new APHAddress())->getMyAddresses($user_id);

            if(count($addresses) >0) {
                foreach($addresses as $ad) {
                    if($ad['address_type'] =='Registrant') {
                        $id_reg_address = $ad['id_address'];
                    }
                    if($ad['address_type'] =='Billing') {
                        $id_billing_address = $ad['id_address'];
                    }
                    if($ad['address_type'] =='Technical') {
                        $id_tech_address = $ad['id_address'];
                    }

                    if($ad['address_type'] =='Administrator') {
                        $id_admin_address = $ad['id_address'];
                    }
                }

                if(!isset($id_reg_address)) {
                    $id_reg_address = $addresses[0]->id_address;
                }

                if(!isset($id_billing_address)) {
                    $id_billing_address = $addresses[0]->id_address;
                }

                if(!isset($id_tech_address)) {
                    $id_tech_address = $addresses[0]->id_address;
                }

                if(!isset($id_admin_address)) {
                    $id_admin_address = $addresses[0]->id_address;
                }
            }



            $domain_args =array('user_id'=>$user_id, 'id_reg_address'=>$id_reg_address, 'id_admin_address'=>$id_admin_address, 'id_tech_address'=>$id_tech_address, 'id_billing_address'=>$id_billing_address, 'name'=>$domain_name, 'status'=>'Pending',  'price'=>$price, 'domain_state'=>$domain_action, 'first_years'=>$number_of_domain_years, 'current_years'=>$number_of_domain_years, 'created_at'=>date('Y-m-d H:i:s'));



            $domaino = new APHDomain();
            $domaino->validateFields($domain_args);
            $domaino->saveField();
            $id_domain = $domaino->latest_id;

            $reference = 'DHPO'.APHTools::codeGenerator(16);
            $payment_reference = 'DHPINV'.APHTools::codeGenerator(14);


            $args = array('user_id'=>$user_id, 'id_domain'=>$id_domain, 'id_currency'=>2, 'app_domain'=>$domain_name, 'order_total'=>$total_ng, 'default_total'=>$total, 'reference'=>$reference, 'created_at'=>date('Y-m-d H:i:s'));
            $ordero = new APHOrder();
            $ordero->validateFields($args);
            $ordero->saveField();
            $order= $ordero->getLatest();

            //$authuser = get_user_by('ID', $user_id);


            $ostack = new APHPaystack();

            $ocustomer = new APHCustomer();
            $excustomer = $ocustomer->userFirst($user_id);

            if($ocustomer->checkIfUserHas($user_id)) {
                $customer_code = $excustomer->customer_code;
            } else {
                $customer_code = $ostack->createCustomer($user, $phone);
            }


            $invoice_args = array('user_id'=>$user_id, 'id_order'=>$order->id_order, 'invoice_amount'=>$total_ng, 'default_amount'=>$total, 'status'=>'Unpaid','paid_amount'=>0.00, 'reference'=>$payment_reference, 'created_at'=>date('Y-m-d H:i:s'));

            $i_instance = new APHInvoice();
            $i_instance->validateFields($invoice_args);
            $i_instance->saveField();
            $invoice= $i_instance->getLatest();

            if(!is_object($invoice) || (int) $invoice->id_invoice ==0) {
                APHTools::displayError('Could not generate payable invoice for this order, try again, if this issue persist, please contact support');
            }




            APHTools::ajaxReport('OK', 'Successful');
        } elseif ($request_token =='APVWUMEQKQEPSXBPUZTLAHILUXEDYFHUVWOHFFBXEGZPKHLJETZNHWMLJLYNEWOW') {
        } elseif ($request_token =='7C3249B783974BA9B2FBB2DF27DD0F13') {
        }
    }










    public function userSearch()
    {
        $keyword = APHTools::getValue('search_term');
        $args = array(
        'search'         => "*$keyword*",
        'search_columns' => array( 'user_login', 'user_email', 'user_nicename','ID' )
        );
        $user_query = new WP_User_Query($args);

        $customers = $user_query->get_results();

        if (count($customers) >0) :
            $contents =  '<div class="show_customer_specific_price"></div>
<div class="table-responsive">
    <table class="table table-stripped table-bordered">
        <thead>
            <th>'.__('ID', 'apphost').'</th> <th>'.__('Name', 'apphost').'</th> <th>'.__('Email', 'apphost').'</th> <th>'.__('Select', 'apphost').'</th>
        </thead>
        <tbody>';
            foreach ($customers as $customer) :
                $contents.='<tr>
    <td>'.esc_html($customer->data->ID).'</td>
    <td>'.esc_html($customer->data->display_name).'</td>
    <td>'.esc_html($customer->data->user_email).'</td>
    <td><input type="radio" name="id_customer" value="'.esc_html($customer->data->ID).'" class="each_customer_account"></td>
</tr>';
            endforeach;
            $contents.='
</tbody>
</table>
</div>';
        else :
            $contents.='<div class="alert alert-danger">'.__('No Customer found, update the search term and search again', 'apphost').' </div>';
        endif;

        echo json_encode(array('status'=>'OK', 'contents'=>$contents, 'message'=>__('User search completed successfully', 'apphost')));
        exit;
    }
}// close class


new APHOrdersPage();

?>
