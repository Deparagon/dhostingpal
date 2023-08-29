<?php
/**
 * Template Name: Signup Page
 * Description: Signup with us template full width.
 *
 */

$pagefilename = basename(__FILE__);
function getCurrentPageFileName()
{
    global $pagefilename;
    return $pagefilename;
}

$authuser = wp_get_current_user();
if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0) {
    if (wp_redirect(get_page_link(11))) {
        exit;
    }
}
get_header();
?>

    <!--begin::Body-->
    <body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
        <!--begin::Theme mode setup on page load-->
        <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
        <!--end::Theme mode setup on page load-->
        <!--begin::Root-->
        <div class="d-flex flex-column flex-root" id="kt_app_root">
            <!--begin::Page bg image-->
            <style>body { background-image: url('<?php echo get_template_directory_uri();?>/img/up.jpg'); } [data-bs-theme="dark"] body { background-image: url('<?php echo get_template_directory_uri();?>/assets/media/auth/bg4-dark.jpg'); }</style>
            <!--end::Page bg image-->
            <!--begin::Authentication - Sign-in -->
            <div class="d-flex flex-column flex-column-fluid flex-lg-row">
                <!--begin::Aside-->
                <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                    <!--begin::Aside-->
                    <div class="d-flex flex-center flex-lg-start flex-column">
                        <!--begin::Logo-->
                        <a href="<?php echo home_url(); ?>" class="mb-7">
                            <img alt="Domain Hosting Pal" src="<?php echo get_template_directory_uri();?>/img/dws.png" />
                        </a>
                        <!--end::Logo-->
                        <!--begin::Title-->
                        <h2 class="text-white fw-normal m-0">Hosting your app with few clicks</h2>
                        <!--end::Title-->
                    </div>
                    <!--begin::Aside-->
                </div>
                <!--begin::Aside-->
                <!--begin::Body-->
                <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                    <!--begin::Card-->
                    <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                            <!--begin::Form-->
                            <form class="form w-100" method="post" id="app_hosting_account_creation_form" action="">
                                <!--begin::Heading-->
                                <div class="text-center mb-11">
                                    <!--begin::Title-->
                                    <h1 class="text-dark fw-bolder mb-3">Create an Account</h1>
                                    <!--end::Title-->
                                   
                                </div>
                                <!--begin::Heading-->
                                <!--begin::Login options-->
                                <div class="row g-3 mb-9">
                                    <!--begin::Col-->
                                 
                                </div>
                                <!--end::Login options-->
                                <!--begin::Separator-->
                                
                                <!--end::Separator-->
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8 possible-error-indicator">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Email-->
                                </div>
                                <!--end::Input group=-->
                                <div class="fv-row mb-3 possible-error-indicator">
                                    <!--begin::Password-->
                                    <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Password-->
                                </div>
                                <!--end::Input group=-->

                                <div class="row mb-10">
                                     <div class="col-sm-6 col-12 possible-error-indicator">
                                         <input type="text" placeholder="First Name" name="firstname" autocomplete="off" class="form-control bg-transparent" /> 
                                     </div>
                                     <div class="col-sm-6 col-12 possible-error-indicator">
                                          <input type="text" placeholder="Last Name" name="lastname" autocomplete="off" class="form-control bg-transparent" />
                                     </div>
                                </div>

                                  <div class="fv-row mb-8 possible-error-indicator">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="Phone" id="phone" name="phone" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Email-->
                                  </div>
                               
                                <!--begin::Submit button-->
                                <div class="d-grid mb-10">
                                    <button type="submit" id="ap_create_an_account_btn" class="btn btn-primary">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label">Sign Up</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        <!--end::Indicator progress-->
                                    </button>
                                </div>
                                <!--end::Submit button-->
                                <!--begin::Sign up-->
                                <div class="text-gray-500 text-center fw-semibold fs-6">Have an account?
                                <a href="<?php echo get_page_link(13); ?>" class="link-primary">Sign In</a></div>
                                <!--end::Sign up-->
                            </form>
                            <!--end::Form-->


                            




                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Footer-->
                        <div class="d-flex flex-stack px-lg-10">
                            <!--begin::Languages-->
                            
                            <!--end::Languages-->
                            <!--begin::Links-->
                            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                <a href="<?php echo get_page_link(45); ?>" target="_blank">Terms</a>
                                <a href="<?php echo get_page_link(3); ?>" target="_blank">Privacy Policy</a>
                                <a href="<?php echo get_page_link(48); ?>" target="_blank">Contact Us</a>
                            </div>
                            <!--end::Links-->
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Authentication - Sign-in-->
        </div>
        <!--end::Root-->

 
<?php
get_footer();
