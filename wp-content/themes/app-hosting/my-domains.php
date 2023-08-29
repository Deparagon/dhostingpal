<?php
/**
 * Template Name:  My Domains
 * Description: The app hosting my domains.
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
    $d_instance = new APHDomain();

    $mydomains = $d_instance->allMine($authuser->ID);
    $countregs = $d_instance->countMineByState($authuser->ID, 'Register');
    $counttrans = $d_instance->countMineByState($authuser->ID, 'Transfer');
    $countexists = $d_instance->countMineByState($authuser->ID, 'Existing');

    $countall = $d_instance->countByUserId($authuser->ID);


    ?>

   
   <div class="row g-5 g-xl-10">
                                        <!--begin::Col-->
                                        <div class="col-sm-6 col-xl-3 mb-xl-10">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-100">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <i class="fa-solid fa-globe fa-color-purple fs-7"></i>
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-7">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $countall; ?></span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-400">Domains</span>
                                                        </div>
                                                        <!--end::Follower-->
                                                    </div>
                                                    <!--end::Section-->
                                                   
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card widget 2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-sm-6 col-xl-3 mb-xl-10">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-100">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <i class="fa-solid fa-globe fa-color-orange fs-5"></i>
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-7">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $countexists; ?></span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-400">Existing</span>
                                                        </div>
                                                        <!--end::Follower-->
                                                    </div>
                                                    <!--end::Section-->
                                                   
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card widget 2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-sm-6 col-xl-3 mb-xl-10">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-100">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <i class="fa-solid fa-globe fa-color-green fs-7"></i>
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-7">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $countregs; ?></span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-400">Registered</span>
                                                        </div>
                                                        <!--end::Follower-->
                                                    </div>
                                                    <!--end::Section-->
                                                   
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card widget 2-->
                                        </div>
                                        <!--end::Col-->
                                        
                                        <!--begin::Col-->
                                        <div class="col-xl-3 mb-5 mb-xl-10">
                                            <!--begin::Card widget 1-->
                                            <div class="card card-flush border-0 h-lg-100" data-bs-theme="light" style="background-color: #7239EA">
                                                <!--begin::Header-->
                                                <div class="card-header pt-2">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title">
                                                        <span class="text-white fs-3 fw-bold me-2">Transfered</span>
                                                    </h3>
                                                    <!--end::Title-->
                                                    
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-between flex-column pt-1 px-0 pb-0">
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-wrap px-9 mb-5">
                                                        
                                                        <!--begin::Stat-->
                                                        <div class="rounded min-w-125px py-3 px-4 my-1" style="border: 1px dashed rgba(255, 255, 255, 0.2)">
                                                            <!--begin::Number-->
                                                            <div class="d-flex align-items-center">
                                                                <div class="text-white fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo $counttrans; ?>">0</div>
                                                            </div>
                                                            <!--end::Number-->
                                                            <!--begin::Label-->
                                                            <div class="fw-semibold fs-6 text-white opacity-50">Transfered domains</div>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Stat-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                   
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card widget 1-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

	



    <div class="row">
                                    <div class="card card-flush mt-6 mt-xl-9">
                                        <!--begin::Card header-->
                                        <div class="card-header mt-5">
                                            <!--begin::Card title-->
                                            <div class="card-title flex-column">
                                                <h3 class="fw-bold mb-1">All My domains</h3>
                                                <div class="fs-6 text-gray-400">Total of <?php echo $countall; ?> domains so far</div>
                                            </div>
                                            <!--begin::Card title-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Table container-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table id="kt_profile_overview_table" class="table table-row-bordered table-row-dashed gy-4 align-middle fw-bold">
                                                    <thead class="fs-7 text-gray-400 text-uppercase">
                                                        <tr>
                                                            <th class="min-w-90px">ID</th>
                                                            <th class="min-w-90px">Name</th>
                                                            <th class="min-w-90px">Status</th>
                                                            <th class="min-w-90px">Acquisition Type</th>
                                                            <th class="min-w-90px">Started</th>
                                                            <th class="min-w-90px">Expiry Date</th>
                                                            <th class="min-w-50px">Added On</th>
                                                            <th class="min-w-100px text-end">Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fs-6">

                                                        <?php if(count($mydomains) > 0):
                                                            foreach($mydomains as $domain): ?>
                                                        <tr>
                                                            <td>
                                                                <!--begin::User-->
                                                                #<?php echo $domain->id_domain; ?>
                                                            </td>
                                                            <td><?php echo $domain->name; ?></td>
                                                            <td> <?php if($domain->status =='active'): ?>
                                                                  <span class="badge badge-light-success fw-bold px-4 py-3">Active</span>
                                                               <?php elseif($domain->status=='Pending'): ?>

                                                                 <span class="badge badge-light-danger fw-bold px-4 py-3">Pending</span>

                                                             <?php else: ?>
                                                                 <span class="badge badge-light-warning fw-bold px-4 py-3"><?php echo $domain->status; ?></span>

                                                                  <?php endif; ?>  
 
                                                               </td>
                                                            <td><?php echo $domain->domain_state; ?></td>
                                                            <td><?php APHTools::justDate($domain->domain_start); ?></td>
                                                             
                                                            

                                                                 <td><?php APHTools::justDate($domain->domain_end); ?></td>
                                                             
                                                          
                                                             <td> <?php echo APHTools::justDate($domain->created_at); ?>
                                                                 
                                                             </td>
                                                            
                                                            <td class="text-end">

                                                                <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                            <!--begin::Menu-->
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" data-viewtype="Edit" data-object="APHDomain" data-name="Domain" data-id_object="<?php echo $domain->id_domain; ?>" class="item_view_edit_process_btn menu-link px-3">Edit</a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="javascript:void(0)" data-object="APHDomain" data-name="Domain" data-id_object="<?php echo $domain->id_domain; ?>" class="delete_item_from_the_list menu-link px-3" data-kt-customer-table-filter="delete_row">Delete</a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu-->
                                                                


                                                            </td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                   
                                                    <?php else: ?>
                                                      <tr> <td colspan="8"> No domain found, <a href="<?php echo get_page_link(15); ?>"> get started here </a></td></tr>

                                                    <?php endif; ?>
                 

                                                    </tbody>
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Table container-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->

    </div>

<?php
            require_once(dirname(__FILE__).'/before_footer.php');

get_footer();

else:

    wp_redirect(get_page_link(13));
    exit;

endif;

?>