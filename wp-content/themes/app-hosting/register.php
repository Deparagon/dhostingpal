<?php
/**
 * Template Name:  Register Domain
 * Description: The app hosting register.
 *
 */

$authuser = wp_get_current_user();
if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0):
    get_header();
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHPlan.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHCountry.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHAddress.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHDomain.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHDomainPrice.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHOrder.php';

    require_once(dirname(__FILE__).'/after_header.php');
    $ins_order = new APHOrder();
    $ins_domain = new APHDomain();
    ?>

<form method="post" action="" id="domain_registration_payment_process">  
<div class="fv-row">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                               
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-lg-6">
                                                    <!--begin::Option-->
                                                    <input type="radio" class="ap_domain_type_change btn-check" name="domain_type" value="Transfer" id="ap_transfer_domain_only">
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="ap_transfer_domain_only">
                                                       
                                                        <!--begin::Info-->
                                                        <span class="d-block fw-semibold text-start">
                                                            <span class="text-dark fw-bold d-block fs-4 mb-2">Transfer My Domain</span>
                                                            <span class="text-muted fw-semibold fs-6">If you already have a domain name and want to transfer to us</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>


                                                    <div class="col-lg-6">
                                                    <!--begin::Option-->
                                                    <input type="radio" class="ap_domain_type_change btn-check" name="domain_type" value="Register" id="ap_register_domain_only"/>
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="ap_register_domain_only">
                                                     
                                                        <!--begin::Info-->
                                                        <span class="d-block fw-semibold text-start">
                                                            <span class="text-dark fw-bold d-block fs-4 mb-2">Register My Domain</span>
                                                            <span class="text-muted fw-semibold fs-6">If you want to register a new domain with us</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>


                                                <!--end::Col-->
                                            </div>


                                            <div class="row mb-10 display_none ap_holding_domain_input_box">
                                                <div class="col-md-3 col-12"></div>
                                                <div class="col-md-6 col-12">
                                                     
                                                     <div class="d-flex flex-column mb-7 possible_error_line fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                    <span class="required">Enter your domain name</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" aria-label="Specify a card holder's name" data-bs-original-title="Specify a card holder's name" data-kt-initialized="1">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <input type="text" id="domain_name" class="form-control form-control-solid" placeholder="mynewdomain.com" name="domain_name" value="mynewdomain.com">
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                             <div class="form-group ap_domain_check_report_group display_none"><center>
                                 <button id="domain_availability_checker_btn" class="btn btn-primary btn-block">Check Domain Availability</button>
                             </center>

                             
                              <div class="ap_domain_check_response_box"></div>
                          </div>
                                                </div>
                                            </div>
                                            <!--end::Row-->


                                        </div>




	<div id="report_ajax_domain_progress_sucess"></div>
   
  

     <div class="ap_bank_payment_details_dws display_none">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr> <td> <strong>Bank:</strong> </td> <td> GTBank </td></tr>
                        <tr> <td> <strong>Account Name:</strong> </td> <td> Domains & Web Services </td></tr>
                        <tr> <td> <strong>Account Number:</strong> </td> <td> 012 </td></tr>
                    </tbody>
                    
                </table>
            </div>
     </div>

    <div class="ap_proceed_buttons mt-40">
        <div class="row">
            <div class="col-sm-3 col-12">
                <div class="form-group">
                    <button class="btn btn-active-light-primary btn-block">Previous </button>
                </div>
            </div>
            <div class="col-sm-6 col-12"></div>
            <div class="col-sm-3 col-12">
                <div class="form-group">
                    <button id="proceed_to_next_action" class="btn btn-primary btn-block">Proceed </button>
                     <button id="proceed_to_domain_registration_only" class="btn btn-primary btn-block display_none">Submit </button>
                </div>
            </div>
        </div>
    </div>

  </form>
<?php
            require_once(dirname(__FILE__).'/before_footer.php');

    get_footer();

else:

    wp_redirect(get_page_link(13));
    exit;

endif;

?>