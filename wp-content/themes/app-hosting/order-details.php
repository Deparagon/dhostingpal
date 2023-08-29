<?php
/**
 * Template Name:  Order Details
 * Description: The app hosting order details.
 *
 */
ob_start();

$authuser = wp_get_current_user();
if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0):
    get_header();
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHPlan.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHCountry.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHDomain.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHDomainPrice.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHOrder.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHAddress.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHInvoice.php';



    $id_order = (int) APHTools::getValue('id_order');
    $o_instance = new APHOrder();
    $d_instance = new APHDomain();
    $a_instance = new APHAddress();
    $p_instance = new APHPlan();
    $i_instance = new APHInvoice();




    // echo 'input started';
    // exit;


    $order = $o_instance->getById($id_order);


    if(!(int) $id_order >0) {
        ob_clean();
        wp_redirect(get_page_link(32));
    }

    if(!is_object($order) || (int) $order->id_order < 0) {
        ob_clean();
        wp_redirect(get_page_link(32));
    }

    if($order->user_id  != $authuser->ID) {
        ob_clean();
        wp_redirect(get_page_link(32));
    }



    $domain = $d_instance->getById($order->id_domain);

    if(!is_object($domain) || (int) $domain->id_domain ==0) {
        //  APHTools::displayError('There is no valid domain object, contact support for assistance');
    } else {
        $reg = $a_instance->addressById($domain->id_reg_address);
        $billing = $a_instance->addressById($domain->id_billing_address);
    }

$plan = $p_instance->getById($order->id_plan);

$invoices  = $i_instance->getOrderInvoices($order->id_order);

require_once(dirname(__FILE__).'/after_header.php');


