<?php
/**
* Template Name:  Reply
* Description: The app hosting support ticket replies.
*
*/
ob_start();
$authuser = wp_get_current_user();
if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0):
    get_header();
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHPlan.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHCountry.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHAddress.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHTicket.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHReply.php';

    require_once(dirname(__FILE__).'/after_header.php');
    $t_instance = new APHTicket();
    $r_instance = new APHReply();

    $reference = APHTools::getValue('ref');
    if($reference =='') {
        ob_clean();
        wp_redirect(get_page_link(36));
    }

    $ticket = $t_instance->getByReference($authuser->ID, $reference);
    if(! is_object($ticket)  || !(int) $ticket->id_ticket >0) {
        ob_clean();
        wp_redirect(get_page_link(36));
    }
    $replies = $r_instance->getTicketReplies($ticket->id_ticket);
    // print_r($replies);
    // exit;

    ?>




<div class="d-flex flex-column flex-lg-row">
<!--begin::Sidebar-->
<div class="d-none d-lg-flex flex-column flex-lg-row-auto w-100 w-lg-275px" data-kt-drawer="true" data-kt-drawer-name="inbox-aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_inbox_aside_toggle">
    <!--begin::Sticky aside-->
    <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="inbox-aside-sticky" data-kt-sticky-offset="{default: false, xl: '100px'}" data-kt-sticky-width="{lg: '275px'}" data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
        <!--begin::Aside content-->
        <div class="card-body">
            <!--begin::Button-->
            <a href="<?php echo get_page_link(36); ?>" class="btn btn-primary fw-bold w-100 mb-8">Support Tickets</a>
            <!--end::Button-->
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-state-bg menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary mb-10">
                <!--begin::Menu item-->
                <div class="menu-item mb-3">
                    <!--begin::Inbox-->
                    <span class="menu-link active">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                            <span class="svg-icon svg-icon-2 me-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="currentColor" />
                                    <path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title fw-bold">Replies</span>
                        <span class="badge badge-light-success"><?php echo count($replies); ?></span>
                    </span>
                    <!--end::Inbox-->
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item mb-3">
                    <!--begin::Draft-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2 me-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M21 22H14C13.4 22 13 21.6 13 21V3C13 2.4 13.4 2 14 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
                                    <path d="M10 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H10C10.6 2 11 2.4 11 3V21C11 21.6 10.6 22 10 22Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title fw-bold">Ref: </span>
                    
<span class="badge badge-success"><?php echo $ticket->reference; ?></span>


                        
                    </span>
                    <!--end::Draft-->
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                
                <!--end::Menu item-->

            </div>
            <!--end::Menu-->
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-state-bg menu-state-title-primary">
                <!--begin::Menu item-->
                <div class="menu-item mb-3">
                    <!--begin::Custom work-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs009.svg-->
                            <span class="svg-icon svg-icon-6 svg-icon-danger me-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 6C8.7 6 6 8.7 6 12C6 15.3 8.7 18 12 18C15.3 18 18 15.3 18 12C18 8.7 15.3 6 12 6Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title fw-semibold">Status</span>
                        <?php if($ticket->status =='Open'): ?>
<span class="badge badge-light-success">Open</span>
                        <?php else: ?>
<span class="badge badge-light-danger"><?php echo$ticket->status; ?></span>
                        <?php endif; ?>
                        
                    </span>
                    <!--end::Custom work-->
                </div>
                <!--end::Menu item-->
    
                <!--end::Menu item-->
        
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside content-->
    </div>
    <!--end::Sticky aside-->
</div>
<!--end::Sidebar-->

