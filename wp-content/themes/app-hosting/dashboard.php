<?php
/**
 * Template Name:  Dashboard
 * Description: The app hosting dashboard.
 *
 */

$authuser = wp_get_current_user();
if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0):
    get_header();
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHPlan.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHInvoice.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHAddress.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHDomain.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHTools.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHOrder.php';
    require_once WP_PLUGIN_DIR.'/apphosting/classes/APHTicket.php';

    require_once(dirname(__FILE__).'/after_header.php');
    $ins_order = new APHOrder();
    $ins_domain = new APHDomain();
    $a_instance = new APHAddress();
    $t_instance = new APHTicket();
    $i_instance = new APHInvoice();

    $latestorders = $ins_order->latestMine($authuser->ID);

    $countorders = $ins_order->countByUserId($authuser->ID);
    $countdomains = $ins_domain->countByUserId($authuser->ID);

    $countactivedomains = $ins_domain->countActiveByUserId($authuser->ID);

    $countactiveorders = $ins_order->countActiveByUserId($authuser->ID);

    $counttickets = $t_instance->countByUserId($authuser->ID);
    $countaddresses = $a_instance->countByUserId($authuser->ID);
    $countinvoices = $i_instance->countByUserId($authuser->ID);
    $countinvoicepaid = $i_instance->countStatusByMe($authuser->ID);



    if($countorders ==0):
        ?>

 <!--begin::Card-->
									<div class="card">
										<!--begin::Card body-->
										<div class="card-body">
											<!--begin::Heading-->
											<div class="card-px text-center pt-15 pb-15">
												<!--begin::Title-->
												<h2 class="fs-2x fw-bold mb-0">Create your first website</h2>
												<!--end::Title-->
												<!--begin::Description-->
												<p class="text-gray-400 fs-4 fw-semibold py-7">Add Domain Name <i class="fa-solid fa-arrow-right"></i>
												Select App Type <i class="fa-solid fa-arrow-right"></i>
												Account Configuration <i class="fa-solid fa-arrow-right"></i>
												Complete Payment.
											</p>
												<!--end::Description-->
												<!--begin::Action-->
												<a href="<?php echo get_page_link(15); ?>" class="btn btn-primary er fs-6 px-8 py-4">Get Started here </a>
												<!--end::Action-->
											</div>
											<!--end::Heading-->
											<!--begin::Illustration-->
											<div class="text-center pb-15 px-5">
												<img src="<?php echo get_template_directory_uri();?>/assets/media/illustrations/sketchy-1/15.png" alt="" class="mw-100 h-200px h-sm-325px" />
											</div>
											<!--end::Illustration-->
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Card-->


					<br/> <br/>				

<?php endif; ?>
<!-- SECOND LAYER -->

	<div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
										<!--begin::Col-->
										<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
											<!--begin::Card widget 20-->
											<div class="card min-h-160 card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C">
												<!--begin::Header-->
												<div class="card-header pt-5">
													<!--begin::Title-->
													<div class="card-title d-flex flex-column">
														<!--begin::Amount-->
														<span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2"><?php echo $countorders; ?></span>
														<!--end::Amount-->
														<!--begin::Subtitle-->
														<span class="text-white opacity-75 pt-1 fw-semibold fs-6"> Orders</span>
														<!--end::Subtitle-->
													</div>
													<!--end::Title-->
												</div>
												<!--end::Header-->
												<!--begin::Card body-->
												<div class="card-body d-flex align-items-end pt-0">
													<!--begin::Progress-->
								
													<!--end::Progress-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card widget 20-->
											<!--begin::Card widget 7-->
										
											<!--end::Card widget 7-->
										</div>
										<!--end::Col-->
										<!--begin::Col-->
										<div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
											<!--begin::Card widget 17-->
											<div class="card min-h-160 card-flush h-md-50 mb-5 mb-xl-10">
												<!--begin::Header-->
												<div class="card-header pt-5">
													<!--begin::Title-->
													<div class="card-title d-flex flex-column">
														<!--begin::Info-->
														<div class="d-flex align-items-center">
															<!--begin::Currency-->
															<span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">Domains </span>
															<!--end::Currency-->
															<!--begin::Amount-->
															<span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2"><?php echo $countdomains; ?></span>
															<!--end::Amount-->
															<!--begin::Badge-->
															<span class="badge badge-light-success fs-base">
															 <?php echo $countactivedomains; ?></span>
															<!--end::Badge-->
														</div>
														<!--end::Info-->
														<!--begin::Subtitle-->
														<span class="text-gray-400 pt-1 fw-semibold fs-6">Active domains in my account</span>
														<!--end::Subtitle-->
													</div>
													<!--end::Title-->
												</div>
												<!--end::Header-->
												<!--begin::Card body-->
												<div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
													<!--begin::Chart-->
													
													<!--end::Chart-->
													<!--begin::Labels-->
													
													<!--end::Labels-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Card widget 17-->
											<!--begin::List widget 26-->
											
											<!--end::LIst widget 26-->
										</div>

									</div>