?>

   
<div class="d-flex flex-column gap-7 gap-lg-10">
                                        <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
                                            <!--begin:::Tabs-->
                                            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto">
                                                <!--begin:::Tab item-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_sales_order_summary">Order Summary</a>
                                                </li>
                                                <!--end:::Tab item-->
                                                <!--begin:::Tab item-->
                                                <li class="nav-item">
                                                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_sales_order_history">Order History</a>
                                                </li>
                                                <!--end:::Tab item-->
                                            </ul>
                                            <!--end:::Tabs-->
                                            <!--begin::Button-->
                                            <a href="../../demo1/dist/apps/ecommerce/sales/listing.html" class="btn btn-icon btn-light btn-active-secondary btn-sm ms-auto me-lg-n7">
                                                <i class="ki-duotone ki-left fs-2"></i>
                                            </a>
                                            <!--end::Button-->
                                            <!--begin::Button-->
                                            <a href="../../demo1/dist/apps/ecommerce/sales/edit-order.html" class="btn btn-success btn-sm me-lg-n7">Edit Order</a>
                                            <!--end::Button-->
                                            <!--begin::Button-->
                                            <a href="<?php echo get_page_link(15); ?>" class="btn btn-primary btn-sm">Add Order</a>
                                            <!--end::Button-->
                                        </div>
                                        
                                        <div class="card card-flush py-4 flex-row-fluid">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h2>Pay order invoice</h2>
                                                </div>
                                            </div>
                                               <div class="card-body">
                                                   
                                                   <div class="table-responsive">
                                                       <table class="table table-striped table-bordered">
                                                           <thead> 
                                                            <th>Criteria</th> <th> Value</th>
                                                           </thead>
                                                           <tbody>
                                                               <tr> <td>Payment Status</td> <td></td> </tr>
                                                               <tr> <td>Total:</td> <td></td> </tr>

                                                               <tr> <td colspan="2"> <a href="" class="btn btn-success btn-block">Pay Now </a></td> </tr>
                                                           </tbody>
                                                       </table>
                                                   </div>

                                               </div>
                                        </div>


                                        <!--begin::Order summary-->
                                        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                                            <!--begin::Order details-->
                                            <div class="card card-flush py-4 flex-row-fluid">
                                                <!--begin::Card header-->
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h2>Order:  # <?php echo $order->reference; ?></h2>
                                                    </div>
                                                </div>
                                                <!--end::Card header-->
                                                <!--begin::Card body-->
                                                <div class="card-body pt-0">
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                                            <tbody class="fw-semibold text-gray-600">
                                                                <tr>
                                                                    <td class="text-muted">
                                                                        <div class="d-flex align-items-center">
                                                                        <i class="ki-duotone ki-calendar fs-2 me-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>Date Added</div>
                                                                    </td>
                                                                    <td class="fw-bold text-end"><?php echo APHTools::justDate($order->created_at); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted">
                                                                        <div class="d-flex align-items-center">
                                                                        <i class="ki-duotone ki-wallet fs-2 me-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                        </i>Payment Method</div>
                                                                    </td>
                                                                    <td class="fw-bold text-end"><?php echo $order->payment_type; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted">
                                                                        <div class="d-flex align-items-center">
                                                                        <i class="ki-duotone ki-truck fs-2 me-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                            <span class="path5"></span>
                                                                        </i>Order Total</div>
                                                                    </td>
                                                                    <td class="fw-bold text-end"><?php echo $order->order_total; ?>  </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!--end::Table-->
                                                    </div>
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end::Order details-->
                                            <!--begin::Customer details-->
                                            <div class="card card-flush py-4 flex-row-fluid">
                                                <!--begin::Card header-->
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h2>Plan Details</h2>
                                                    </div>
                                                </div>
                                                <!--end::Card header-->
                                                <!--begin::Card body-->
                                                <div class="card-body pt-0">
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                                            <tbody class="fw-semibold text-gray-600">
                                                                <tr>
                                                                    <td class="text-muted">
                                                                        <div class="d-flex align-items-center">
                                                                        <i class="ki-duotone ki-profile-circle fs-2 me-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                        </i>Plan</div>
                                                                    </td>
                                                                    <td class="fw-bold text-end">
                                                                        <div class="d-flex align-items-center justify-content-end">
                                                                            <!--begin:: Avatar -->
                                                                            <div class="symbol symbol-circle symbol-25px overflow-hidden me-3">
                                                                                <a href="../../demo1/dist/apps/ecommerce/customers/details.html">
                                                                                    <div class="symbol-label">
                                                                                        <img src="assets/media/avatars/300-23.jpg" alt="Dan Wilson" class="w-100" />
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                            <!--end::Avatar-->
                                                                            <!--begin::Name-->
                                                                            <a href="../../demo1/dist/apps/ecommerce/customers/details.html" class="text-gray-600 text-hover-primary"><?php echo $plan->name; ?> </a>
                                                                            <!--end::Name-->
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted">
                                                                        <div class="d-flex align-items-center">
                                                                        <i class="ki-duotone ki-sms fs-2 me-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>Monthly Price</div>
                                                                    </td>
                                                                    <td class="fw-bold text-end">
                                                                        <a href="../../demo1/dist/apps/user-management/users/view.html" class="text-gray-600 text-hover-primary"><?php echo APHTools::toNg($plan->monthly_price); ?></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted">
                                                                        <div class="d-flex align-items-center">
                                                                        <i class="ki-duotone ki-phone fs-2 me-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>Sub Details</div>
                                                                    </td>
                                                                    <td class="fw-bold text-end"><?php echo $plan->sub_name; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!--end::Table-->
                                                    </div>
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end::Customer details-->
                                            <!--begin::Documents-->
                                            <div class="card card-flush py-4 flex-row-fluid">
                                                <!--begin::Card header-->
                                                <div class="card-header">
                                                    <div class="card-title">
                                                        <h2> Domain</h2>
                                                    </div>
                                                </div>
                                                <!--end::Card header-->
                                                <!--begin::Card body-->
                                                <div class="card-body pt-0">
                                                    <div class="table-responsive">
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                                            <tbody class="fw-semibold text-gray-600">
                                                                <tr>
                                                                    <td class="text-muted">
                                                                        <div class="d-flex align-items-center">
                                                                        <i class="ki-duotone ki-devices fs-2 me-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                            <span class="path5"></span>
                                                                        </i>Name
                                                                        <span class="ms-1" data-bs-toggle="tooltip" title="View the invoice generated by this order.">
                                                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                                <span class="path1"></span>
                                                                                <span class="path2"></span>
                                                                                <span class="path3"></span>
                                                                            </i>
                                                                        </span></div>
                                                                    </td>
                                                                    <td class="fw-bold text-end">
                                                                        <a href="" class="text-gray-600 text-hover-primary"><?php echo $name; ?></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted">
                                                                        <div class="d-flex align-items-center">
                                                                        <i class="ki-duotone ki-truck fs-2 me-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                            <span class="path3"></span>
                                                                            <span class="path4"></span>
                                                                            <span class="path5"></span>
                                                                        </i>Status
                                                                        <span class="ms-1" data-bs-toggle="tooltip" title="View the shipping manifest generated by this order.">
                                                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                                <span class="path1"></span>
                                                                                <span class="path2"></span>
                                                                                <span class="path3"></span>
                                                                            </i>
                                                                        </span></div>
                                                                    </td>
                                                                    <td class="fw-bold text-end">
                                                                        <a href="#" class="text-gray-600 text-hover-primary"><?php echo $domain->status; ?></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted">
                                                                        <div class="d-flex align-items-center">
                                                                        <i class="ki-duotone ki-discount fs-2 me-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>State
                                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Reward value earned by customer when purchasing this order">
                                                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                                <span class="path1"></span>
                                                                                <span class="path2"></span>
                                                                                <span class="path3"></span>
                                                                            </i>
                                                                        </span></div>
                                                                    </td>
                                                                    <td class="fw-bold text-end"><?php echo $domain->domain_state; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!--end::Table-->
                                                    </div>
                                                </div>
                                                <!--end::Card body-->
                                            </div>
                                            <!--end::Documents-->
                                        </div>
                                        <!--end::Order summary-->
                                        <!--begin::Tab content-->
                                        <div class="tab-content">
                                            <!--begin::Tab pane-->
                                            <div class="tab-pane fade show active" id="kt_ecommerce_sales_order_summary" role="tab-panel">
                                                <!--begin::Orders-->
                                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                                    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                                                        <!--begin::Payment address-->
                                                        <div class="card card-flush py-4 flex-row-fluid position-relative">
                                                            <!--begin::Background-->
                                                            <div class="position-absolute top-0 end-0 bottom-0 opacity-10 d-flex align-items-center me-5">
                                                                <i class="ki-solid ki-two-credit-cart" style="font-size: 14em"></i>
                                                            </div>
                                                            <!--end::Background-->
                                                            <!--begin::Card header-->
                                                            <div class="card-header">
                                                                <div class="card-title">
                                                                    <h2>Billing Address</h2>
                                                                </div>
                                                            </div>
                                                            <!--end::Card header-->
                                                            <!--begin::Card body-->
                                                            <div class="card-body pt-0">
                                                                <?php echo $billing->address;