<!--begin::Content-->
<div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
    <!--begin::Card-->
    <div class="card">
        <div class="card-header align-items-center py-5 gap-5">
            <!--begin::Actions-->
            <div class="d-flex">
                <!--begin::Back-->
        
                <!--begin::Archive-->
                <a data-viewtype="Closed" data-object="APHTicket" data-name="Ticket" data-id_object="<?php echo $ticket->id_ticket; ?>" href="javascript:void(0)" class="ap_perform_ticket_actions btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive">
                    <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                    <span class="svg-icon svg-icon-2 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z" fill="currentColor" />
                            <path opacity="0.3" d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </a>
                <!--end::Archive-->
            
               
                <!--begin::Mark as read-->
                <a href="javascript:void(0)" data-viewtype="Read" data-object="APHTicket" data-name="Ticket" data-id_object="<?php echo $ticket->id_ticket; ?>" class="btn btn-sm btn-icon btn-light ap_perform_ticket_actions btn-active-light-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as read">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen028.svg-->
                    <span class="svg-icon svg-icon-2 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="7" y="2" width="14" height="16" rx="3" fill="currentColor" />
                            <rect x="3" y="6" width="14" height="16" rx="3" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </a>
                <!--end::Mark as read-->
                <!--begin::Move-->
                
                <!--end::Move-->
            </div>
            <!--end::Actions-->
            
        </div>
        <div class="card-body">
            <!--begin::Title-->
            <div class="d-flex flex-wrap gap-2 justify-content-between mb-8">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <!--begin::Heading-->
                    <h2 class="fw-semibold me-3 my-1"><?php echo $ticket->subject; ?></h2>
                    <!--begin::Heading-->
                    <!--begin::Badges-->
                    <span class="badge badge-light-primary my-1 me-2"><?php echo $ticket->department; ?></span>
                    <span class="badge badge-light-danger my-1">important</span>
                    <!--end::Badges-->
                </div>
                <div class="d-flex">
                    
                    
                </div>
            </div>
            <!--end::Title-->
            <!--begin::Message accordion-->
            <div data-kt-inbox-message="message_wrapper">
                <!--begin::Message header-->
                <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                    <!--begin::Author-->
                    <div class="d-flex align-items-center">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50 me-4">
                           <i class="fa-solid fa-user fa-lg-fa"></i>


                            
                        </div>
                        <!--end::Avatar-->
                        <div class="pe-5">
                            <!--begin::Author details-->
                            <div class="d-flex align-items-center flex-wrap gap-1">
                                <a href="#" class="fw-bold text-dark text-hover-primary">
                                    <?php echo $ticket->fullname; ?>
                                </a>
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs050.svg-->
                                <span class="svg-icon svg-icon-7 svg-icon-success mx-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <circle fill="currentColor" cx="12" cy="12" r="8" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <span class="text-muted fw-bold"><?php echo APHTools::justDate($ticket->created_at); ?></span>
                            </div>
                            <!--end::Author details-->
                            <!--begin::Message details-->
                            <div data-kt-inbox-message="details">
                                <span class="text-muted fw-semibold">to support team</span>
                                <!--begin::Menu toggle-->
                                <a href="#" class="me-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--end::Menu toggle-->
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4" data-kt-menu="true">
                                    <!--begin::Table-->
                                    <table class="table mb-0">
                                        <tbody>
                                            <!--begin::From-->
                                            <tr>
                                                <td class="w-75px text-muted">From</td>
                                                <td> 
                                     <?php echo $ticket->fullname; ?>
                                </td>
                                            </tr>
                                            <!--end::From-->
                                            <!--begin::Date-->
                                <tr>
                                    <td class="text-muted">Date</td>
                                    <td><?php echo $ticket->created_at; ?></td>
                                </tr>
                                            <!--end::Date-->
                                            <!--begin::Subject-->
                                            <tr>
                                                <td class="text-muted">Subject</td>
                                                <td><?php echo $ticket->subject; ?></td>
                                            </tr>
                                            <!--end::Subject-->
                                            <!--begin::Reply-to-->
                                            <tr>
                                                <td class="text-muted">Reply-to</td>

                                                <td>
                                               <?php echo $ticket->email ; ?>
                                                </td>
                                            </tr>
                                            <!--end::Reply-to-->
                                        </tbody>
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Message details-->
                            <!--begin::Preview message-->
                            <div class="text-muted fw-semibold mw-450px d-none" data-kt-inbox-message="preview"><?php echo $ticket->message; ?></div>
                            <!--end::Preview message-->
                        </div>
                    </div>
                    <!--end::Author-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <!--begin::Date-->
                        <span class="fw-semibold text-muted text-end me-3"><?php echo $ticket->created_at; ?></span>
                        <!--end::Date-->
                    
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Message header-->
                <!--begin::Message content-->
                <div class="collapse fade show" data-kt-inbox-message="message">
                    <div class="py-5">
                         <?php echo $ticket->message; ?>
                        
                    </div>
                </div>
                <!--end::Message content-->
            </div>
            <!--end::Message accordion-->

            <?php if(count($replies) >0):
                foreach($replies as $reply) : ?>
            <div class="separator my-6"></div>
            <!--begin::Message accordion-->
            <div data-kt-inbox-message="message_wrapper">
                <!--begin::Message header-->
                <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                    <!--begin::Author-->
                    <div class="d-flex align-items-center">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50 me-4">
                            <i class="fa-solid fa-user fa-lg-fa"></i>
                        </div>
                        <!--end::Avatar-->
                        <div class="pe-5">
                            <!--begin::Author details-->
                            <div class="d-flex align-items-center flex-wrap gap-1">
                                <a href="javascript:void(0)" class="fw-bold text-dark text-hover-primary">
                                   <?php echo $reply->source; ?>
                                </a>
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs050.svg-->
                                <span class="svg-icon svg-icon-7 svg-icon-success mx-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <circle fill="currentColor" cx="12" cy="12" r="8" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <span class="text-muted fw-bold"><?php echo $reply->created_at; ?></span>
                            </div>
                            <!--end::Author details-->
                            <!--begin::Message details-->
                            <div class="d-none" data-kt-inbox-message="details">
                                <span class="text-muted fw-semibold">to me</span>
                                <!--begin::Menu toggle-->
                                <a href="#" class="me-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--end::Menu toggle-->
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4" data-kt-menu="true">
                                    <!--begin::Table-->
                                    <table class="table mb-0">
                                        <tbody>
                                            <!--begin::From-->
                                            <tr>
                                                <td class="w-75px text-muted">From</td>
                                                <td><?php echo $reply->source; ?></td>
                                            </tr>
                                            <!--end::From-->
                                            <!--begin::Date-->
                                            <tr>
                                                <td class="text-muted">Date</td>
                                                <td><?php echo APHTools::justDate($ticket->created_at); ?></td>
                                            </tr>
                                            <!--end::Date-->
                                            <!--begin::Subject-->
                                            <tr>
                                                <td class="text-muted">Subject</td>
                                                <td><?php echo $ticket->subject ?></td>
                                            </tr>
                                            <!--end::Subject-->
                                            <!--begin::Reply-to-->
                                            <tr>
                                                <td class="text-muted">Reply-to</td>
                                                <td>
                                                    
      
                                            <?php echo $ticket->email; ?>

                                                </td>
                                            </tr>
                                            <!--end::Reply-to-->
                                        </tbody>
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Message details-->
                            <!--begin::Preview message-->
                            <div class="text-muted fw-semibold mw-450px" data-kt-inbox-message="preview"><?php echo APHTools::subText($reply->message); ?></div>
                            <!--end::Preview message-->
                        </div>
                    </div>
                    <!--end::Author-->
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <!--begin::Date-->
                        <span class="fw-semibold text-muted text-end me-3"><?php echo APHTools::justDate($reply->created_at); ?></span>
                        <!--end::Date-->
                        <div class="d-flex">
                            <!--begin::Star-->
                        
                                    <!--begin::Reply-->
                            <a href="#" class="reply_scroll_btn btn btn-sm btn-icon btn-clear btn-active-light-primary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Reply">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen055.svg-->
                                <span class="svg-icon svg-icon-2 m-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor" />
                                        <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor" />
                                        <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>
                            <!--end::Reply-->
                
                        </div>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Message header-->
                <!--begin::Message content-->
                <div class="collapse fade" data-kt-inbox-message="message">
                    <div class="py-5">
                    <?php echo  $reply->reply_message; ?>
