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
class APHPlansPage
{
    public $page_link;
    public $return_url;
    public $extra_message;
    public function __construct()
    {
        add_action('admin_menu', array($this, 'addMenu'));
        add_action('wp_ajax_manageHostingPlans', array($this, 'manageHostingPlans'));

        // $this->page_link = esc_url(admin_url().'/admin.php?page=app_hostplans');
        // $this->return_url = home_url();
    }

    public function addMenu()
    {
        add_submenu_page('apphosting_settings', esc_html__('Hosting Plans', 'apphost'), esc_html__('Hosting Plans', 'apphost'), 'manage_options', 'app_hostplans', array($this, 'display'));
    }

    public function display()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHPlan.php';
        $oplan = new APHPlan();
        $plans =$oplan->getAllPlans();

        ?>

   

<div class="admin-main-container-wave">
<div class="card">
    <div class="card-header bg-white"><?php esc_html_e('Hosting Plans', 'apphost'); ?> 
       
       <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#ap_create_new_plan_modal">Add New Plan</a>
</div>
  <div class="card-body">
    <div class="table-responsive">
    <table id="mybills_classic_table" class="table table-striped table-bordered">
        <thead>
            <th><?php esc_html_e('ID', 'apphost'); ?> </th>  <th><?php esc_html_e('Name', 'apphost'); ?> </th>  <th><?php esc_html_e('Memory Size', 'apphost'); ?> </th>  <th><?php esc_html_e('Bandwidth', 'apphost'); ?> </th>  <th><?php esc_html_e('Monthly Price', 'apphost'); ?> </th>  <th><?php esc_html_e('Yearly Price', 'apphost'); ?> </th>  <th><?php esc_html_e('Disk space', 'apphost'); ?> </th> <th><?php esc_html_e('Status', 'apphost'); ?> </th> <th><?php esc_html_e('Date', 'apphost'); ?> </th> <th>Edit </th> <th>Delete </th>
        </thead>
        <tbody>
            <?php if (count($plans) >0) :
                foreach ($plans as $plan) : ?>
                    <tr>
                    <td><?php echo esc_html($plan->id_plan); ?></td>
                    <td><?php echo esc_html($plan->name); ?></td>
                    <td><?php echo esc_html($plan->memory_size); ?></td>
                    <td><?php echo esc_html($plan->bandwidth); ?></td>
                    <td><?php echo esc_html($plan->monthly_price); ?></td>
                    <td><?php echo esc_html(number_format($plan->yearly_price, 2)); ?></td>
                    <td><?php echo esc_html($plan->disk_space); ?>
                   </td>
                    
                    <td><?php
                    if ($plan->status =='active') {
                        echo '<span class="btn btn-block btn-success">'.esc_html($plan->status).'</span>';
                    } elseif ($plan->status=='inactive') {
                        echo '<span class="btn btn-block btn-danger">'.esc_html($plan->status).'</span>';
                    } elseif ($plan->status =='draft') {
                        echo '<span class="btn btn-block btn-warning">'.esc_html($plan->status).'</span>';
                    } else {
                        echo esc_html($plan->status);
                    }
                    ;
                    ?></td>
                    <td><?php echo APHTools::slashDate($plan->created_at); ?></td>
                    <td><button data-object="Plan" data-object_id="<?php echo $plan->id_plan; ?>" class="btn btn-primary btn-xs ap_edit_object_plan_btn"><i class="fa fa-edit"> </i></button></td>
                    <td><button data-object="Plan" data-object_id="<?php echo $plan->id_plan; ?>" class="btn btn-danger btn-xs ap_delete_object_plan_btn"><i class="fa fa-trash"> </i></button></td>
                </tr>

                <?php endforeach;
        else :
            ?>
                 <tr> <td colspan="9"><?php esc_html_e('No hosting plan, create hosting plans', 'apphost'); ?></td></tr>
            <?php endif; ?>

            
        </tbody>
    </table>
</div>

  </div>
</div>
</div>

<a href="#" id="ap_modal_btn_load_edit" class="display_none" data-bs-toggle="modal" data-bs-target="#ap_edit_plan_modal">Edit Plan</a>

<div class="modal fade" id="ap_create_new_plan_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header" id="ap_modal_create_api_key_header">
                        <!--begin::Modal title-->
                        <h2>Create New Plan</h2>
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
                    <form id="ap_modal_create_plan_form" class="form" action="#">
                        <!--begin::Modal body-->
                        <div class="modal-body py-10 px-lg-17">
                            <!--begin::Scroll-->
                            <div class="scroll-y me-n7 pe-7" id="ap_modal_create_api_key_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#ap_modal_create_api_key_header" data-kt-scroll-wrappers="#ap_modal_create_api_key_scroll" data-kt-scroll-offset="300px">
                       