echo ',';
if($billing->company_name !='') {
    echo '<br />'. $billing->company_name;
    echo ',';
}
?>

                                                            

                                                            <br /><?php echo $billing->city; ?> <?php echo $billing->postal_code; ?>,
                                                            <br /><?php echo $billing->province_or_state; ?>,

                                                            <br /><?php echo $billing->name; ?>.
                                                        </div>
                                                            <!--end::Card body-->
                                                        </div>
                                                        <!--end::Payment address-->
                                                        <!--begin::Shipping address-->
                                                        <div class="card card-flush py-4 flex-row-fluid position-relative">
                                                            <!--begin::Background-->
                                                            <div class="position-absolute top-0 end-0 bottom-0 opacity-10 d-flex align-items-center me-5">
                                                                <i class="ki-solid ki-delivery" style="font-size: 13em"></i>
                                                            </div>
                                                            <!--end::Background-->
                                                            <!--begin::Card header-->
                                                            <div class="card-header">
                                                                <div class="card-title">
                                                                    <h2>Registrant Address</h2>
                                                                </div>
                                                            </div>
                                                            <!--end::Card header-->
                                                            <!--begin::Card body-->
                                                            <div class="card-body pt-0">
                                                                <?php echo $reg->address; ?>,
                                                            <?php if($reg->company_name !='') {
                                                                echo '<br />'. $reg->company_name.',';
                                                            }


