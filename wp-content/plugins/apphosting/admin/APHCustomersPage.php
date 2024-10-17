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
class APHCustomersPage
{
    public $page_link;
    public $return_url;
    public $extra_message;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'addMenu'));
        add_action('wp_ajax_manageHostingCustomers', array($this, 'manageHostingCustomers'));
    }

    public function addMenu()
    {
        add_submenu_page('apphosting_settings', esc_html__('Customers', 'apphost'), esc_html__('Customers', 'apphost'), 'manage_options', 'app_customers', array($this, 'display'));
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
        $customers =$cobj->allAndUsers();

        // print_r($customers);




        //$users = $cobj->getWPUsers();

        //$plans = $pobj->getActivePlans();

        ?>

   

<div class="admin-main-container-wave">
<div class="card">
    <div class="card-header bg-white"><?php esc_html_e('Customers', 'apphost'); ?> 
       
       <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#ap_create_new_order_modal">Add New Customer</a>
</div>
  <div class="card-body">
    <div class="table-responsive">
    <table id="mybills_classic_table" class="table table-striped table-bordered">
        <thead>
            <th><?php esc_html_e('WP ID', 'apphost'); ?> </th>  <th><?php esc_html_e('Customer ID', 'apphost'); ?> </th>  <th><?php esc_html_e('Customer Code', 'apphost'); ?> </th>  <th><?php esc_html_e('Name', 'apphost'); ?> </th>  <th><?php esc_html_e('Email', 'apphost'); ?> </th>  <th><?php esc_html_e('Active', 'apphost'); ?> </th> <th><?php esc_html_e('Login', 'apphost'); ?> </th> <th><?php esc_html_e('Date', 'apphost'); ?> </th> <th>Edit </th> <th>Delete </th>
        </thead>
        <tbody>
            <?php if (count($customers) >0) :
                foreach ($customers as $customer) : ?>
                    <tr>
                    <td><?php echo esc_html($customer->ID); ?></td>
                    <td><?php echo esc_html($customer->id_customer); ?></td>
                    <td><?php echo esc_html($customer->customer_code); ?></td>
                    <td><?php echo esc_html($customer->display_name); ?></td>
                    <td><?php echo esc_html($customer->user_email); ?></td>
                   
                    
                    <td><?php
                    if ($customer->active ==1) {
                        echo '<span class="btn btn-block btn-success">Active</span>';
                    } elseif ($customer->active==0) {
                        echo '<span class="btn btn-block btn-danger">Inactive</span>';
                    }
                    ;
                    ?></td>

                     <td><?php echo esc_html($customer->user_login); ?></td>
                   
                    
                  

                    <td><?php echo APHTools::slashDate($customer->created_at); ?></td>

                    <td><a target="_blank" href="<?php echo admin_url().'admin.php?page=app_customer&id='.$customer->ID; ?>" class="btn btn-primary btn-xs "><i class="fa fa-eye"> </i></a></td>
                    
                    <td><button data-object="Customer" data-object_id="<?php echo $customer->ID; ?>" class="btn btn-danger btn-xs ap_delete_object_order_btn"><i class="fa fa-trash"> </i></button></td>
                </tr>

                <?php endforeach;
        else :
            ?>
                 <tr> <td colspan="10"><?php esc_html_e('No Customers, Invite customers ', 'apphost'); ?></td></tr>
            <?php endif; ?>

            
        </tbody>
    </table>
</div>

  </div>
</div>
</div>



<a href="#" id="ap_modal_btn_load_new_order" class="display_none" data-bs-toggle="modal" data-bs-target="#ap_add_new_modal">Add New Customer</a>

<div class="modal fade" id="ap_create_new_order_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header" id="ap_modal_create_api_key_header">
                        <!--begin::Modal title-->
                        <h2>Create New Customer</h2>
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
                    <form id="ap_modal_create_customer_form" class="form" action="#">
                        <!--begin::Modal body-->
                        <div class="modal-body py-10 px-lg-17">
                            <!--begin::Scroll-->
                            <div class="scroll-y me-n7 pe-7" id="ap_modal_create_api_key_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#ap_modal_create_api_key_header" data-kt-scroll-wrappers="#ap_modal_create_api_key_scroll" data-kt-scroll-offset="300px">
                                  
                                <div class="row g-9 mb-7">
                                            <!--begin::Col-->
                                            <div class="col-md-6 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">Email</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input class="form-control form-control-solid" placeholder="" name="user_email" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-6 fv-row">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold mb-2">User Login</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input class="form-control form-control-solid" placeholder="" name="user_login"/>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Col-->
                                        </div>


                                                  <div class="row g-9 mb-7">
                                                                <!--begin::Col-->
                                                                <div class="col-md-6 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-semibold mb-2">First Name</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input class="form-control form-control-solid" placeholder="" name="firstname" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Col-->
                                                                <!--begin::Col-->
                                                                <div class="col-md-6 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-semibold mb-2">Last Name</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input class="form-control form-control-solid" placeholder="" name="lastname" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                       
                                 <div class="row g-9 mb-7">
                                                                <!--begin::Col-->
                                                                <div class="col-md-6 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-semibold mb-2">Phone</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input class="form-control form-control-solid" placeholder="" name="phone" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Col-->
                                                                <!--begin::Col-->

                                                                <div class="col-md-6 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-semibold mb-2">Password</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input class="form-control form-control-solid" placeholder="" name="user_password" />
                                                                    <!--end::Input-->
                                                                </div>
                                                               
                                                                <!--end::Col-->
                                                            </div>

                                 

                      


             
                              
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-5 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2"> Bio</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-solid" rows="3" name="bio" placeholder="Bio"></textarea>
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
                           
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="ap_create_new_customer" class="btn btn-primary">
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

    public function manageHostingCustomers()
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
        if ($request_token =='APSIUOGNCYSRHUARXNRRHIACQUMMBKKRTZOACXEFBPCHWJITWYJTFJOVIQTLKGGE') {
            $firstname = APHTools::getValue('firstname');
            $lastname = APHTools::getValue('lastname');
            $user_email = APHTools::getValue('user_email');
            $user_login = APHTools::getValue('user_login');
            $bio = APHTools::getValue('bio');
            $phone = APHTools::getValue('phone');
            $user_password = APHTools::getValue('user_password');

            if($firstname =='') {
                APHTools::displayError('First name is required');
            }

            if($lastname =='') {
                APHTools::displayError('Last name is required');
            }

            if($user_email =='') {
                APHTools::displayError('Provide user email');
            }

            if($user_login =='') {
                APHTools::displayError('User login cannot be empty');
            }

            if(strpos($user_login, ' ') !==false) {
                APHTools::displayError('User login cannot have empty space, use one word or use underscore to combine multiple words');
            }


            $user = wp_insert_user(array('user_email'=>$user_email, 'user_login'=>$user_login, 'user_password'=>$user_password));
            if(!is_wp_error($user)) {
                update_user_meta($id, 'firstname', $firstname);
                update_user_meta($id, 'lastname', $lastname);
                update_user_meta($id, 'bio', $bio);
                update_user_meta($id, 'phone', $phone);
                APHTools::ajaxReport('OK', 'Successful');
            } else {
                foreach ($user->get_error_messages() as $error) {
                    APHTools::displayError(esc_html($error));
                }
            }




            APHTools::ajaxReport('OK', 'Successful');
        } elseif($request_token =='APNOLSBPAJWRLKTPCFCGTXARACZSKALILUTUJNMATOAABXNGDPVVLIWOUXUNTFXB') {
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


new APHCustomersPage();

?>