                                <!--begin::Input group-->
                                <div class="row">
                                    <div class="col-sm-6"> 
                                     <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Plan Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Plan Name" name="name" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group--></div>
                                    <div class="col-sm-6">  <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Plan Sub-name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Sub-name" name="sub_name" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group--></div>
                                </div>

                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Memory Size</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Memory/RAM" name="memory_size" />
                                    <!--end::Input-->
                                </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Disk Space</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Disk space" name="disk_space" />
                                    <!--end::Input-->
                                </div>
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Bandwidth</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Bandwidth" name="bandwidth" />
                                    <!--end::Input-->
                                </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid" name="status">
                                        <option value="active">Active  </option>
                                        <option value="inactive">Inactive  </option>
                                        <option value="draft">Draf  </option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                    </div>
                                </div>


                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Monthly Price</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Monthly Price" name="monthly_price" />
                                    <!--end::Input-->
                                </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Yearly Price</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Yearly Price" name="yearly_price" />
                                    <!--end::Input-->
                                </div>
                                    </div>
                                </div>
                              
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-5 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2"> Description</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-solid" rows="3" name="description" placeholder="Describe the plan"></textarea>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row">
                                    <div class="col-sm-6">
                                                  <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Plan Type</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="plan_type" data-control="select2" data-hide-search="true" data-placeholder="Select Plan Type" class="form-select form-select-solid">
                                        <option value="">Select Plan Type...</option>
                                        <option value="Full">Full Cloud</option>
                                        <option value="Shared">Shared</option>
                                        <option value="Tenant">Tenant</option>
                                    </select>
                                    <!--end::Select-->
                                </div>

                                    </div>
                                    <div class="col-sm-6">
                                                  <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">App Type</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="app_type" data-control="select2" data-hide-search="true" data-placeholder="Select App Type" class="form-select form-select-solid">
                                        <option value="">Select App Type...</option>
                                        <option value="WordPress">WordPress</option>
                                        <option value="Laravel">Laravel</option>
                                        <option value="PHP">PHP</option>
                                        <option value="Others">Nodejs, Others</option>
                                    </select>
                                    <!--end::Select-->
                                </div>

                                    </div>
                                </div>

                      
                                <!--end::Input group-->
                                <!--begin::Input group-->
                             
                                <!--end::Input group-->
                            </div>
                            <!--end::Scroll-->
                        </div>
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer flex-center">
                            <!--begin::Button-->
                            <button type="reset" id="ap_cancel_plan_creation" class="btn btn-light me-3">Discard</button>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="ap_create_new_plan" class="btn btn-primary">
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

  


  <div class="modal fade" id="ap_edit_plan_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header" id="ap_modal_plan_editor_header">
                        <!--begin::Modal title-->
                        <h2>Edit Plan</h2>
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
                    <form id="ap_modal_edit_plan_form" class="form" action="#">
                        <!--begin::Modal body-->
                        <div id="ap_content_editor_load_ajax">
                            
                        </div>
                      
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer flex-center">
                            <!--begin::Button-->
                            <button type="reset" id="ap_cancel_plan_creation" class="btn btn-light me-3">Discard</button>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="ap_edit_plan_submit_btn" class="btn btn-primary">
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

    public function manageHostingPlans()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHTools.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHPlan.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHPaystack.php';
        $oplan = new APHPlan();