?>

                                                            <br /><?php echo $reg->city; ?> <?php echo $reg->postal_code; ?>,
                                                            <br /><?php echo $reg->province_or_state; ?>,

                                                            <br /><?php echo $reg->name; ?>.
                                                        </div>
                                                            <!--end::Card body-->
                                                        </div>
                                                        <!--end::Shipping address-->
                                                    </div>
                                                    <!--begin::Product List-->
                                                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                                        <!--begin::Card header-->
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                <h2>Order <?php echo $order->reference; ?></h2>
                                                            </div>
                                                        </div>
                                                        <!--end::Card header-->
                                                        <!--begin::Card body-->
                                                        <div class="card-body pt-0">
                                                            <div class="table-responsive">
                                                                <!--begin::Table-->
                                                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                                    <thead>
                                                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                                            <th class="min-w-175px">Item</th>
                                                                            <th class="min-w-100px text-end">Detail</th>
                                                                            <th class="min-w-70px text-end">Qty</th>
                                                                            <th class="min-w-100px text-end">Unit Price</th>
                                                                            <th class="min-w-100px text-end">Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="fw-semibold text-gray-600">
                                                                        <tr>
                                                                            <td>
                                                                                Domain
                                                                            </td>
                                                                            <td class="text-end">#<?php echo $domain->id_domain; ?></td>
                                                                            <td class="text-end"><?php echo $domain->first_year; ?></td>
                                                                            <td class="text-end"><?php echo $domain->price; ?></td>
                                                                            <td class="text-end"><?php echo APHTools::displayNg($domain->price * $domain->first_years); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                               Hosting Plan
                                                                            </td>
                                                                            <td class="text-end">#<?php echo $plan->id_plan; ?></td>
                                                                            <td class="text-end">
                                                                                1
                                                                            </td>
                                                                            <td class="text-end"><?php echo $plan->monthly_price; ?></td>
                                                                            <td class="text-end"><?php

                                                                            echo APHTools::displayNg($plan->monthly_price); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="4" class="text-end">Subtotal</td>
                                                                            <td class="text-end"><?php APHTools::showNgPrice($order->order_total); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="4" class="text-end">VAT (0%)</td>
                                                                            <td class="text-end">N0.00</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="4" class="text-end">Processing fee Rate</td>
                                                                            <td class="text-end">N0.00</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="4" class="fs-3 text-dark text-end">Grand Total</td>
                                                                            <td class="text-dark fs-3 fw-bolder text-end"><?php echo APHTools::showNgPrice($order->order_total); ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                        <!--end::Card body-->
                                                    </div>
                                                    <!--end::Product List-->
                                                </div>
                                                <!--end::Orders-->
                                            </div>
                                            <!--end::Tab pane-->
                                            <!--begin::Tab pane-->
                                            <div class="tab-pane fade" id="kt_ecommerce_sales_order_history" role="tab-panel">
                                                <!--begin::Orders-->
                                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                                    <!--begin::Order history-->
                                                    <div class="card card-flush py-4 flex-row-fluid">
                                                        <!--begin::Card header-->
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                <h2>Order History</h2>
                                                            </div>
                                                        </div>
                                                        <!--end::Card header-->
                                                        <!--begin::Card body-->
                                                        <div class="card-body pt-0">
                                                            <div class="table-responsive">
                                                                <!--begin::Table-->
                                                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                                    <thead>
                                                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                                            <th class="min-w-100px">Date Added</th>
                                                                            <th class="min-w-175px">Amount</th>
                                                                            <th class="min-w-70px">Payment Status</th>
                                                                            <th class="min-w-100px">Customer Notifed</th>
                                                                            <th class="min-w-100px">Active</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="fw-semibold text-gray-600">


                                                                        <?php
                                                                        if(count($invoices) >0):
                                                                            foreach($invoices  as $invoice): ?>
                                                                        <tr>
                                                                            <td><?php echo APHTools::justDate($invoice->created_at) ;?></td>
                                                                            <td><?php  APHTools::showNgPrice($invoice->invoice_amount); ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if($invoice->status =='Unpaid'):
                                                                                    echo '<div class="badge badge-light-danger">Unpaid</div>';
                                                                                elseif($invoice->status=='Paid'):
                                                                                    echo '<div class="badge badge-light-success">Paid</div>';
                                                                                endif;
                                                                                ?>

                                                                                <!--begin::Badges-->
                                                                                
                                                                                <!--end::Badges-->
                                                                            </td>
                                                                            <td>
                                                                                <?php if($invoice->active ==1):
                                                                                    echo '<div class="badge badge-success">Yes</div>';
                                                                                else:
                                                                                    echo '<div class="badge badge-danger">No</div>';
                                                                                endif;
                                                                                ?>
                                                                            </td>
                                                                        </tr>

                                                                    <?php endforeach;
endif;
?>
                                                                    
                                                                        
                                                                    </tbody>
                                                                </table>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                        <!--end::Card body-->
                                                    </div>
                                                    <!--end::Order history-->
                                                    <!--begin::Order data-->
                                                    <div class="card card-flush py-4 flex-row-fluid">
                                                        <!--begin::Card header-->
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                <h2>Order Data</h2>
                                                            </div>
                                                        </div>
                                                        <!--end::Card header-->
                                                        <!--begin::Card body-->
                                                        <div class="card-body pt-0">
                                                            <div class="table-responsive">
                                                                <!--begin::Table-->
                                                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                                                    <tbody class="fw-semibold text-gray-600">
                                                                        <tr>
                                                                            <td class="text-muted">IP Address</td>
                                                                            <td class="fw-bold text-end">172.68.221.26</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">Forwarded IP</td>
                                                                            <td class="fw-bold text-end">89.201.163.49</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">User Agent</td>
                                                                            <td class="fw-bold text-end">Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">Accept Language</td>
                                                                            <td class="fw-bold text-end">en-GB,en-US;q=0.9,en;q=0.8</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!--end::Table-->
                                                            </div>
                                                        </div>
                                                        <!--end::Card body-->
                                                    </div>
                                                    <!--end::Order data-->
                                                </div>
                                                <!--end::Orders-->
                                            </div>
                                            <!--end::Tab pane-->
                                        </div>
                                        <!--end::Tab content-->
                                    </div>

	



<?php
            require_once(dirname(__FILE__).'/before_footer.php');

get_footer();

else:

    wp_redirect(get_page_link(13));
    exit;

endif;

?>