<?php

   $message  = APHTools::getValue('message');
    $alerti = APHTools::getValue('alerti');
    if(isset($message) && $message !='') {
        APHTools::naInfo($message);
    }
    ?>

<!-- THIRD LAYER -->

<div class="row">
	<div class="col-sm-12 col-12">
											<!--begin::Table Widget 5-->
											<div class="card card-flush h-xl-100">
												<!--begin::Card header-->
												<div class="card-header pt-7">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-dark">My Latest Orders</span>
														<span class="text-gray-400 mt-1 fw-semibold fs-6"> Total Orders <?php echo $countorders; ?></span>
													</h3>
													<!--end::Title-->
													
												</div>
												<!--end::Card header-->
												<!--begin::Card body-->
												<div class="card-body">
													<!--begin::Table-->
													<table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_table_widget_5_table">
														<!--begin::Table head-->
														<thead>
															<!--begin::Table row-->
															<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
																<th class="min-w-150px">Order Reference</th>
																<th class="text-end pe-3 min-w-100px">Domain</th>
																
																<th class="text-end pe-3 min-w-100px">Price</th>
																<th class="text-end pe-3 min-w-100px">Status</th>
																<th class="text-end pe-0 min-w-75px">Created On</th>
																<th class="text-end pe-0 min-w-75px">Action</th>
															</tr>
															<!--end::Table row-->
														</thead>
														<!--end::Table head-->
														<!--begin::Table body-->
														<tbody class="fw-bold text-gray-600">

															<?php if(count($latestorders) >0):
															    foreach($latestorders as $order): ?>

															<tr>
																<!--begin::Item-->
																<td>
																	# <?php echo $order->reference; ?>
																</td>
																<!--end::Item-->
																<!--begin::Product ID-->
																<td class="text-end"><?php echo $order->app_domain; ?></td>
																<!--end::Product ID-->
																<!--begin::Date added-->
																
																<!--end::Date added-->
																<!--begin::Price-->
																<td class="text-end"><?php echo APHTools::showNgPrice($order->order_total); ?></td>
																<!--end::Price-->
																<!--begin::Status-->
																<td class="text-end">
																	<span class="badge py-3 px-4 fs-7 badge-light-primary"><?php echo $order->status; ?></span>
																</td>
																<!--end::Status-->
																<!--begin::Qty-->
																<td class="text-end" data-order="58">
																	<span class="text-dark fw-bold"><?php echo APHTools::justDate($order->created_at); ?></span>
																</td>
																<td class="text-end">
																	<a href="<?php echo get_page_link(42);?>?id_order=<?php echo $order->id_order; ?>">view </a>
																</td>
																<!--end::Qty-->
															</tr>

														<?php
															    endforeach;
															else: ?>
                                                        <tr> <td colspan="6"> You do not have order yet. <a href="<?php echo get_page_link(15); ?>">Get started here </a> </td></tr>

														<?php endif; ?>


														
															
															

														</tbody>
														<!--end::Table body-->
													</table>
													<!--end::Table-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Table Widget 5-->
										</div>
	</div>