        $request_token = APHTools::getValue('request_token');
        if ($request_token =='APLVXSTFPLBRZNXFGYUWNDPIQCEFOGJEWLTEIIIVFWKWKYAMWYMZRKDRUETRULKG') {
            $oplan->validateFields($_POST);
            if($oplan->saveField()) {
                // create new plan in paystack
                $plan = $oplan->getLatest();

                $res = (new APHPaystack())->updateAPlan($plan);
                APHTools::displaySuccess('New plan created successfully');
            }
            APHTools::displayError('Could not create plan due to some error');
        } elseif($request_token =='APBRVQKCEWJNSYZXFKVHSMCJMXCWYQSNGBXNIQVOTOLGEKKSOPOXBXDEOFQJAHEL') {
            $oplan->validateFields($_POST);
            $theplan = $oplan->updateByPrimaryKey();

            $res = (new APHPaystack())->updateAPlan($theplan);
            APHTools::displaySuccess('Plan updated successfully');
        } elseif ($request_token =='APVWUMEQKQEPSXBPUZTLAHILUXEDYFHUVWOHFFBXEGZPKHLJETZNHWMLJLYNEWOW') {
            $id_plan = APHTools::getValue('id_plan');
            if($id_plan < 1) {
                APHTools::displayError('Could not load any existing plan');
            }

            $plan = $oplan->getById($id_plan);
            if(is_object($plan)  && (int) $plan->id_plan > 0) :
                ob_start();
                ?>
            <div class="modal-body py-10 px-lg-17">
                            <!--begin::Scroll-->
                            <div class="scroll-y me-n7 pe-7" id="ap_modal_create_api_key_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#ap_modal_create_api_key_header" data-kt-scroll-wrappers="#ap_modal_create_api_key_scroll" data-kt-scroll-offset="300px">

                                 <input type="hidden" name="id_plan" value="<?php echo $plan->id_plan; ?>">
                       
                                <!--begin::Input group-->
                                <div class="row">
                                    <div class="col-sm-6"> 
                                     <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Plan Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" value="<?php echo $plan->name; ?>" class="form-control form-control-solid" placeholder="Plan Name" name="name" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group--></div>
                                    <div class="col-sm-6">  <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Plan Sub-name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Sub-name" value="<?php echo $plan->sub_name; ?>" name="sub_name" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group--></div>
                                </div>

                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Memory Size</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" value="<?php echo $plan->memory_size; ?>" class="form-control form-control-solid" placeholder="Memory/RAM" name="memory_size" />
                                    <!--end::Input-->
                                </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Disk Space</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Disk space" value="<?php echo $plan->disk_space; ?>" name="disk_space" />
                                    <!--end::Input-->
                                </div>
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Bandwidth</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Bandwidth" value="<?php echo $plan->bandwidth; ?>" name="bandwidth" />
                                    <!--end::Input-->
                                </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid" name="status">';



                <option value="active" <?php if($plan->status =="active"): "selected"; endif; ?>>Active  </option>
                                        <option value="inactive" <?php if($plan->status =="inactive"): "selected"; endif; ?>>Inactive  </option>
                                        <option value="draft" <?php if($plan->status =="draft"): "selected"; endif; ?>>Draft  </option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                    </div>
                                </div>


                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Monthly Price</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Monthly Price" value="<?php echo  $plan->monthly_price; ?>" name="monthly_price" />
                                    <!--end::Input-->
                                </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-5">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Yearly Price</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="Yearly Price" value="<?php echo $plan->yearly_price; ?>" name="yearly_price" />
                                    <!--end::Input-->
                                </div>
                                    </div>
                                </div>
                              
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-5 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2"> Description</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-solid" rows="3" name="description" placeholder="Describe the plan"><?php echo $plan->description; ?></textarea>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row">
                                    <div class="col-sm-6">
                                                  <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">Plan Type</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="plan_type" data-control="select2" data-hide-search="true" data-placeholder="Select Plan Type" class="form-select form-select-solid">
                                        <option value="">Select Plan Type...</option>
                                        <option value="Full" <?php if($plan->plan_type =="Full"): echo "selected"; endif; ?>>Full Cloud</option>
                                        <option value="Shared" <?php if($plan->plan_type =="Shared"): echo "selected"; endif; ?>>Shared</option>
                                        <option value="Tenant" <?php if($plan->plan_type =="Tenant"): echo "selected"; endif; ?>>Tenant</option>
                                    </select>
                                    <!--end::Select-->
                                </div>

                                    </div>
                                    <div class="col-sm-6">
                                                  <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="required fs-5 fw-semibold mb-2">App Type</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="app_type" data-control="select2" data-hide-search="true" data-placeholder="Select App Type" class="form-select form-select-solid">
                                        <option value="">Select App Type...</option>
                                        <option value="WordPress" <?php if($plan->app_type =="WordPress"): echo "selected"; endif; ?>>WordPress</option>
                                        <option value="Laravel" <?php if($plan->app_type =="Laravel"): echo"selected"; endif; ?>>Laravel</option>
                                        <option value="PHP" <?php if($plan->app_type =="PHP"): echo"selected"; endif; ?>>PHP</option>
                                        <option value="Others" <?php if($plan->app_type =="Others"): echo"selected"; endif; ?>>Nodejs, Others</option>
                                    </select>
                                    <!--end::Select-->
                                </div>

                                    </div>
                                </div>

                      
                                <!--end::Input group-->
                                <!--begin::Input group-->
                             
                                <!--end::Input group-->
                            </div>
                            <!--end::Scroll-->
                        </div>
                    <?php
                    $html = ob_get_contents();
                ob_clean();

                APHTools::ajaxReport('OK', 'success', $html);
            endif;
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


new APHPlansPage();

?>
