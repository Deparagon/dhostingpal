<?php
/**
 * Template Name:  Contact Us
 * Description: The app hosting contact us.
 *
 */

$authuser = wp_get_current_user();
if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0):
    wp_redirect(get_page_link(36));
    exit;
endif;

// go go support
get_header();
require_once WP_PLUGIN_DIR.'/apphosting/classes/APHTicket.php';
require_once(dirname(__FILE__).'/after_header.php');
?>


<!--begin::Contact-->
                                    <div class="card">
                                        <!--begin::Body-->
                                        <div class="card-body p-lg-17">
                                            <!--begin::Row-->
                                            <div class="row mb-3">
                                                <!--begin::Col-->
                                                <div class="col-md-12 pe-lg-10">
                                                    <!--begin::Form-->
                                                    <form action="" class="form mb-15" method="post" id="ap_contact_form">
                                                        <h1 class="fw-bold text-dark mb-9">Send Us Email</h1>
                                                        <!--begin::Input group-->
                                                        <div class="row mb-5">
                                                            <!--begin::Col-->
                                                            <div class="col-md-6 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fs-5 fw-semibold mb-2">Name (Firstname & Lastname)</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" placeholder="" name="fullname" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Col-->
                                                            <!--begin::Col-->
                                                            <div class="col-md-6 fv-row">
                                                                <!--end::Label-->
                                                                <label class="fs-5 fw-semibold mb-2">Email</label>
                                                                <!--end::Label-->
                                                                <!--end::Input-->
                                                                <input type="text" class="form-control form-control-solid" placeholder="" name="email" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="d-flex flex-column mb-5 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fs-5 fw-semibold mb-2">Subject</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input class="form-control form-control-solid" placeholder="Subject / Title" name="subject" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="d-flex flex-column mb-10 fv-row">
                                                            <label class="fs-6 fw-semibold mb-2">Message</label>
                                                            <textarea class="form-control form-control-solid" rows="6" name="message" placeholder=""></textarea>
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Submit-->
                                                        <button type="submit" class="btn btn-primary" id="ap_contact_submit_button">
                                                            <!--begin::Indicator label-->
                                                            <span class="indicator-label">Send Feedback</span>
                                                            <!--end::Indicator label-->
                                                            <!--begin::Indicator progress-->
                                                            <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            <!--end::Indicator progress-->
                                                        </button>
                                                        <!--end::Submit-->
                                                    </form>
                                                    <!--end::Form-->
                                                </div>
                                                <!--end::Col-->
                                               
                                            </div>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <div class="row g-5 mb-5 mb-lg-15">
                                                <!--begin::Col-->
                                                <div class="col-sm-6 pe-lg-10">
                                                    <!--begin::Phone-->
                                                    <div class="bg-light card-rounded d-flex flex-column flex-center flex-center p-10 h-100">
                                                        <!--begin::Icon-->
                                                        <i class="ki-duotone ki-briefcase fs-3tx text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <!--end::Icon-->
                                                        <!--begin::Subtitle-->
                                                        <h1 class="text-dark fw-bold my-5">Call Us Now</h1>
                                                        <!--end::Subtitle-->
                                                        <!--begin::Number-->
                                                        <div class="text-gray-700 fw-semibold fs-2">+234 5996 51 61</div>
                                                        <!--end::Number-->
                                                    </div>
                                                    <!--end::Phone-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col-sm-6 ps-lg-10">
                                                    <!--begin::Address-->
                                                    <div class="text-center bg-light card-rounded d-flex flex-column flex-center p-10 h-100">
                                                        <!--begin::Icon-->
                                                        <i class="ki-duotone ki-geolocation fs-3tx text-primary">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <!--end::Icon-->
                                                        <!--begin::Subtitle-->
                                                        <h1 class="text-dark fw-bold my-5">Our Head Office</h1>
                                                        <!--end::Subtitle-->
                                                        <!--begin::Description-->
                                                        <div class="text-gray-700 fs-3 fw-semibold">Domains & Web Services, Gbongan Express Way Osogbo, Osun State, Nigeria</div>
                                                        <!--end::Description-->
                                                    </div>
                                                    <!--end::Address-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                            <!--begin::Card-->
                                            <div class="card mb-4 bg-light text-center">
                                                <!--begin::Body-->
                                                <div class="card-body py-12">
                                                    <!--begin::Icon-->
                                                    <a href="https://facebook.com/dhostingpal" class="mx-4">
                                                       <i class="fa-brands fa-facebook fs-7"></i>
                                                    </a>
                                                    <!--end::Icon-->
                                                    <!--begin::Icon-->
                                                    <a href="https://facebook.com/dhostingpal" class="mx-4">
                                                        <i class="fa-brands fa-instagram fs-7"></i>
                                                    </a>
                                                    <!--end::Icon-->
                                                    <!--begin::Icon-->
                                                    <a href="https://github.com/Deparagon" class="mx-4">
                                                        <i class="fa-brands fa-github fs-7"></i>
                                                    </a>
                                                    <!--end::Icon-->
                                                    <!--begin::Icon-->
                                                    <a href="https://stackoverflow.com/users/1838753/de-paragon" class="mx-4">
                                                        <i class="fa-brands fa-stack-overflow fs-7"></i>
                                                    </a>
                                                    <!--end::Icon-->
                                                    <!--begin::Icon-->
                                                    <a href="https://twitter.com/dhostingpal" class="mx-4">
                                                        <i class="fa-brands fa-twitter fs-7"></i>
                                                    </a>
                                                    <!--end::Icon-->
                                                    <!--begin::Icon-->
                                                    <a href="https:://bitbucket.com/deparagon" class="mx-4">
                                                        <i class="fa-brands fa-bitbucket fs-7"></i>
                                                    </a>
                                                    <!--end::Icon-->
                                                    <!--begin::Icon-->
                                                    <a target="_blank" href="https://api.whatsapp.com/send?phone=+2348059965161" class="mx-4">
                                                         <i class="fa-brands fa-whatsapp fs-7"></i>
                                                    </a>
                                                    <!--end::Icon-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Contact-->  



<?php
require_once(dirname(__FILE__).'/before_footer.php');
get_footer();

?>