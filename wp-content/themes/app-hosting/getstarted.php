<?php
/**
 * Template Name: Get Started Page
 * Description: Get Started |  Registration
 *
 */
$pagefilename = basename(__FILE__);
function getCurrentPageFileName()
{
    global $pagefilename;
    return $pagefilename;
}
$authuser = wp_get_current_user();
if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0):
    get_header();
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHTools.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHPlan.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHCountry.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHAddress.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHDomain.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHDomainPrice.php';




    $countries = (new APHCountry())->getActives();

    $allplans = (new APHPlan())->getActivePlans();

    $addresses = (new APHAddress())->myOwn($authuser->ID);



    $hasaddress = 'No';
    if((new APHAddress())->checkIfUserHas($authuser->ID)) {
        $hasaddress = 'Yes';
    }
    ?>

   <body id="kt_body" class="app-blank">
        <!--begin::Theme mode setup on page load-->
        <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
        <!--end::Theme mode setup on page load-->
        <!--begin::Root-->
        <div class="d-flex flex-column flex-root" id="kt_app_root">
            <!--begin::Authentication - Multi-steps-->
            <div class="d-flex flex-column flex-lg-row flex-column-fluid stepper stepper-pills stepper-column stepper-multistep" id="ap_domain_host_order_process">
                <!--begin::Aside-->
                <div class="d-flex flex-column flex-lg-row-auto w-lg-350px w-xl-500px">
                    <div class="d-flex flex-column position-lg-fixed top-0 bottom-0 w-lg-350px w-xl-500px scroll-y bgi-size-cover bgi-position-center" style="background-image: url(<?php echo get_template_directory_uri();?>/assets/media/misc/bg.jpg)">
                        <!--begin::Header-->
                        <div class="d-flex flex-center py-10 py-lg-20 mt-lg-20">
                            <!--begin::Logo-->
                            <a href="<php get_page_link(11); ?>">
                                <img alt="Logo" src="<?php echo get_template_directory_uri();?>/assets/media/logos/dws.png" class="h-70px" />
                            </a>
                            <!--end::Logo-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="d-flex flex-row-fluid justify-content-center p-10">
                            <!--begin::Nav-->
                            <div class="stepper-nav">
                                <!--begin::Step 1-->
                                <div class="stepper-item current" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon rounded-3">
                                            <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">1</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title fs-2">Domain</h3>
                                            <div class="stepper-desc fw-normal">Your website domain name</div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 1-->
                                <!--begin::Step 2-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon rounded-3">
                                            <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">2</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title fs-2">Hosting /Plan Type</h3>
                                            <div class="stepper-desc fw-normal">Select Hosting or Plan Type</div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 2-->
                                <!--begin::Step 3-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon">
                                            <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">3</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title fs-2">Details</h3>
                                            <div class="stepper-desc fw-normal"> Hosting + Domain Details </div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 3-->
                                <!--begin::Step 4-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon">
                                            <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">4</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Payment </h3>
                                            <div class="stepper-desc fw-normal">Provide your payment info</div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Line-->
                                    <div class="stepper-line h-40px"></div>
                                    <!--end::Line-->
                                </div>
                                <!--end::Step 4-->
                                <!--begin::Step 5-->
                                <div class="stepper-item" data-kt-stepper-element="nav">
                                    <!--begin::Wrapper-->
                                    <div class="stepper-wrapper">
                                        <!--begin::Icon-->
                                        <div class="stepper-icon">
                                            <i class="ki-duotone ki-check fs-2 stepper-check"></i>
                                            <span class="stepper-number">5</span>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Label-->
                                        <div class="stepper-label">
                                            <h3 class="stepper-title">Account Setup</h3>
                                            <div class="stepper-desc fw-normal">Your account is created</div>
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 5-->
                            </div>
                            <!--end::Nav-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="d-flex flex-center flex-wrap px-5 py-10">
                            <!--begin::Links-->
                            <div class="d-flex fw-normal">
                                <a href="https://keenthemes.com" class="text-success px-5" target="_blank">Terms</a>
                                <a href="https://devs.keenthemes.com" class="text-success px-5" target="_blank">Plans</a>
                                <a href="https://1.envato.market/EA4JP" class="text-success px-5" target="_blank">Contact Us</a>
                            </div>
                            <!--end::Links-->
                        </div>
                        <!--end::Footer-->
                    </div>
                </div>
                <!--begin::Aside-->
                <!--begin::Body-->
                <div class="d-flex flex-column flex-lg-row-fluid py-10">
                    <!--begin::Content-->
                    <div class="d-flex flex-center flex-column flex-column-fluid">
                        <!--begin::Wrapper-->
                        <div class="w-lg-650px w-xl-700px p-10 p-lg-15 mx-auto">
                            <!--begin::Form-->
                            <form class="my-auto pb-5" method="post" id="ap_create_order_form">
                                <!--begin::Step 1-->
                                
                                <div class="current" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-15">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold d-flex align-items-center text-dark">Domain Name 
                                            <span class="ms-1" data-bs-toggle="tooltip" title="You can use existing domain name, register a new domain, or Transfer your domain to us">
                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span></h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6">You can use existing domain name, register a new domain, or Transfer your domain to us
                                            </div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->
                                       
                                        <!--begin::Input group-->
                                        <div class="fv-row">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-4 possible_error_line">
                                                    <!--begin::Option-->
                                                    <input type="radio" class="domain_type_change btn-check" name="domain_type" value="Existing" id="ap_existing_domain" />
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-10" for="ap_existing_domain">
                                                       
                                                        <!--begin::Info-->
                                                        <span class="d-block fw-semibold text-start">
                                                            <span class="text-dark fw-bold d-block fs-4 mb-2">Existing Domain</span>
                                                            <span class="text-muted fw-semibold fs-6">If you already have a registered domain name you want to use</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-lg-4 possible_error_line">
                                                    <!--begin::Option-->
                                                    <input type="radio" class="domain_type_change btn-check" name="domain_type" value="Transfer" id="ap_transfer_domain" />
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="ap_transfer_domain">
                                                       
                                                        <!--begin::Info-->
                                                        <span class="d-block fw-semibold text-start">
                                                            <span class="text-dark fw-bold d-block fs-4 mb-2">Transfer My Domain</span>
                                                            <span class="text-muted fw-semibold fs-6">If you already have a domain name and want to transfer to us</span>
                                                        </span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>


                                                    <div class="col-lg-4 possible_error_line">
                                                    <!--begin::Option-->
                                                    <input type="radio" class="domain_type_change btn-check" name="domain_type" value="Register" id="ap_register_domain" />
                                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="ap_register_domain">
                                                     
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


                                            <div class="row mb-10 display_none holding_domain_input_box">
                                                <div class="col-md-12">
                                                     
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
                             <div class="form-group domain_check_report_group display_none">
                             <button id="domain_availability_checker_btn" class="btn btn-primary btn-block">Check Domain Availability</button>
                              <div class="domain_check_response_box"></div>
                          </div>
                                                </div>
                                            </div>
                                            <!--end::Row-->


                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 1-->
                                <!--begin::Step 2-->
                                <div class="" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-15">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-dark">Hosting Information</h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6">Select from our flexible hosting options                      </div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center form-label mb-3">Filter hosting option by
                                            <span class="ms-1" data-bs-toggle="tooltip" title="Filter hosting options by your application type, e.g WordPress, Laravel">
                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span></label>
                                            <!--end::Label-->
                                            <!--begin::Row-->
                                            <div class="row mb-2" data-kt-buttons="true">
                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="hosting_option_filter btn btn-outline btn-outline-dashed btn-active-light-primary w-100">
                                                        <input type="radio" class="btn-check" name="hosting_filter_checkbox" value="Tenant" />
                                                        <span class="fw-bold">Tenant</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="hosting_option_filter btn btn-outline btn-outline-dashed btn-active-light-primary w-100">
                                                        <input type="radio" class="btn-check" name="hosting_filter_checkbox" value="Shared" />
                                                        <span class="fw-bold">Shared</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="hosting_option_filter btn btn-outline btn-outline-dashed btn-active-light-primary w-100">
                                                        <input type="radio" class="btn-check" name="hosting_filter_checkbox" value="Full" />
                                                        <span class="fw-bold">Full</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="hosting_option_filter btn btn-outline btn-outline-dashed btn-active-light-primary w-100">
                                                        <input type="radio" class="btn-check" name="hosting_filter_checkbox" value="WordPress" />
                                                        <span class="fw-bold">WordPress</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->

                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="hosting_option_filter btn btn-outline btn-outline-dashed btn-active-light-primary w-100">
                                                        <input type="radio" class="btn-check" name="hosting_filter_checkbox" value="PHP" />
                                                        <span class="fw-bold">PHP</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->

                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="hosting_option_filter btn btn-outline btn-outline-dashed btn-active-light-primary w-100">
                                                        <input type="radio" class="btn-check" name="hosting_filter_checkbox" value="NodeJS" />
                                                        <span class="fw-bold">NodeJS</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->

                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label class="hosting_option_filter btn btn-outline btn-outline-dashed btn-active-light-primary w-100">
                                                        <input type="radio" class="btn-check" name="hosting_filter_checkbox" value="OTHER" />
                                                        <span class="fw-bold">OTHER</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                            <!--begin::Hint-->
                                            <div class="form-text">Click on the filter box above to show the hosting plan by application type or hosting size</div>
                                            <!--end::Hint-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                       
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-0 fv-row possible_error_line">
                                            <!--begin::Label-->
                                            <label class="d-flex align-items-center form-label mb-5">Select Hosting Plan
                                            <span class="ms-1" data-bs-toggle="tooltip" title="Monthly billing will be based on your account plan">
                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span></label>
                                            <!--end::Label-->
                                            <!--begin::Options-->
                                            <div class="mb-0">

                                                 <?php
                                              if(count($allplans) >0):
                                                  foreach($allplans as $plan):

                                                      ?>
                                                <!--begin:Option-->
                                                <div data-apptype="<?php echo $plan->app_type; ?>" data-plantype="<?php echo $plan->plan_type; ?>" class="the_list_of_hosting_plan <?php echo $plan->app_type; ?> <?php echo $plan->plan_type; ?>">
                                                <label class="d-flex flex-stack mb-5 cursor-pointer">
                                                    <!--begin:Label-->
                                                    <span class="d-flex align-items-center me-2">
                                                        <!--begin::Icon-->
                                                        <span class="symbol symbol-50px me-6">
                                                            <span class="symbol-label">
                                                               <i class="fa-brands fa-<?php echo strtolower($plan->app_type); ?> larger-fa"></i>
                                                            </span>
                                                        </span>
                                                        <!--end::Icon-->
                                                        <!--begin::Description-->
                                                        <span class="d-flex flex-column">
                                                            <span class="fw-bold text-gray-800 text-hover-primary fs-5"><?php echo $plan->name; ?></span>
                                                            <span class="fs-6 fw-semibold text-muted"><?php echo $plan->description; ?></span>
                                                        </span>
                                                        <!--end:Description-->
                                                    </span>
                                                    <!--end:Label-->
                                                    <!--begin:Input-->
                                                    <span class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" name="hosting_plan" value="<?php echo $plan->id_plan; ?>" />
                                                    </span>
                                                    <!--end:Input-->
                                                </label>
                                            </div>

                                                <?php

                                                  endforeach;
                                              endif;
    ?>



                                                <!--end::Option-->
                                                <!--begin:Option-->
                                                
                                                <!--end::Option-->
                                                <!--begin:Option-->
                                                
                                            </div>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>



                                <!--end::Step 2-->
                                <!--begin::Step 3-->
                                <div class="" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-12">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-dark">Domain and Account Details</h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6">Provide details of your account and domain details.
                                            </div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->

                                        <input type="hidden" id="user_has_address" value="<?php echo $hasaddress; ?>" name="user_has_address">
                                         <?php if($hasaddress=="No"): ?>

                                            <div id="only_checkout_address_for_newuser" class="display_none">
                                                <?php include_once dirname(__FILE__).'/_default.php'; ?>
                                            </div>
                                           <?php else: ?>

                                                <?php
                                           if(count($addresses) >0): ?>

                                            <div class="form-group">
                                                <label for="id_existing_default_address">Select Existing Address</label>
                                                <select name="id_existing_default_address" class="form-control form-control-solid">
                                                <?php
                                                    foreach($addresses as $address): ?>
                                                        <option value="<?php echo $address->id_address; ?>"> <?php echo $address->name; ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                                
                                            <?php endif; ?>

                                         <?php endif; ?>



                                        <div id="domain_transfer_details" class="display_none">
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

                                        <div id="domain_new_registration_request_section" class="display_none">

                                        <div class="registrant_information_block">
                                                 <?php
                                           if(count($addresses) >0): ?>

                                            <div class="form-group">
                                                <label for="id_existing_reg_address">Select From Existing Address</label>
                                                <select name="id_existing_reg_address" class="form-control form-control-solid">
                                                <?php
                                                    foreach($addresses as $address): ?>
                                                        <option value="<?php echo $address->id_address; ?>"> <?php echo $address->name; ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                                <p class="text-center mb-5 pb-5"> OR</p>
                                            <?php endif; ?>
                                            <?php include_once dirname(__FILE__).'/_registrant.php'; ?>
                                        </div>
                                         <div class="form-group possible_error_line">
                                         <input type="checkbox" id="user_reg_for_admin" value="1" checked name="user_reg_for_admin"> Registrant information is same as administrator
                                        </div>
                                         <div class="administrator_information_block display_none">
                                                  <?php
                                           if(count($addresses) >0): ?>

                                            <div class="form-group">
                                                <label for="id_existing_admin_address">Select From Existing Address</label>
                                                <select name="id_existing_admin_address" class="form-control form-control-solid">
                                                <?php
                                                    foreach($addresses as $address): ?>
                                                        <option value="<?php echo $address->id_address; ?>"> <?php echo $address->name; ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                                <p class="text-center mb-5 pb-5"> OR</p>
                                            <?php endif; ?>
                                             <?php include_once dirname(__FILE__).'/_admin.php'; ?>
                                        </div>
                                        
                                        <div class="form-group possible_error_line">
                                        <input type="checkbox" id="user_reg_for_billing" value="1" checked name="user_reg_for_billing"> Registrant information is same as billing
                                         </div>
                                        <div class="billing_information_block display_none">
                                                 <?php
                                           if(count($addresses) >0): ?>

                                            <div class="form-group">
                                                <label for="id_existing_billing_address">Select From Existing Address</label>
                                                <select name="id_existing_billing_address" class="form-control form-control-solid">
                                                <?php
                                                    foreach($addresses as $address): ?>
                                                        <option value="<?php echo $address->id_address; ?>"> <?php echo $address->name; ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                                <p class="text-center mb-5 pb-5"> OR</p>
                                            <?php endif; ?>
                                             <?php include_once dirname(__FILE__).'/_billing.php'; ?>
                                        </div>
                                        
                                        <div class="form-group possible_error_line">
                                        <input type="checkbox" id="user_reg_for_tech" value="1" checked name="user_reg_for_tech"> Registrant information is same as technical info
                                        </div>
                                        <div class="technical_information_block display_none">
                                           
                                           <?php
                                           if(count($addresses) >0): ?>

                                            <div class="form-group">
                                                <label for="id_existing_tech_address">Select Existing Technical Address</label>
                                                <select name="id_existing_tech_address" class="form-control form-control-solid">
                                                <?php
                                                    foreach($addresses as $address): ?>
                                                        <option value="<?php echo $address->id_address; ?>"> <?php echo $address->name; ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                                <p class="text-center mb-5 pb-5"> OR</p>
                                            <?php endif; ?>


                                             <?php include_once dirname(__FILE__).'/_tech.php'; ?>
                                        </div>
                                    </div>



                                       
                                        
                                        
                                      
                             
                         
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 3-->
                                <!--begin::Step 4-->
                                <div class="" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-10 pb-lg-15">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-dark">Order Payment</h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6">Complete your order by making payment
                                           </div>
                                            <!--end::Notice-->
                                        </div>


                                        
                                        <!--end::Heading-->
                                        <div class="ap_holding_payment_section_checkout" style="opacity:0.3">
                                            <div class="form-group">
                                                 <input type="hidden" name="action" value="frontActionsBaseField"\>
                                               <input type="hidden" name="request_token" value="APPGTMPSNZDJGTWAXQHHEAQIQTKZKLTNSDPLQXJGSOIDJCAPUGOBCJMELZXSBLHJ"\>
                                            </div>

                                                                            <!--begin::Input group-->
                                        <div id="display_content_of_checkout_summary" class="table-responsive">

                                             <span id="far_loading_icon_positioned">
                                                <i class="fa-solid fa-spinner fa-2xl"></i>
                                            </span>


                                            <table class="table table-striped">
                                                <thead>
                                                    <th> Package</th>  <th> Price </th>  <th> Total </th>
                                                </thead>
                                                <tbody>
                                                    <tr> <td> Domain:  </td> <td class="possible_error_line"> Price: <input type="number" value="1" class="form-control" name="number_of_domain_years">  </td> <td>Total: </td> </tr>
                                                    <tr> <td> App Hosting:  </td> <td> Price:  </td> <td> </td> </tr>
                                                    <tr> <td colspan="3"> Total:  </td></tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        <!--end::Input group-->


                                    <div class="row mb-2 possible_error_line" data-kt-buttons="true">
                                                <!--begin::Col-->
                                                <div class="col-6">
                                                    <!--begin::Option-->
                                                    <label class="ap_select_payment_option_checkout btn btn-outline btn-outline-dashed btn-active-light-primary w-100">
                                                         <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 157 28"><defs></defs><g><path d="M22.32 2.663H1.306C.594 2.663 0 3.263 0 3.985v2.37c0 .74.594 1.324 1.307 1.324h21.012c.73 0 1.307-.602 1.324-1.323V4.002c0-.738-.594-1.34-1.323-1.34zm0 13.192H1.306a1.3 1.3 0 00-.924.388 1.33 1.33 0 00-.383.935v2.37c0 .74.594 1.323 1.307 1.323h21.012c.73 0 1.307-.584 1.324-1.322v-2.371c0-.739-.594-1.323-1.323-1.323zm-9.183 6.58H1.307c-.347 0-.68.139-.924.387a1.33 1.33 0 00-.383.935v2.37c0 .74.594 1.323 1.307 1.323H13.12c.73 0 1.307-.6 1.307-1.322v-2.371a1.29 1.29 0 00-1.29-1.323zM23.643 9.258H1.307c-.347 0-.68.14-.924.387a1.33 1.33 0 00-.383.936v2.37c0 .739.594 1.323 1.307 1.323h22.32c.73 0 1.306-.601 1.306-1.323v-2.37a1.301 1.301 0 00-1.29-1.323z" fill="#00C3F7"></path><path d="M48.101 8.005a6.927 6.927 0 00-2.274-1.563 7.041 7.041 0 00-2.716-.55 5.767 5.767 0 00-2.63.567c-.55.263-1.046.63-1.46 1.082V7.13a.876.876 0 00-.22-.567.721.721 0 00-.56-.258h-2.937a.697.697 0 00-.56.258.796.796 0 00-.221.567v19.566c0 .206.085.412.22.566a.776.776 0 00.56.224h2.971c.204 0 .39-.086.543-.224a.7.7 0 00.238-.566v-6.683c.424.464.967.808 1.561 1.014.781.292 1.596.43 2.427.43.95 0 1.884-.173 2.75-.55a6.859 6.859 0 002.308-1.58 7.45 7.45 0 001.562-2.457 8.34 8.34 0 00.577-3.213 8.761 8.761 0 00-.577-3.229A7.775 7.775 0 0048.1 8.005zm-2.681 7.077a3.33 3.33 0 01-.696 1.117 3.177 3.177 0 01-2.36 1.013c-.458 0-.899-.086-1.306-.275a3.324 3.324 0 01-1.07-.738 3.673 3.673 0 01-.713-1.117 3.837 3.837 0 010-2.748c.153-.412.408-.79.713-1.1a3.576 3.576 0 011.07-.755 2.888 2.888 0 011.306-.275c.459 0 .9.086 1.324.274.39.19.747.43 1.053.74.305.326.526.686.696 1.099a3.976 3.976 0 01-.017 2.765zm20.808-8.778h-2.953a.728.728 0 00-.543.24.823.823 0 00-.237.585v.36a4.143 4.143 0 00-1.341-1.03 5.652 5.652 0 00-2.58-.567 7.222 7.222 0 00-5.075 2.096 7.733 7.733 0 00-1.63 2.456 8.036 8.036 0 00-.61 3.23 8.15 8.15 0 00.61 3.23 7.88 7.88 0 001.613 2.456 6.959 6.959 0 005.058 2.112c.9.018 1.782-.171 2.597-.567.509-.257.984-.6 1.358-1.03v.395c0 .206.084.412.237.567.153.137.34.223.543.223h2.953a.855.855 0 00.56-.223.768.768 0 00.221-.567V7.129a.796.796 0 00-.22-.567.697.697 0 00-.56-.258zm-3.988 8.761a3.33 3.33 0 01-.696 1.117 3.83 3.83 0 01-1.052.755c-.832.378-1.8.378-2.631 0a3.575 3.575 0 01-1.07-.755 3.326 3.326 0 01-.695-1.117 3.976 3.976 0 010-2.731c.152-.412.39-.773.696-1.1.305-.309.661-.566 1.069-.755a3.194 3.194 0 012.63 0c.391.189.748.429 1.053.738.289.327.526.687.696 1.1.34.893.34 1.872 0 2.748zm33.437-1.77a4.794 4.794 0 00-1.443-.875 10.054 10.054 0 00-1.731-.516l-2.258-.446c-.577-.103-.984-.258-1.205-.447a.712.712 0 01-.305-.567c0-.24.136-.446.424-.618.39-.206.815-.31 1.256-.275.577 0 1.154.12 1.68.343.51.224 1.019.482 1.477.79.662.413 1.222.344 1.612-.12l1.087-1.236c.203-.207.322-.481.34-.773a1.06 1.06 0 00-.408-.773c-.459-.395-1.188-.825-2.156-1.237-.967-.412-2.19-.636-3.632-.636a8.343 8.343 0 00-2.597.378 6.273 6.273 0 00-1.986 1.03 4.552 4.552 0 00-1.273 1.564 4.417 4.417 0 00-.441 1.907c0 1.22.373 2.216 1.103 2.954.73.739 1.698 1.22 2.903 1.46l2.342.516c.51.086 1.018.24 1.494.464.254.103.424.36.424.652 0 .258-.136.498-.424.705-.289.206-.764.343-1.375.343a4.051 4.051 0 01-1.85-.412 6.792 6.792 0 01-1.51-.996 2.037 2.037 0 00-.68-.378c-.271-.086-.594 0-.95.292l-1.29.979a1.147 1.147 0 00-.458 1.134c.067.43.424.858 1.086 1.357a9.543 9.543 0 005.516 1.632 8.993 8.993 0 002.699-.378 6.83 6.83 0 002.087-1.048c.56-.43 1.036-.98 1.358-1.615a4.543 4.543 0 00.475-2.01 4.168 4.168 0 00-.373-1.82 4.638 4.638 0 00-1.018-1.323zm12.899 3.574a.857.857 0 00-.645-.43c-.271 0-.543.086-.764.24a2.43 2.43 0 01-1.205.396c-.136 0-.288-.017-.424-.052a.777.777 0 01-.39-.206 1.43 1.43 0 01-.323-.446 2.092 2.092 0 01-.136-.79v-5.36h3.836a.86.86 0 00.594-.258.77.77 0 00.255-.567V7.13a.773.773 0 00-.255-.584.833.833 0 00-.577-.24h-3.836v-3.66a.736.736 0 00-.237-.584.814.814 0 00-.544-.223h-2.987a.817.817 0 00-.577.223.838.838 0 00-.254.584v3.66h-1.698a.697.697 0 00-.56.257.876.876 0 00-.22.567v2.267c0 .206.084.413.22.567a.65.65 0 00.56.258h1.698v6.373a5.14 5.14 0 00.441 2.199 4.575 4.575 0 001.137 1.477c.475.395 1.035.67 1.612.842a6.125 6.125 0 001.851.275 7.73 7.73 0 002.427-.396 4.802 4.802 0 001.918-1.202.999.999 0 00.101-1.271l-1.018-1.65zm16.175-10.565h-2.953a.728.728 0 00-.543.24.822.822 0 00-.238.585v.36a4.13 4.13 0 00-1.341-1.03 5.67 5.67 0 00-2.596-.567 7.152 7.152 0 00-5.058 2.096 7.468 7.468 0 00-1.63 2.456 8.017 8.017 0 00-.611 3.212 8.156 8.156 0 00.611 3.23c.374.91.934 1.752 1.613 2.456a7.006 7.006 0 005.041 2.13 5.884 5.884 0 002.596-.55c.51-.257.985-.6 1.358-1.03v.378c.002.21.084.41.23.557a.783.783 0 00.551.233h2.97a.78.78 0 00.781-.773V7.13a.795.795 0 00-.221-.567.696.696 0 00-.56-.258zm-3.988 8.761a3.34 3.34 0 01-.696 1.117 3.83 3.83 0 01-1.053.755 2.907 2.907 0 01-1.323.275c-.459 0-.9-.103-1.307-.275a3.576 3.576 0 01-1.07-.755 3.34 3.34 0 01-.696-1.117 3.982 3.982 0 010-2.731 3.27 3.27 0 01.696-1.1c.306-.309.662-.566 1.07-.755a3.077 3.077 0 011.307-.275c.458 0 .899.086 1.323.274.391.19.747.43 1.053.74.305.326.543.686.696 1.099a3.67 3.67 0 010 2.748zm20.198 1.615l-1.698-1.306c-.322-.257-.628-.326-.899-.223a1.82 1.82 0 00-.628.447 6.03 6.03 0 01-1.29 1.168c-.509.292-1.07.43-1.647.395a3.165 3.165 0 01-1.855-.575 3.224 3.224 0 01-1.183-1.555 4.046 4.046 0 01-.237-1.34c0-.464.067-.928.237-1.374.153-.413.374-.79.679-1.1.306-.309.662-.567 1.052-.739a3.175 3.175 0 011.324-.291 3.06 3.06 0 011.647.412 5.61 5.61 0 011.29 1.168c.169.189.373.343.611.447.271.103.577.034.882-.224l1.698-1.288c.203-.138.373-.344.441-.584a.923.923 0 00-.068-.79 7.35 7.35 0 00-2.614-2.457c-1.12-.635-2.461-.962-3.955-.962a8.163 8.163 0 00-3.072.601 7.65 7.65 0 00-2.495 1.65 7.357 7.357 0 00-1.663 2.473 8.154 8.154 0 000 6.133c.39.927.95 1.769 1.663 2.456a7.876 7.876 0 005.567 2.25c1.494 0 2.835-.326 3.955-.962a7.307 7.307 0 002.631-2.473.886.886 0 00.068-.773 1.167 1.167 0 00-.441-.584zm15.716 3.057l-4.667-6.854 3.989-5.273a.978.978 0 00.169-.86c-.068-.205-.254-.429-.746-.429h-3.157a1.39 1.39 0 00-.527.12 1.058 1.058 0 00-.458.447l-3.191 4.467h-.764V.79a.794.794 0 00-.22-.567.78.78 0 00-.56-.223h-2.954a.856.856 0 00-.56.223.72.72 0 00-.237.567v19.48c0 .223.084.43.237.567a.778.778 0 00.56.223h2.954a.856.856 0 00.56-.223.794.794 0 00.22-.567v-5.153h.849l3.479 5.342c.204.378.595.618 1.019.618h3.31c.509 0 .712-.24.797-.446a.933.933 0 00-.102-.894zM83.015 6.304h-3.31a.852.852 0 00-.662.258 1.178 1.178 0 00-.305.55l-2.445 9.104H75.7l-2.613-9.104a1.54 1.54 0 00-.255-.533.756.756 0 00-.594-.275h-3.429c-.44 0-.712.138-.831.43-.085.257-.085.55 0 .807l4.192 12.798c.068.189.17.378.323.515.17.155.39.24.627.223h1.766l-.153.413-.39 1.185c-.12.36-.34.687-.645.927a1.58 1.58 0 01-.985.327c-.305 0-.61-.069-.882-.19a3.618 3.618 0 01-.781-.463 1.29 1.29 0 00-.747-.24h-.034a.908.908 0 00-.747.463l-1.052 1.546c-.424.67-.187 1.1.085 1.34a5.36 5.36 0 001.952 1.151 7.679 7.679 0 002.495.412c1.51 0 2.783-.412 3.75-1.236a7.067 7.067 0 002.122-3.333l4.855-15.838c.102-.275.119-.567.017-.842-.085-.189-.272-.395-.73-.395z" fill="#011B33"></path></g></svg>
                                                        <input type="radio" class="btn-check" name="payment_option_checkout" value="Paystack" />
                                                        <span class="fw-bold">Credit Card/Debit Card/</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>

                                                 <div class="col-6">
                                                    <!--begin::Option-->
                                                    <label class="ap_select_payment_option_checkout btn btn-outline btn-outline-dashed btn-active-light-primary w-100">
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

                                        
                                        <!--begin::Input group-->
                                    
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="d-flex flex-stack">
                                            <!--begin::Label-->
                                            <div class="me-5">
                                                <div class="fs-7 fw-semibold text-muted">Select your payment option above. If you select credit card payment, you will be redirected to the payment page.</div>
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                          
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 4-->
                                <!--begin::Step 5-->
                                <div class="" data-kt-stepper-element="content">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <!--begin::Heading-->
                                        <div class="pb-8 pb-lg-10">
                                            <!--begin::Title-->
                                            <h2 class="fw-bold text-dark">Order Process completed!</h2>
                                            <!--end::Title-->
                                            <!--begin::Notice-->
                                            <div class="text-muted fw-semibold fs-6">Complete your payment and your other will be processed. Once your order is processed, you will be informed by email.</div>
                                            <!--end::Notice-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Body-->
                                        <div class="mb-0">
                                            <!--begin::Text-->
                                            <div class="fs-6 text-gray-600 mb-5">Complete your payment, if you selected Bank Transfer as payment option. Pay to account details below. Include your domain name /Order reference / etc</div>
                                            <!--end::Text-->
                                            <!--begin::Alert-->
                                            <!--begin::Notice-->
                                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                                <!--begin::Icon-->
                                                <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1">
                                                    <!--begin::Content-->
                                                    <div class="fw-semibold">
                                                        <h4 class="text-gray-900 fw-bold">Payment Details</h4>
                                                        <div class="fs-6 text-gray-700">Bank: GTBank</div>
                                                        <div class="fs-6 text-gray-700">Account No: GTBank</div>
                                                        <div class="fs-6 text-gray-700">Account Name: Domains & Web Services</div>
                                                        <div class="fs-6 text-gray-700">Total: </div>
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Notice-->
                                            <!--end::Alert-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Step 5-->
                                <!--begin::Actions-->
                                <div class="d-flex flex-stack pt-15">
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                        <i class="ki-duotone ki-arrow-left fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Previous</button>
                                    </div>
                                    <div>
                                        <button type="button" id="ap_save_submit_get_started_btn" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
                                            <span class="indicator-label">Submit
                                            <i class="ki-duotone ki-arrow-right fs-4 ms-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i></span>
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                        <button disabled type="button" class="the_forward_continue_btn btn btn-lg btn-primary" data-kt-stepper-action="next">Continue
                                        <i class="ki-duotone ki-arrow-right fs-4 ms-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i></button>
                                    </div>
                                </div>
                                <!--end::Actions-->
                            </form>
                            
                            <!--end::Form-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Authentication - Multi-steps-->
        </div>
        <!--end::Root-->


         
        

        <script>var hostUrl = "<?php echo get_template_directory_uri();?>/assets/";</script>
        <!--begin::Global Javascript Bundle(mandatory for all pages)-->
        <script src="<?php echo get_template_directory_uri();?>/assets/plugins/global/plugins.bundle.js"></script>
        <script src="<?php echo get_template_directory_uri();?>/assets/js/scripts.bundle.js"></script>
        
       
    <?php

            wp_footer();
?>
</body>
</html>
<?php

else:
    wp_redirect(get_page_link(13));
    exit;


endif;
?>