<?php
/**
 * Template Name:  My Profile
 * Description: The app hosting profile.
 *
 */

$authuser = wp_get_current_user();
if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0):
    get_header();
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHPlan.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHCountry.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHAddress.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHDomain.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHTicket.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHOrder.php';

    require_once(dirname(__FILE__).'/after_header.php');
    $ins_order = new APHOrder();
    $ins_domain = new APHDomain();
    $a_instance = new APHAddress();
    $t_instance = new APHTicket();
    $billingaddress = $a_instance->firstBillingAddress($authuser->ID, 'Billing');

    $countorders = $ins_order->countByUserId($authuser->ID);
    $countdomains = $ins_domain->countByUserId($authuser->ID);

    $countactivedomains = $ins_domain->countActiveByUserId($authuser->ID);

    $countactiveorders = $ins_order->countActiveByUserId($authuser->ID);

    $counttickets = $t_instance->countByUserId($authuser->ID);

    ?>

   



                                    <!--begin::Navbar-->
                                    <div class="card mb-5 mb-xl-10">
                                        <div class="card-body pt-9 pb-0">
                                            <!--begin::Details-->
                                            <div class="d-flex flex-wrap flex-sm-nowrap">
                                              
                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <!--begin::Title-->
                                                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-column">
                                                            <!--begin::Name-->
                                                            <div class="d-flex align-items-center mb-2">
                                                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?php echo $authuser->user_firstname.' '. $authuser->user_lastname; ?></a>
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
                                                                </i><?php if(is_object($billingaddress)):
                                                                    echo $billingaddress->address;
                                                                endif; ?>
                                                                </a>
                                                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                                <i class="ki-duotone ki-sms fs-4">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i><?php echo $authuser->user_email; ?></a>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::Actions-->
                                                        <div class="d-flex my-4">
                                                            <a href="#" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
                                                                <i class="fa-solid fa-globe fs-5"></i>
                                                                <!--begin::Indicator label-->
                                                                <span class="indicator-label">My Domains</span>
                                                                <!--end::Indicator label-->
                                                                <!--begin::Indicator progress-->
                                                                <span class="indicator-progress">Please wait...
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                                <!--end::Indicator progress-->
                                                            </a>
                                                            <a href="<?php echo get_page_link(32); ?>" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_offer_a_deal">My Orders</a>
                                                            <!--begin::Menu-->
                                                            <div class="me-0">
                                                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                                    <i class="ki-solid ki-dots-horizontal fs-2x"></i>
                                                                </button>
                                                                <!--begin::Menu 3-->
                                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                                                    <!--begin::Heading-->
                                                                    <div class="menu-item px-3">
                                                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Services</div>
                                                                    </div>
                                                                    <!--end::Heading-->
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3">
                                                                        <a href="<?php echo get_page_link(15); ?>" class="menu-link px-3">Add New Order</a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                    
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3">
                                                                        <a href="<?php echo get_page_link(30); ?>" class="menu-link px-3">My Addresses</a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                    
                                                                    <!--begin::Menu item-->
                                                                    <div class="menu-item px-3 my-1">
                                                                        <a href="<?php echo get_page_link(36); ?>" class="menu-link px-3">Support Tickets</a>
                                                                    </div>
                                                                    <!--end::Menu item-->
                                                                </div>
                                                                <!--end::Menu 3-->
                                                            </div>
                                                            <!--end::Menu-->
                                                        </div>
                                                        <!--end::Actions-->
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
                                                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo $countorders; ?>" data-kt-countup-prefix="">0</div>
                                                                    </div>
                                                                    <!--end::Number-->
                                                                    <!--begin::Label-->
                                                                    <div class="fw-semibold fs-6 text-gray-400">Orders</div>
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
                                                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo $countdomains; ?>">0</div>
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
                                                                        <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo $counttickets; ?>" data-kt-countup-prefix="">0</div>
                                                                    </div>
                                                                    <!--end::Number-->
                                                                    <!--begin::Label-->
                                                                    <div class="fw-semibold fs-6 text-gray-400">Tickets</div>
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
                                                                <span class="fw-bold fs-6"><?php if($countorders >0) {
                                                                    echo '100%';
                                                                } else {
                                                                    echo '50%';
                                                                }