<!-- FOURTH LAYER -->
											<div class="row g-5 mt-40 g-xl-10">
												<!--begin::Col-->
												<div class="col-md-3 col-xl-3 mb-xxl-10">
													<!--begin::Card widget 8-->
													<div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
														<!--begin::Card body-->
														<div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
															<!--begin::Statistics-->
															<div class="mb-4 px-9">
																<!--begin::Info-->
																<div class="d-flex align-items-center mb-2">
																	<!--begin::Currency-->
																	<span class="fs-4 fw-semibold text-gray-400 align-self-start me-1&gt;"></span>
																	<!--end::Currency-->
																	<!--begin::Value-->
																	<span class="fs-2hx fw-bold text-gray-800 me-2 lh-1">Tickets</span>
																	<!--end::Value-->
																	<!--begin::Label-->
																	<span class="badge badge-light-success fs-base">
																	
																	<?php echo $counttickets; ?></span>
																	<!--end::Label-->
																</div>
																<!--end::Info-->
																
															</div>
															<!--end::Statistics-->
															<!--begin::Chart-->
															
															<!--end::Chart-->
														</div>
														<!--end::Card body-->
													</div>
													<!--end::Card widget 8-->
													
												</div>
												<!--end::Col-->
												<!--begin::Col-->
												<div class="col-md-3 col-xl-3 mb-xxl-10">
													<!--begin::Card widget 9-->
													<div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
														<!--begin::Card body-->
														<div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
															<!--begin::Statistics-->
															<div class="mb-4 px-9">
																<!--begin::Statistics-->
																<div class="d-flex align-items-center mb-2">
																	<!--begin::Value-->
																	<span class="fs-2hx fw-bold text-gray-800 me-2 lh-1">Addresses</span>
																	<!--end::Value-->
																	<!--begin::Label-->
																	<span class="badge badge-light-success fs-base">
																	<?php echo $countaddresses; ?></span>
																	<!--end::Label-->
																</div>
																<!--end::Statistics-->
																
															</div>
															<!--end::Statistics-->
															<!--begin::Chart-->
															
															<!--end::Chart-->
														</div>
														<!--end::Card body-->
													</div>
													<!--end::Card widget 9-->
													<!--begin::Card widget 7-->
													
													<!--end::Card widget 7-->
												</div>

												<div class="col-md-3 col-xl-3 mb-xxl-10">
													<!--begin::Card widget 9-->
													<div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
														<!--begin::Card body-->
														<div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
															<!--begin::Statistics-->
															<div class="mb-4 px-9">
																<!--begin::Statistics-->
																<div class="d-flex align-items-center mb-2">
																	<!--begin::Value-->
																	<span class="fs-2hx fw-bold text-gray-800 me-2 lh-1">Invoices</span>
																	<!--end::Value-->
																	<!--begin::Label-->
																	<span class="badge badge-light-success fs-base">
																	<?php echo $countinvoices; ?></span>
																	<!--end::Label-->
																</div>
																<!--end::Statistics-->
																
															</div>
															<!--end::Statistics-->
															<!--begin::Chart-->
															
															<!--end::Chart-->
														</div>
														<!--end::Card body-->
													</div>
													<!--end::Card widget 9-->
													<!--begin::Card widget 7-->
													
													<!--end::Card widget 7-->
												</div>

												<div class="col-md-3 col-xl-3 mb-xxl-10">
													<!--begin::Card widget 9-->
													<div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
														<!--begin::Card body-->
														<div class="card-body flow-to-min-height d-flex justify-content-between flex-column px-0 pb-0">
															<!--begin::Statistics-->
															<div class="mb-4 px-9">
																<!--begin::Statistics-->
																<div class="d-flex align-items-center mb-2">
																	<!--begin::Value-->
																	<span class="fs-2hx fw-bold text-gray-800 me-2 lh-1">Paid Invoices</span>
																	<!--end::Value-->
																	<!--begin::Label-->
																	<span class="badge badge-light-success fs-base">
																	<?php echo $countinvoicepaid; ?></span>
																	<!--end::Label-->
																</div>
																<!--end::Statistics-->
																
															</div>
															<!--end::Statistics-->
															<!--begin::Chart-->
															
															<!--end::Chart-->
														</div>
														<!--end::Card body-->
													</div>
													<!--end::Card widget 9-->
													<!--begin::Card widget 7-->
													
													<!--end::Card widget 7-->
												</div>
												<!--end::Col-->
											</div>
<!-- FIFTH LAYER -->
<!-- SIXTH LAYER -->





<?php
        require_once(dirname(__FILE__).'/before_footer.php');

get_footer();

else:

    wp_redirect(get_page_link(13));
    exit;

endif;

?>