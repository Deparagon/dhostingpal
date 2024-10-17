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
class APHCustomerPage
{
    public $page_link;
    public $return_url;
    public $extra_message;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'addMenu'));
        add_action('wp_ajax_manageHostingCustomer', array($this, 'manageHostingCustomer'));
    }

    public function addMenu()
    {
        add_submenu_page('apphosting_settings', esc_html__('Customer', 'apphost'), '-', 'manage_options', 'app_customer', array($this, 'display'));
    }

    public function display()
    {
        ob_start();
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHOrder.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHPlan.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHCustomer.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHDomain.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHAddress.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHInvoice.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHDomainPrice.php';

        $user_id = (int) APHTools::getValue('id');
        $cobj = new APHCustomer();

        $customer = $cobj->leftCombineThisUser($user_id);
        // get_user_by('ID', $user_id);



        if(!is_object($customer)) {
            ob_clean();

            APHTools::redirect(admin_url().'?page=app_customers');
        }

        $oobj = new APHOrder();
        $aobj = new APHAddress();
        $dobj = new APHDomain();
        $ctobj = new APHCountry();

        $myorders = $oobj->myOwn($user_id);

        $myaddresses = $aobj->myOwn($user_id);

        $domainscount = $dobj->countByUserId($user_id);

        $totalspent = $oobj->totalSpent($user_id);

        $progress =($customer->active ==1) ? 100 : 50;


        $pobj = new APHPlan();

        $countries = $ctobj->getActives();

        $mydomains = $dobj->LeftCombineAllThisUser($user_id);

        $myinvoices = (new APHInvoice())->LeftCombineAllThisUser($user_id);

        //$users = $cobj->getWPUsers();

        //$plans = $pobj->getActivePlans();

        ?>
         <div class="the_main_menu_account_bo row">
         <div class="col-12 col-lg-12">
             
              <!--begin::Navbar-->
                                <div class="card full-width-card mb-5 mb-xl-12">
                                    <div class="card-body pt-9 pb-0">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-wrap flex-sm-nowrap">
                                            <!--begin: Pic-->
                                            <div class="me-7 mb-4">
                                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                                    <img src="<?php echo get_avatar_url($customer->user_email); ?> " alt="<?php echo $customer->display_name; ?>" />
                                                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                                                </div>
                                            </div>
                                            <!--end::Pic-->
                                            <!--begin::Info-->
                                            <div class="flex-grow-1">
                                                <!--begin::Title-->
                                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                    <!--begin::User-->
                                                    <div class="d-flex flex-column">
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center mb-2">
                                                            <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?php echo get_user_meta($customer->ID, 'firstname', true);
        echo get_user_meta($customer->ID, 'lastname', true); ?></a>
                                                            <a href="#">
                                                                <i class="ki-duotone ki-verify fs-1 text-primary">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                            </a>
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Info-->
                                                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                            <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>Developer</a>
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                            <i class="ki-duotone ki-geolocation fs-4 me-1">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>SF, Bay Area</a>
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                            <i class="ki-duotone ki-sms fs-4">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i><?php echo $customer->user_email; ?></a>
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <!--end::User-->
                                                  
                                                </div>
                                                <!--end::Title-->
                                                <!--begin::Stats-->
                                                <div class="d-flex flex-wrap flex-stack">
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-column flex-grow-1 pe-8">
                                                        <!--begin::Stats-->
                                                        <div class="d-flex flex-wrap">
                                                            <!--begin::Stat-->
                                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                                <!--begin::Number-->
                                                                <div class="d-flex align-items-center">
                                                                    <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo $totalspent; ?>" data-kt-countup-prefix="N">0</div>
                                                                </div>
                                                                <!--end::Number-->
                                                                <!--begin::Label-->
                                                                <div class="fw-semibold fs-6 text-gray-400">Total Spent</div>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Stat-->
                                                            <!--begin::Stat-->
                                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                                <!--begin::Number-->
                                                                <div class="d-flex align-items-center">
                                                                    <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo $domainscount; ?>">0</div>
                                                                </div>
                                                                <!--end::Number-->
                                                                <!--begin::Label-->
                                                                <div class="fw-semibold fs-6 text-gray-400">Domains</div>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Stat-->
                                                            <!--begin::Stat-->
                                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                                <!--begin::Number-->
                                                                <div class="d-flex align-items-center">
                                                                    <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo count($myorders); ?>" data-kt-countup-prefix="#">0</div>
                                                                </div>
                                                                <!--end::Number-->
                                                                <!--begin::Label-->
                                                                <div class="fw-semibold fs-6 text-gray-400">Orders</div>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Stat-->
                                                        </div>
                                                        <!--end::Stats-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <!--begin::Progress-->
                                                    <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                            <span class="fw-semibold fs-6 text-gray-400">Profile Compleation</span>
                                                            <span class="fw-bold fs-6"><?php echo $progress.'%'; ?> </span>
                                                        </div>
                                                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                            <div class="bg-success rounded h-5px" role="progressbar" style="width: <?php echo $progress.'%'; ?>;" aria-valuenow="<?php $progress;  ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <!--end::Progress-->
                                                </div>
                                                <!--end::Stats-->
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Navs-->
                                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a data-link="over_view_box" class="nav-link  text-active-primary ms-0 me-10 py-5 active" >Overview</a>
                                            </li>
                                            <!--end::Nav item-->
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a data-link="the_orders_box" class="nav-link text-active-primary ms-0 me-10 py-5">Orders</a>
                                            </li>
                                            <!--end::Nav item-->
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a data-link="the_account_addresses_box" class="nav-link text-active-primary ms-0 me-10 py-5">Addresses</a>
                                            </li>
                                            <!--end::Nav item-->
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a data-link="the_account_domains_box" class="nav-link text-active-primary ms-0 me-10 py-5">Domains</a>
                                            </li>
                                            <!--end::Nav item-->
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a data-link="the_account_invoices_box" class="nav-link text-active-primary ms-0 me-10 py-5">Invoices</a>
                                            </li>
                                            <!--end::Nav item-->
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a data-link="" class="nav-link text-active-primary ms-0 me-10 py-5">Payments</a>
                                            </li>
                                            <!--end::Nav item-->
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a data-link="" class="nav-link text-active-primary ms-0 me-10 py-5">Referrals</a>
                                            </li>
                                            <!--end::Nav item-->
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a data-link="" class="nav-link text-active-primary ms-0 me-10 py-5">API Keys</a>
                                            </li>
                                            <!--end::Nav item-->
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a data-link="" class="nav-link text-active-primary ms-0 me-10 py-5">Logs</a>
                                            </li>
                                            <!--end::Nav item-->
                                        </ul>
                                        <!--begin::Navs-->
                                    </div>
                                </div>
                                <!--end::Navbar-->
         </div>
     </div>



     <div class="over_view_box aph_account_menu_item row">
         <div class="col-12 col-lg-12">
          <div class="card full-width-card mb-5 mb-xl-12">
            <div class="card-header">Account Details</div>
            <div class="card-body pt-9 pb-0">

              <div class="row">
                  <div class="col-sm-4">
                        <div class="d-flex flex-stack fs-4 py-3">
                                                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_customer_view_details" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">Details
                                                    <span class="ms-2 rotate-180">
                                                        <i class="ki-duotone ki-down fs-3"></i>
                                                    </span></div>
                                                    <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit customer details">
                                                        <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_customer">Edit</a>
                                                    </span>
                                                </div>
                                                <!--end::Details toggle-->
                                                <div class="separator separator-dashed my-3"></div>
                                                <!--begin::Details content-->
                                                <div id="kt_customer_view_details" class="collapse show">
                                                    <div class="py-5 fs-6">
                                                        <!--begin::Badge-->
                                                        <div class="badge badge-light-info d-inline">Premium user</div>
                                                        <!--begin::Badge-->
                                                        <!--begin::Details item-->
                                                        <div class="fw-bold mt-5">Account ID</div>
                                                        <div class="text-gray-600">ID-<?php echo $customer->ID; ?></div>
                                                        <!--begin::Details item-->
                                                        <!--begin::Details item-->
                                                        <div class="fw-bold mt-5">Billing Email</div>
                                                        <div class="text-gray-600">
                                                            <a href="#" class="text-gray-600 text-hover-primary"><?php echo $customer->user_email; ?></a>
                                                        </div>
                                                        <!--begin::Details item-->
                                                        <!--begin::Details item-->
                                                        <div class="fw-bold mt-5">Customer Names </div>
                                                        <div class="text-gray-600"><?php echo get_user_meta($customer->ID, 'firstname', true); ?>
                                                        <br /><?php echo get_user_meta($customer->ID, 'lastname', true); ?>
                                                        </div>
                                                        <!--begin::Details item-->
                                                        <!--begin::Details item-->
                                                        <div class="fw-bold mt-5">Language</div>
                                                        <div class="text-gray-600">English</div>
                                                        <!--begin::Details item-->
                                                        <!--begin::Details item-->
                                                        <div class="fw-bold mt-5">Upcoming Invoice</div>
                                                        <div class="text-gray-600">54238-8693</div>
                                                        <!--begin::Details item-->
                                                        <!--begin::Details item-->
                                                        <div class="fw-bold mt-5">Tax ID</div>
                                                        <div class="text-gray-600">TX-8674</div>
                                                        <!--begin::Details item-->
                                                    </div>
                                                </div>
                                                <!--end::Details content-->

                  </div>
                  <div class="col-sm-8">

                     <form method="post" action="" method="post" id="aph_save_customer_details_form">

                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_customer_header" data-kt-scroll-wrappers="#kt_modal_update_customer_scroll" data-kt-scroll-offset="300px">
                                                        
                                                        <!--begin::User toggle-->
                                                        <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_update_customer_user_info" role="button" aria-expanded="false" aria-controls="kt_modal_update_customer_user_info">User Information
                                                        <span class="ms-2 rotate-180">
                                                            <i class="ki-duotone ki-down fs-3"></i>
                                                        </span></div>
                                                        <!--end::User toggle-->
                                                        <!--begin::User form-->
                                                        <div id="kt_modal_update_customer_user_info" class="collapse show">
                                                            <!--begin::Input group-->

                                                                <input type="hidden" name="user_id" value="<?php echo $customer->ID; ?>">
                                                                      <!--begin::Input group-->
                                                            <div class="row g-9 mb-7">
                                                                <!--begin::Col-->
                                                                <div class="col-md-6 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-semibold mb-2">First Name</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input class="form-control form-control-solid" placeholder="" name="firstname" value="<?php echo get_user_meta($customer->ID, 'firstname', true); ?>" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Col-->
                                                                <!--begin::Col-->
                                                                <div class="col-md-6 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="fs-6 fw-semibold mb-2">Last Name</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input class="form-control form-control-solid" placeholder="" name="lastname" value="<?php echo get_user_meta($customer->ID, 'lastname', true); ?>" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                                                            
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-semibold mb-2">Display Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" placeholder="" name="display_name" value="<?php echo $customer->display_name; ?>" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-7">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-semibold mb-2">
                                                                    <span>Email</span>
                                                                    <span class="ms-1" data-bs-toggle="tooltip" title="Email address must be active">
                                                                        <i class="ki-duotone ki-information fs-7">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                        </i>
                                                                    </span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="<?php echo $customer->user_email; ?>" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-15">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-semibold mb-2">Bio</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" placeholder="" name="bio" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--end::User form-->


                                                        <div class="form-group">
                                                            <button id="aph_save_update_customer_details" class="btn-sm btn btn-success">Update</button>
                                                        </div>
                                                   
                                                    </div>
                         

                     </form>
                      

                  </div>
              </div>

          </div>

           </div>

             
         </div>
     </div>





     <div class="the_account_addresses_box aph_account_menu_item row">
         <div class="col-12 col-lg-12">
                    <div class="card full-width-card">
                        <div class="card-header">Addresses</div>
                        <div class="card-body">
                     
                        <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th> ID </th> <th> Type </th> <th> Name</th> <th> Email</th> <th> Address </th> <th>Phone</th> <th>Action</th>
                    </thead>
                    
               <?php if (count($myaddresses) >0):
                   foreach($myaddresses as $ad): ?>

    <tr> 
         <td><?php echo $ad->id_address; ?></td>
         <td><?php echo $ad->address_type; ?></td>
         <td><?php echo $ad->firstname; ?> <?php echo $ad->lastname; ?></td>
         <td><?php echo $ad->email; ?></td>
         <td><?php echo $ad->address; ?></td>
         <td><?php echo $ad->phone; ?></td>
         <td> <button data-object="APHAddress" data-object_id="<?php echo $ad->id_address; ?>" class="delete_object_action_call btn btn-sm btn-danger"><i class="fa fa-trash"> </i></button></td>
     </tr>

                  <?php endforeach;
               endif;

        ?>
        
        </table>

         </div>

<div class="aph_bo_add_new_address_form">
   <form id="aph_modal_add_address_form" class="form" method="post" action="#">
    <input type="hidden" name="user_id" value="<?php echo $customer->ID; ?>">
                                                      <h4 class="title-top-forms">Add New Address</h4>
   <div class="row mb-3 ">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" value="<?php echo $customer->user_email; ?>" name="email" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="email">Address Type</label>
                                                        <select  name="address_type" class="form-control form-control-lg form-control-solid">
                                                            <option value="Billing">Billing</option>
                                                            <option value="Registrant">Registrant</option>
                                                            <option value="Administrator">Administrator</option>
                                                            <option value="Technical">Technical</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                 
                                            </div>

                                             <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="firstname">First Name</label>
                                                        <input type="text" name="firstname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="lastname">Last Name</label>
                                                        <input type="text" name="lastname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="address">Address</label>
                                                        <input type="text" name="address" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                 <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label>
                                                        <input type="text" name="phone" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="city">City </label>
                                                        <input type="text" name="city" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="postal_code">Postal Code</label>
                                                        <input type="text" name="postal_code" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                        <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="province_or_state">State/Province </label>
                                                        <input type="text" name="province_or_state" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="id_country">Country</label>
                                                        
                                                        
                                                        <select name="id_country" class="form-control form-control-lg form-control-solid"> 
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
                                                        <label for="company_name">Company Name (optional) </label>
                                                        <input type="text" name="company_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="address_name">Give this address a name</label>
                                                        <input type="text" name="address_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>


                                                  <div class="form-group">
                                                      <button id="save_customer_new_address" class="btn btn-primary btn-md">Save Address </button>
                                                  </div>  
                                                
                                                </form>
                                                <!--end::Form-->
</div>

            </div>
            </div> 
         </div>
     </div>









     <div class="the_account_domains_box aph_account_menu_item row">
         <div class="col-12 col-lg-12">
                    <div class="card full-width-card">
                        <div class="card-header">Domains</div>
                        <div class="card-body">
                     
                        <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th> ID </th> <th> Name</th> <th> domain State</th> <th> Active </th> <th>Status</th> <th>domain_start</th> <th>domain_end</th> <th>Action</th>
                    </thead>
                    
               <?php if (count($mydomains) >0):
                   foreach($mydomains as $do): ?>

    <tr> 
         <td><?php echo $do->id_domain; ?></td>
         <td><?php echo $do->name; ?></td>
         <td><?php echo $do->domain_state; ?> </td>
         <td><?php if($do->active ==1): echo 'Active';
         else: echo 'Inactive';  endif; ?></td>
         <td><?php echo $do->status; ?></td>
         <td><?php echo $do->domain_start; ?></td>
         <td><?php echo $do->domain_end; ?></td>
         <td> <button data-object="APHDomain" data-object_id="<?php echo $do->id_domain; ?>" class="update_object_action_call btn btn-sm btn-success"><i class="fa fa-send"> </i></button></td>
     </tr>

                  <?php endforeach;
        endif;

        ?>
        
        </table>

         </div>


            </div>
            </div> 
         </div>
     </div>





      <div class="the_orders_box aph_account_menu_item row">
         <div class="col-12 col-lg-12">
            <div class="card full-width-card">
                <div class="card-header">Orders</div>
                <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th> ID </th> <th> Plan </th> <th> Domain</th> <th> Total</th> <th> Status </th> <th>Action</th>
                    </thead>
                    
               <?php if (count($myorders) >0):
                   foreach($myorders as $ord): ?>

    <tr> 
         <td><?php echo $ord->id_order; ?></td>
         <td><?php echo $ord->plan_name; ?></td>
         <td><?php echo $ord->domain_name; ?></td>
         <td><?php echo $ord->order_total; ?></td>
         <td><?php echo $ord->status; ?></td>
         <td> View</td>
     </tr>

                  <?php endforeach;
               endif;

        ?>
        
        </table>

         </div>
     </div>
 </div>
     </div>
 </div>



          <div class="the_account_invoices_box aph_account_menu_item row">
         <div class="col-12 col-lg-12">
                    <div class="card full-width-card">
                        <div class="card-header"> Invoices</div>
                        <div class="card-body">
                     
                        <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th> ID </th> <th>Reference</th> <th> ID Order </th> <th> billing_start</th> <th> billing_end </th> <th>Status</th> <th>status Message</th> <th>invoice_amount</th> <th>Paid Amount</th> <th>Created A</th> <th>Actions</th>
                    </thead>
                    
               <?php if (count($myinvoices) >0):
                   foreach($myinvoices as $inv): ?>

    <tr> 
         <td><?php echo $inv->id_invoice; ?></td>
         <td><?php echo $inv->reference; ?></td>
         <td><?php echo $inv->id_order; ?></td>
         <td><?php echo $inv->billing_start; ?> </td>
         <td><?php echo $inv->billing_end; ?> </td>
         <td><?php echo $inv->status; ?></td>
         <td><?php echo $inv->status_message; ?></td>
         <td><?php echo $inv->invoice_amount; ?></td>
         <td><?php echo $inv->paid_amount; ?></td>
         <td><?php echo $inv->created_at; ?></td>
         <td> <button data-object="APHInvoice" data-object_id="<?php echo $inv->id_invoice; ?>" class="delete_object_action_call btn btn-sm btn-success"><i class="fa fa-send"> </i></button></td>
     </tr>

                  <?php endforeach;
               endif;

        ?>
        
        </table>

         </div>


            </div>
            </div> 
         </div>
     </div>





     <div class="the_plans_box aph_account_menu_item row">
         <div class="col-12 col-lg-12">
            <div class="card full-width-card">
            <div class="card-header"></div>
            <div class="card-body">
             
         </div>
     </div>
 </div>
</div>


      <div class="the_account_activities_box aph_account_menu_item row">
         <div class="card full-width-card">
            <div class="card-header"></div>
            <div class="card-body">
         <div class="col-12 col-lg-12">
             
         </div>
     </div>
 </div>
     </div>



             


           





        <?php
    }

    public function manageHostingCustomer()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHTools.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHPlan.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHDomain.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHDomainPrice.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHPaystack.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHOrder.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHAddress.php';
        $ADDRESS = new APHAddress();



        $request_token = APHTools::getValue('request_token');
        if ($request_token =='APOCREOZIGNXFPVEPCOLSCYHPIXCPCPCKRCDPKDXKXVAOWKBXKUSRQFKZSABYSFY') {
            $ADDRESS->validateFields($_POST);
            $ADDRESS->saveField();

            APHTools::ajaxReport('OK', 'Address created successfully');
        } elseif($request_token =='APYEWTKZCAPESLRBLICIRSFZDUHQVZSSVQPZRKAAPHCORESJSKMDFIDZJNSPGWGV') {
            $de_object = APHTools::getValue('object');
            $id = (int) APHTools::getValue('id');

            if ($de_object =='') {
                APHTools::displayError('No object was selected for deletion, refresh page and try again');
            }
            if (!$id >0) {
                APHTools::displayError('No item was selected for deletion, refresh page and try again');
            }

            $instant = new $de_object();
            $instant->softDelete($id);

            APHTools::displaySuccess('Deleted successfully');
        } elseif ($request_token =='APPMHNOQAORYYVRTWZVRIJLVYPSCAWLJYUEYOVXKBEUJJRBUVERQHGLNDIEEESWS') {
            $firstname = APHTools::getValue('firstname');
            $lastname = APHTools::getValue('lastname');
            $bio = APHTools::getValue('bio');
            $id = (int) APHTools::getValue('user_id');



            if ($firstname =='') {
                APHTools::displayError('First Name is required');
            }

            if ($lastname =='') {
                APHTools::displayError('Last Name is required');
            }

            if (!$id >0) {
                APHTools::displayError('No custome id, refresh page');
            }

            $dataset = array('ID'=>$id, 'display_name'=>$firstname.' '.$lastname);
            $res = wp_update_user($dataset);
            if($res > 0) {
                update_user_meta($id, 'firstname', $firstname);
                update_user_meta($id, 'lastname', $lastname);
                update_user_meta($id, 'bio', $bio);

                APHTools::displaySuccess('Successfully updated user details');
            }
            APHTools::displayError('Did not succeed with the update process');
        } elseif ($request_token =='7C3249B783974BA9B2FBB2DF27DD0F13') {
        }
    }
}








new APHCustomerPage();

?>
