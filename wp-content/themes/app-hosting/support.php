<?php
/**
 * Template Name:  Support
 * Description: The app hosting supports.
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
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHReply.php';

    require_once(dirname(__FILE__).'/after_header.php');
    $t_instance = new APHTicket();
    $r_instance = new APHReply();

    $mytickets = $t_instance->allMine($authuser->ID);
    $countall = $t_instance->countByUserId($authuser->ID);

    $countopen = $t_instance->countByStatus($authuser->ID, 'Open');
    $countclosed = $t_instance->countByStatus($authuser->ID, 'Closed');
    ?>


    <div class="row g-5 g-xl-10">
                                        <!--begin::Col-->
                                        <div class="col-sm-6 col-xl-4 mb-xl-10">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-100">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                       <i class="fa-solid fa-ticket fs-5"></i>
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-7">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $countall; ?></span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-400">Tickets</span>
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
                                        <div class="col-sm-6 col-xl-4 mb-xl-10">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-100">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <i class="fa-solid fa-envelope fs-5"></i>
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-7">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $countopen; ?></span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-400">Open</span>
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
                                        <div class="col-xl-4 mb-5 mb-xl-10">
                                            <!--begin::Card widget 1-->
                                            <div class="card card-flush border-0 h-lg-100" data-bs-theme="light" style="background-color: #7239EA">
                                                <!--begin::Header-->
                                                <div class="card-header pt-2">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title">
                                                        <span class="text-white fs-3 fw-bold me-2">Closed</span>
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
                                                                <div class="text-white fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo $countclosed; ?>">0</div>
                                                            </div>
                                                            <!--end::Number-->
                                                            <!--begin::Label-->
                                                            <div class="fw-semibold fs-6 text-white opacity-50">Closed Tickets</div>
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
   


                                    <!--begin::Card-->
                                    <div class="card">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0 pt-6">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <!--begin::Search-->
                                                <div class="d-flex align-items-center position-relative my-1">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search through tickets" />
                                                </div>
                                                <!--end::Search-->
                                            </div>
                                            <!--begin::Card title-->
                                            <!--begin::Card toolbar-->
                                            <div class="card-toolbar">
                                                <!--begin::Toolbar-->
                                                <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                                                    <!--begin::Filter-->
                                                    
                                                    <!--end::Filter-->
                                                    <!--begin::Export-->
                                                
                                                    <!--end::Export-->
                                                    <!--begin::Add subscription-->
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#kt_modal_load_ticket_form"  class="btn btn-primary">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                                    <span class="svg-icon svg-icon-2">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                Open New Ticket</a>
                                                    <!--end::Add subscription-->
                                                </div>
                                                <!--end::Toolbar-->
                                        
                                            </div>
                                            <!--end::Card toolbar-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Table-->
                                            <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                        
                                                        <th class="min-w-125px">Subject</th>
                                                        <th class="min-w-125px">Status</th>
                                                        <th class="min-w-125px">Created Date</th>
                                                        <th class="text-end min-w-70px">
                                                        Actions</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-semibold">
                                                   <?php
                                                    if(count($mytickets) >0):
                                                        foreach($mytickets as $ticket): ?>

                                                    <tr>
                                                        
                                                        
                                                        <td>
                                                            <div class="badge badge-light"><?php echo $ticket->subject ?></div>
                                                        </td>
                                                        <!--end::Billing=-->
                                                        <!--begin::Product=-->
                                                        <td>
                                                            <?php
                                                                if($ticket->status =="Pending"):?>
                                                            <div class="badge badge-light-danger"><?php echo $ticket->status; ?></div>

                                                            <?php elseif($ticket->status =="Open"): ?>
                                                            <div class="badge badge-light-warning"><?php echo $ticket->status; ?></div>

                                                            <?php elseif($ticket->status =="Closed"): ?>
                                                            <div class="badge badge-light-success"><?php echo $ticket->status; ?></div>

                                                            <?php else: ?>
                                                            <div class="badge badge-light"><?php echo $ticket->status; ?></div>
 
                                                            <?php endif; ?>
                                                        </td>
                                                        <!--end::Product=-->
                                                        <!--begin::Date=-->
                                                        <td><?php echo APHTools::justDate($ticket->created_at); ?></td>
                                                        <!--end::Date=-->
                                                        <!--begin::Action=-->
                                                        <td class="text-end">
                                                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                            <span class="svg-icon svg-icon-5 m-0">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon--></a>
                                                            <!--begin::Menu-->
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                                
                                                                <!--begin::Menu item-->
                                                                <?php
                                                                    if($ticket->status =='Open' || $ticket->status =='Pending'): ?>
                                                                <div class="menu-item px-3">
                                                                    <a data-viewtype="Closed" data-object="APHTicket" data-name="Ticket" data-id_object="<?php echo $ticket->id_ticket; ?>" href="javascript:void(0)" class="ap_perform_ticket_actions menu-link px-3">Close</a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                                <?php endif;

                                                            if($ticket->status =='Closed'): ?>
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a data-viewtype="Open" data-object="APHTicket" data-name="Ticket" data-id_object="<?php echo $ticket->id_ticket; ?>" href="javascript:void(0)" class="menu-link px-3">Open</a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                                <?php endif; ?>


                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="<?php echo get_page_link(50) ?>?ref=<?php echo $ticket->reference; ?>" class="menu-link px-3">Reply</a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                            
                                                            </div>
                                                            <!--end::Menu-->
                                                        </td>
                                                        <!--end::Action=-->
                                                    </tr>

                                                    <?php endforeach;
endif; ?>

                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->

	



<?php
            require_once(dirname(__FILE__).'/before_footer.php');
include_once dirname(__FILE__).'/_support_modal.php';
get_footer();

else:

    wp_redirect(get_page_link(13));
    exit;

endif;

?>