<?php if($reply->reply_attachment !=''): ?>
                        <p> <a target="_blank" href="<?php echo $reply->reply_attachment; ?>"> <img class="img-fluid" src="<?php echo $reply->reply_attachment; ?>"> </a></p>
                        <?php endif; ?>
                    </div>
                </div>
                <!--end::Message content-->
            </div>

            <?php endforeach;
            endif; ?>

            <input type="hidden" id="ap_is_reply_page" name="reply_page" value="1">
            <!--begin::Form-->
            <form id="ap_inbox_reply_form" method="post" class="rounded border mt-10" enctype="multipart/form-data">
                <!--begin::Body-->
                <div class="d-block">

                   
                    <!--begin::To-->
                    <!--end::To-->
                    <!--begin::Subject-->
                    <div class="border-bottom">
                        <input class="form-control border-0 px-8 min-h-45px" name="compose_subject" value="Re: <?php echo $ticket->subject; ?>" placeholder="Subject" />
                    </div>
                    <!--end::Subject-->
                    <!--begin::Message-->
                    <!-- <div id="kt_inbox_form_editor" class="border-0 h-250px px-3"></div> -->
                    <textarea name="message" placeholder="Message here" class="form-control" rows="10" id="actual_textkeeper"></textarea>
                    <!--end::Message-->
                  <input type="hidden" name="id_ticket" value="<?php echo $ticket->id_ticket; ?>"/>
                  <input type="hidden" name="action" value="internalActions"/>
                  <input type="hidden" name="request_token" value="APNOFFLIWQIMKKPTFHQQGPSDKTQGTUPCVWCPWZJIJGMPFHMQTOMROGOWSDLZVSBZ">
                 <input style="display:none" id="rattachment_file" type="file" name="rattachment">
                

                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class=" message_place d-flex flex-stack flex-wrap gap-2 py-5 ps-8 pe-5 border-top">
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center me-3">
                        <!--begin::Send-->
                        <div class="btn-group me-4">
                            <!--begin::Submit-->
                            <button class="btn btn-primary fs-bold px-6" data-kt-inbox-form="send">
                                <span class="indicator-label">Send</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Submit-->

                            <!--begin::Send options-->
                            
                            <!--end::Send options-->
                        </div>
                        <!--end::Send-->
                    
                          <span>
                            <img class="display_none img-60" id="holding_rattachment_img" src="">
                          </span>
                        
                    </div>
                    <!--end::Actions-->
                    <!--begin::Toolbar-->
                    <div class="d-flex align-items-center">
        
                            <!--begin::Upload attachement-->
                        <span class="btn btn-icon btn-sm btn-clean btn-active-light-primary me-2" id="rattachments_select" data-kt-inbox-form="dropzone_upload">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com008.svg-->
                            <span class="svg-icon svg-icon-2 m-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M4.425 20.525C2.525 18.625 2.525 15.525 4.425 13.525L14.825 3.125C16.325 1.625 18.825 1.625 20.425 3.125C20.825 3.525 20.825 4.12502 20.425 4.52502C20.025 4.92502 19.425 4.92502 19.025 4.52502C18.225 3.72502 17.025 3.72502 16.225 4.52502L5.82499 14.925C4.62499 16.125 4.62499 17.925 5.82499 19.125C7.02499 20.325 8.82501 20.325 10.025 19.125L18.425 10.725C18.825 10.325 19.425 10.325 19.825 10.725C20.225 11.125 20.225 11.725 19.825 12.125L11.425 20.525C9.525 22.425 6.425 22.425 4.425 20.525Z" fill="currentColor" />
                                    <path d="M9.32499 15.625C8.12499 14.425 8.12499 12.625 9.32499 11.425L14.225 6.52498C14.625 6.12498 15.225 6.12498 15.625 6.52498C16.025 6.92498 16.025 7.525 15.625 7.925L10.725 12.8249C10.325 13.2249 10.325 13.8249 10.725 14.2249C11.125 14.6249 11.725 14.6249 12.125 14.2249L19.125 7.22493C19.525 6.82493 19.725 6.425 19.725 5.925C19.725 5.325 19.525 4.825 19.125 4.425C18.725 4.025 18.725 3.42498 19.125 3.02498C19.525 2.62498 20.125 2.62498 20.525 3.02498C21.325 3.82498 21.725 4.825 21.725 5.925C21.725 6.925 21.325 7.82498 20.525 8.52498L13.525 15.525C12.325 16.725 10.525 16.725 9.32499 15.625Z" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <!--end::Upload attachement-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
    <!--end::Card-->
</div>
<!--end::Content-->
</div>         








<?php
require_once(dirname(__FILE__).'/before_footer.php');
get_footer();

else:

    wp_redirect(get_page_link(13));
    exit;

endif;

?>