?>
                                                                </span>
                                                            </div>
                                                            <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                                <div class="bg-success rounded h-5px" role="progressbar" style="width:<?php if($countorders >0): echo '100%';
                                                                else: echo '50%';endif;
?>
                                                                "aria-valuenow="<?php if($countorders >0): echo '100';
                                                                else: echo '50';endif ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <!--end::Progress-->
                                                    </div>
                                                    <!--end::Stats-->
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Details-->
                                            

                                        </div>
                                    </div>
                                    <!--end::Navbar-->
                                    <!--begin::Basic info-->
                                    <div class="card mb-5 mb-xl-10">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                                            <!--begin::Card title-->
                                            <div class="card-title m-0">
                                                <h3 class="fw-bold m-0">Profile Details</h3>
                                            </div>
                                            <!--end::Card title-->
                                        </div>
                                        <!--begin::Card header-->
                                        <!--begin::Content-->
                                        <div id="ap_account_settings_profile_details" class="collapse show">
                                            <!--begin::Form-->
                                            <form id="ap_account_profile_details_form" method="post" class="form">
                                                <!--begin::Card body-->
                                                <div class="card-body border-top p-9">
                                                    <!--begin::Input group-->
                                                 
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="row mb-6">
                                                        <!--begin::Label-->
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
                                                        <!--end::Label-->
                                                        <!--begin::Col-->
                                                        <div class="col-lg-8">
                                                            <!--begin::Row-->
                                                            <div class="row">
                                                                <!--begin::Col-->
                                                                <div class="col-lg-6 fv-row">
                                                                    <input type="text" name="user_firstname" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="<?php echo $authuser->user_firstname; ?>" />
                                                                </div>
                                                                <!--end::Col-->
                                                                <!--begin::Col-->
                                                                <div class="col-lg-6 fv-row">
                                                                    <input type="text" name="user_lastname" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="<?php echo $authuser->user_lastname; ?>" />
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                                                            <!--end::Row-->
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Input group-->
                                                    
                                                    <!--begin::Input group-->
                                                    <div class="row mb-6">
                                                        <!--begin::Label-->
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            <span class="required">Contact Phone</span>
                                                            <span class="ms-1" data-bs-toggle="tooltip" title="Phone number must be active">
                                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>
                                                            </span>
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Col-->
                                                        <div class="col-lg-8 fv-row">
                                                            <input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="<?php echo get_user_meta($authuser->ID, 'phone', true); ?>" />
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Input group-->
                                                  
                                                    
                                                  
                                               
                                            
                                                </div>
                                                <!--end::Card body-->
                                                <!--begin::Actions-->
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                                                    <button type="submit" class="btn btn-primary" id="ap_account_profile_details_submit">Save Changes</button>
                                                </div>
                                                <!--end::Actions-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Basic info-->
                                    <!--begin::Sign-in Method-->
                                    <div class="card mb-5 mb-xl-10">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                                            <div class="card-title m-0">
                                                <h3 class="fw-bold m-0">Sign-in Method</h3>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Content-->
                                        <div id="kt_account_settings_signin_method" class="collapse show">
                                            <!--begin::Card body-->
                                            <div class="card-body border-top p-9">
                                                <!--begin::Email Address-->
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <!--begin::Label-->
                                                    <div id="kt_signin_email">
                                                        <div class="fs-6 fw-bold mb-1">Email Address</div>
                                                        <div class="fw-semibold text-gray-600">support@keenthemes.com</div>
                                                    </div>
                                                    <!--end::Label-->
                                                    <!--begin::Edit-->
                                                    <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                                                        <!--begin::Form-->
                                                        <form id="kt_signin_change_email" class="form" novalidate="novalidate">
                                                            <div class="row mb-6">
                                                                <div class="col-lg-6 mb-4 mb-lg-0">
                                                                    <div class="fv-row mb-0">
                                                                        <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter New Email Address</label>
                                                                        <input type="email" class="form-control form-control-lg form-control-solid" id="emailaddress" placeholder="Email Address" name="emailaddress" value="support@keenthemes.com" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="fv-row mb-0">
                                                                        <label for="confirmemailpassword" class="form-label fs-6 fw-bold mb-3">Confirm Password</label>
                                                                        <input type="password" class="form-control form-control-lg form-control-solid" name="confirmemailpassword" id="confirmemailpassword" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex">
                                                                <button id="kt_signin_submit" type="button" class="btn btn-primary me-2 px-6">Update Email</button>
                                                                <button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                                                            </div>
                                                        </form>
                                                        <!--end::Form-->
                                                    </div>
                                                    <!--end::Edit-->
                                                    <!--begin::Action-->
                                                    <div id="kt_signin_email_button" class="ms-auto">
                                                        <button class="btn btn-light btn-active-light-primary">Change Email</button>
                                                    </div>
                                                    <!--end::Action-->
                                                </div>
                                                <!--end::Email Address-->
                                                <!--begin::Separator-->
                                                <div class="separator separator-dashed my-6"></div>
                                                <!--end::Separator-->
                                                <!--begin::Password-->
                                                <div class="d-flex flex-wrap align-items-center mb-10">
                                                    <!--begin::Label-->
                                                    <div id="kt_signin_password">
                                                        <div class="fs-6 fw-bold mb-1">Password</div>
                                                        <div class="fw-semibold text-gray-600">************</div>
                                                    </div>
                                                    <!--end::Label-->
                                                    <!--begin::Edit-->
                                                    <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                                                        <!--begin::Form-->
                                                        <form id="kt_signin_change_password" class="form" novalidate="novalidate">
                                                            <div class="row mb-1">
                                                                <div class="col-lg-4">
                                                                    <div class="fv-row mb-0">
                                                                        <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Current Password</label>
                                                                        <input type="password" class="form-control form-control-lg form-control-solid" name="currentpassword" id="currentpassword" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="fv-row mb-0">
                                                                        <label for="newpassword" class="form-label fs-6 fw-bold mb-3">New Password</label>
                                                                        <input type="password" class="form-control form-control-lg form-control-solid" name="newpassword" id="newpassword" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="fv-row mb-0">
                                                                        <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Confirm New Password</label>
                                                                        <input type="password" class="form-control form-control-lg form-control-solid" name="confirmpassword" id="confirmpassword" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-text mb-5">Password must be at least 8 character and contain symbols</div>
                                                            <div class="d-flex">
                                                                <button id="kt_password_submit" type="button" class="btn btn-primary me-2 px-6">Update Password</button>
                                                                <button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                                                            </div>
                                                        </form>
                                                        <!--end::Form-->
                                                    </div>
                                                    <!--end::Edit-->
                                                    <!--begin::Action-->
                                                    <div id="kt_signin_password_button" class="ms-auto">
                                                        <button class="btn btn-light btn-active-light-primary">Reset Password</button>
                                                    </div>
                                                    <!--end::Action-->
                                                </div>
                                                <!--end::Password-->
                                                <!--begin::Notice-->
                                                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                                                    <!--begin::Icon-->
                                                    <i class="ki-duotone ki-shield-tick fs-2tx text-primary me-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    <!--end::Icon-->
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                        <!--begin::Content-->
                                                        <div class="mb-3 mb-md-0 fw-semibold">
                                                            <h4 class="text-gray-900 fw-bold">Secure Your Account</h4>
                                                            <div class="fs-6 text-gray-700 pe-7">Two-factor authentication adds an extra layer of security to your account. To log in, in addition you'll need to provide a 6 digit code</div>
                                                        </div>
                                                        <!--end::Content-->
                                                        <!--begin::Action-->
                                                        <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap" data-bs-toggle="modal" data-bs-target="#kt_modal_two_factor_authentication">Enable</a>
                                                        <!--end::Action-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Notice-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Sign-in Method-->
                                    <!--begin::Connected Accounts-->
                                    <div class="card mb-5 mb-xl-10">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_connected_accounts" aria-expanded="true" aria-controls="kt_account_connected_accounts">
                                            <div class="card-title m-0">
                                                <h3 class="fw-bold m-0">Connected Accounts</h3>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Content-->
                                        <div id="kt_account_settings_connected_accounts" class="collapse show">
                                            <!--begin::Card body-->
                                            <div class="card-body border-top p-9">
                                                <!--begin::Notice-->
                                                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                                                    <!--begin::Icon-->
                                                    <i class="ki-duotone ki-design-1 fs-2tx text-primary me-4"></i>
                                                    <!--end::Icon-->
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-stack flex-grow-1">
                                                        <!--begin::Content-->
                                                        <div class="fw-semibold">
                                                            <div class="fs-6 text-gray-700">Two-factor authentication adds an extra layer of security to your account. To log in, in you'll need to provide a 4 digit amazing code.
                                                            <a href="#" class="fw-bold">Learn More</a></div>
                                                        </div>
                                                        <!--end::Content-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Notice-->
                                                <!--begin::Items-->
                                                <div class="py-2">
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <img src="assets/media/svg/brand-logos/google-icon.svg" class="w-30px me-6" alt="" />
                                                            <div class="d-flex flex-column">
                                                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">Google</a>
                                                                <div class="fs-6 fw-semibold text-gray-400">Plan properly your workflow</div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <div class="form-check form-check-solid form-check-custom form-switch">
                                                                <input class="form-check-input w-45px h-30px" type="checkbox" id="googleswitch" checked="checked" />
                                                                <label class="form-check-label" for="googleswitch"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Item-->
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <img src="assets/media/svg/brand-logos/github.svg" class="w-30px me-6" alt="" />
                                                            <div class="d-flex flex-column">
                                                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">Github</a>
                                                                <div class="fs-6 fw-semibold text-gray-400">Keep eye on on your Repositories</div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <div class="form-check form-check-solid form-check-custom form-switch">
                                                                <input class="form-check-input w-45px h-30px" type="checkbox" id="githubswitch" checked="checked" />
                                                                <label class="form-check-label" for="githubswitch"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Item-->
                                                    <div class="separator separator-dashed my-5"></div>
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <div class="d-flex">
                                                            <img src="assets/media/svg/brand-logos/slack-icon.svg" class="w-30px me-6" alt="" />
                                                            <div class="d-flex flex-column">
                                                                <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">Slack</a>
                                                                <div class="fs-6 fw-semibold text-gray-400">Integrate Projects Discussions</div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <div class="form-check form-check-solid form-check-custom form-switch">
                                                                <input class="form-check-input w-45px h-30px" type="checkbox" id="slackswitch" />
                                                                <label class="form-check-label" for="slackswitch"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Item-->
                                                </div>
                                                <!--end::Items-->
                                            </div>
                                            <!--end::Card body-->
                                            <!--begin::Card footer-->
                                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                <button class="btn btn-light btn-active-light-primary me-2">Discard</button>
                                                <button class="btn btn-primary">Save Changes</button>
                                            </div>
                                            <!--end::Card footer-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Connected Accounts-->
                                    <!--begin::Notifications-->
                                    <div class="card mb-5 mb-xl-10">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_email_preferences" aria-expanded="true" aria-controls="kt_account_email_preferences">
                                            <div class="card-title m-0">
                                                <h3 class="fw-bold m-0">Email Preferences</h3>
                                            </div>
                                        </div>
                                        <!--begin::Card header-->
                                        <!--begin::Content-->
                                        <div id="kt_account_settings_email_preferences" class="collapse show">
                                            <!--begin::Form-->
                                            <form class="form">
                                                <!--begin::Card body-->
                                                <div class="card-body border-top px-9 py-9">
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" value="1" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label d-flex flex-column align-items-start">
                                                            <span class="fw-bold fs-5 mb-0">Successful Payments</span>
                                                            <span class="text-muted fs-6">Receive a notification for every successful payment.</span>
                                                        </span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <div class="separator separator-dashed my-6"></div>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" checked="checked" value="1" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label d-flex flex-column align-items-start">
                                                            <span class="fw-bold fs-5 mb-0">Payouts</span>
                                                            <span class="text-muted fs-6">Receive a notification for every initiated payout.</span>
                                                        </span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <div class="separator separator-dashed my-6"></div>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" value="1" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label d-flex flex-column align-items-start">
                                                            <span class="fw-bold fs-5 mb-0">Fee Collection</span>
                                                            <span class="text-muted fs-6">Receive a notification each time you collect a fee from sales</span>
                                                        </span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <div class="separator separator-dashed my-6"></div>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" checked="checked" value="1" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label d-flex flex-column align-items-start">
                                                            <span class="fw-bold fs-5 mb-0">Customer Payment Dispute</span>
                                                            <span class="text-muted fs-6">Receive a notification if a payment is disputed by a customer and for dispute purposes.</span>
                                                        </span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <div class="separator separator-dashed my-6"></div>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" value="1" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label d-flex flex-column align-items-start">
                                                            <span class="fw-bold fs-5 mb-0">Refund Alerts</span>
                                                            <span class="text-muted fs-6">Receive a notification if a payment is stated as risk by the Finance Department.</span>
                                                        </span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <div class="separator separator-dashed my-6"></div>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" checked="checked" value="1" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label d-flex flex-column align-items-start">
                                                            <span class="fw-bold fs-5 mb-0">Invoice Payments</span>
                                                            <span class="text-muted fs-6">Receive a notification if a customer sends an incorrect amount to pay their invoice.</span>
                                                        </span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <div class="separator separator-dashed my-6"></div>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" value="1" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label d-flex flex-column align-items-start">
                                                            <span class="fw-bold fs-5 mb-0">Webhook API Endpoints</span>
                                                            <span class="text-muted fs-6">Receive notifications for consistently failing webhook API endpoints.</span>
                                                        </span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Card body-->
                                                <!--begin::Card footer-->
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <button class="btn btn-light btn-active-light-primary me-2">Discard</button>
                                                    <button class="btn btn-primary px-6">Save Changes</button>
                                                </div>
                                                <!--end::Card footer-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Notifications-->
                                    <!--begin::Notifications-->
                                    <div class="card mb-5 mb-xl-10">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_notifications" aria-expanded="true" aria-controls="kt_account_notifications">
                                            <div class="card-title m-0">
                                                <h3 class="fw-bold m-0">Notifications</h3>
                                            </div>
                                        </div>
                                        <!--begin::Card header-->
                                        <!--begin::Content-->
                                        <div id="kt_account_settings_notifications" class="collapse show">
                                            <!--begin::Form-->
                                            <form class="form">
                                                <!--begin::Card body-->
                                                <div class="card-body border-top px-9 pt-3 pb-4">
                                                    <!--begin::Table-->
                                                    <div class="table-responsive">
                                                        <table class="table table-row-dashed border-gray-300 align-middle gy-6">
                                                            <tbody class="fs-6 fw-semibold">
                                                                <!--begin::Table row-->
                                                                <tr>
                                                                    <td class="min-w-250px fs-4 fw-bold">Notifications</td>
                                                                    <td class="w-125px">
                                                                        <div class="form-check form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="" id="kt_settings_notification_email" checked="checked" data-kt-check="true" data-kt-check-target="[data-kt-settings-notification=email]" />
                                                                            <label class="form-check-label ps-2" for="kt_settings_notification_email">Email</label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="w-125px">
                                                                        <div class="form-check form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="" id="kt_settings_notification_phone" checked="checked" data-kt-check="true" data-kt-check-target="[data-kt-settings-notification=phone]" />
                                                                            <label class="form-check-label ps-2" for="kt_settings_notification_phone">Phone</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <!--begin::Table row-->
                                                                <!--begin::Table row-->
                                                                <tr>
                                                                    <td>Billing Updates</td>
                                                                    <td>
                                                                        <div class="form-check form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="1" id="billing1" checked="checked" data-kt-settings-notification="email" />
                                                                            <label class="form-check-label ps-2" for="billing1"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-check form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="" id="billing2" checked="checked" data-kt-settings-notification="phone" />
                                                                            <label class="form-check-label ps-2" for="billing2"></label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <!--begin::Table row-->
                                                                <!--begin::Table row-->
                                                                <tr>
                                                                    <td>New Team Members</td>
                                                                    <td>
                                                                        <div class="form-check form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="" id="team1" checked="checked" data-kt-settings-notification="email" />
                                                                            <label class="form-check-label ps-2" for="team1"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-check form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="" id="team2" data-kt-settings-notification="phone" />
                                                                            <label class="form-check-label ps-2" for="team2"></label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <!--begin::Table row-->
                                                                <!--begin::Table row-->
                                                                <tr>
                                                                    <td>Completed Projects</td>
                                                                    <td>
                                                                        <div class="form-check form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="" id="project1" data-kt-settings-notification="email" />
                                                                            <label class="form-check-label ps-2" for="project1"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-check form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="" id="project2" checked="checked" data-kt-settings-notification="phone" />
                                                                            <label class="form-check-label ps-2" for="project2"></label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <!--begin::Table row-->
                                                                <!--begin::Table row-->
                                                                <tr>
                                                                    <td class="border-bottom-0">Newsletters</td>
                                                                    <td class="border-bottom-0">
                                                                        <div class="form-check form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="" id="newsletter1" data-kt-settings-notification="email" />
                                                                            <label class="form-check-label ps-2" for="newsletter1"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="border-bottom-0">
                                                                        <div class="form-check form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="" id="newsletter2" data-kt-settings-notification="phone" />
                                                                            <label class="form-check-label ps-2" for="newsletter2"></label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <!--begin::Table row-->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--end::Table-->
                                                </div>
                                                <!--end::Card body-->
                                                <!--begin::Card footer-->
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <button class="btn btn-light btn-active-light-primary me-2">Discard</button>
                                                    <button class="btn btn-primary px-6">Save Changes</button>
                                                </div>
                                                <!--end::Card footer-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Notifications-->
                                    <!--begin::Deactivate Account-->
                                    <div class="card">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
                                            <div class="card-title m-0">
                                                <h3 class="fw-bold m-0">Deactivate Account</h3>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Content-->
                                        <div id="kt_account_settings_deactivate" class="collapse show">
                                            <!--begin::Form-->
                                            <form id="kt_account_deactivate_form" class="form">
                                                <!--begin::Card body-->
                                                <div class="card-body border-top p-9">
                                                    <!--begin::Notice-->
                                                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
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
                                                                <h4 class="text-gray-900 fw-bold">You Are Deactivating Your Account</h4>
                                                                <div class="fs-6 text-gray-700">For extra security, this requires you to confirm your email or phone number when you reset yousignr password.
                                                                <br />
                                                                <a class="fw-bold" href="#">Learn more</a></div>
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Notice-->
                                                    <!--begin::Form input row-->
                                                    <div class="form-check form-check-solid fv-row">
                                                        <input name="deactivate" class="form-check-input" type="checkbox" value="" id="deactivate" />
                                                        <label class="form-check-label fw-semibold ps-2 fs-6" for="deactivate">I confirm my account deactivation</label>
                                                    </div>
                                                    <!--end::Form input row-->
                                                </div>
                                                <!--end::Card body-->
                                                <!--begin::Card footer-->
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <button id="kt_account_deactivate_account_submit" type="submit" class="btn btn-danger fw-semibold">Deactivate Account</button>
                                                </div>
                                                <!--end::Card footer-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Deactivate Account-->

	



<?php
            require_once(dirname(__FILE__).'/before_footer.php');

get_footer();

else:

    wp_redirect(get_page_link(13));
    exit;

endif;

?>