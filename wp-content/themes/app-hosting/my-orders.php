<?php
/**
 * Template Name:  My Orders
 * Description: The app hosting my orders.
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

    $allorders = $ins_order->allMine($authuser->ID);
    ?>

   
<!-- STATS -->

  <div class="row g-5 g-xl-10">
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



<!-- LIST -->

    <!--begin::Table-->
    <div class="row">
                                    <div class="card card-flush mt-6 mt-xl-9">
                                        <!--begin::Card header-->
                                        <div class="card-header mt-5">
                                            <!--begin::Card title-->
                                            <div class="card-title flex-column">
                                                <h3 class="fw-bold mb-1">I have placed</h3>
                                                <div class="fs-6 text-gray-400">a total of <?php echo count($allorders); ?> orders so far</div>
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
                                                            <th class="min-w-90px">Order ID</th>
                                                            <th class="min-w-90px">Reference</th>
                                                            <th class="min-w-90px">Domain</th>
                                                            <th class="min-w-90px">Total</th>
                                                            <th class="min-w-90px">Active</th>
                                                            <th class="min-w-90px">Status</th>
                                                            <th class="min-w-50px">Created At</th>
                                                            <th class="min-w-50px text-end">View</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fs-6">

                                                        <?php if(count($allorders) >0):
                                                            foreach($allorders as $order): ?>
                                                        <tr>
                                                            <td>
                                                                <!--begin::User-->
                                                                #<?php echo $order->id_order; ?>
                                                            </td>
                                                            <td><?php echo $order->reference; ?></td>
                                                            <td><?php echo $order->app_domain; ?></td>
                                                            <td><?php echo number_format($order->order_total, 2); ?></td>
                                                             <td> <?php if($order->active ==1): ?>
                                                                  <span class="badge badge-light-success fw-bold px-4 py-3">Active</span>
                                                               <?php else: ?>

                                                                 <span class="badge badge-light-danger fw-bold px-4 py-3">InActive</span>

                                                                  <?php endif; ?>  
 
                                                               </td>
                                                            <td>

                                                                <?php if($order->status =="Pending"): ?>
                                                                    <span class="badge badge-warning fw-bold px-4 py-3"><?php echo $order->status; ?></span>

                                                                <?php elseif($order->status =="Paid"): ?>
                                                                 <span class="badge badge-light-success fw-bold px-4 py-3"><?php echo $order->status; ?></span>

                                                                <?php elseif($order->status =="Completed"): ?>

                                                                     <span class="badge badge-success fw-bold px-4 py-3"><?php echo $order->status; ?></span>
                                                                <?php elseif($order->status =="Paid"): ?>
                                                                     <span class="badge badge-warning fw-bold px-4 py-3"><?php echo $order->status; ?></span>

                                                                 <?php else: ?>
                                                                 <span class="badge badge-light fw-bold px-4 py-3"><?php echo $order->status; ?></span>


                                                                 <?php  endif; ?>



                                                              

                                                               
                                                            </td>
                                                             <td> <?php echo APHTools::justDate($order->created_at); ?>
                                                                 
                                                             </td>
                                                            
                                                            <td class="text-end">
                                                                <a href="<?php echo get_page_link(42); ?>?id_order=<?php echo $order->id_order; ?>" class="btn btn-light btn-sm">View</a>
                                                            </td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                   
                                                    <?php else: ?>
                                                      <tr> <td colspan="8"> No order found, <a href="<?php echo get_page_link(15); ?>"> get started here </a></td></tr>

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