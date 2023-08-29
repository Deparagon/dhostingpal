<?php
/**
 * Template Name:  My Addresses
 * Description: The app hosting address.
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
    $insorder = new APHOrder();
    $insaddress = new APHAddress();
    $alladdresses = $insaddress->getMyAddresses($authuser->ID);

    $countactives = $insaddress->countMineAndActive($authuser->ID);

    $countall = $insaddress->countByUserId($authuser->ID);

    $countregs = $insaddress->countMineByType($authuser->ID);
    $countbillings = $insaddress->countMineByType($authuser->ID, 'Billing');
    $countadmins = $insaddress->countMineByType($authuser->ID, 'Admin');
    ?>

   

    <div class="row g-5 g-xl-10">
                                        <!--begin::Col-->
                                        <div class="col-sm-6 col-xl-2 mb-xl-10">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-100">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <img src="assets/media/svg/brand-logos/instagram-2-1.svg" class="w-35px" alt="" />
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-7">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $countall; ?></span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-400">Addresses</span>
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
                                        <div class="col-sm-6 col-xl-2 mb-xl-10">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-100">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <img src="assets/media/svg/brand-logos/facebook-3.svg" class="w-35px" alt="" />
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-7">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $countactives; ?></span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-400">Actives</span>
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
                                        <div class="col-sm-6 col-xl-2 mb-xl-10">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-100">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <img src="assets/media/svg/brand-logos/dribbble-icon-1.svg" class="w-35px" alt="" />
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-7">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $countregs; ?></span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-400">Registrant</span>
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
                                        <div class="col-sm-6 col-xl-2 mb-xl-10">
                                            <!--begin::Card widget 2-->
                                            <div class="card h-lg-100">
                                                <!--begin::Body-->
                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                    <!--begin::Icon-->
                                                    <div class="m-0">
                                                        <img src="assets/media/svg/brand-logos/twitter.svg" class="w-35px" alt="" />
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Section-->
                                                    <div class="d-flex flex-column my-7">
                                                        <!--begin::Number-->
                                                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2"><?php echo $countadmins; ?></span>
                                                        <!--end::Number-->
                                                        <!--begin::Follower-->
                                                        <div class="m-0">
                                                            <span class="fw-semibold fs-6 text-gray-400">Admins</span>
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
                                                        <span class="text-white fs-3 fw-bold me-2">Billing</span>
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
                                                                <div class="text-white fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo $countbillings; ?>">0</div>
                                                            </div>
                                                            <!--end::Number-->
                                                            <!--begin::Label-->
                                                            <div class="fw-semibold fs-6 text-white opacity-50">Billing Addresses</div>
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


<!--begin::Login sessions-->
                                    <div class="card mb-5 mb-lg-10">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <!--begin::Heading-->
                                            <div class="card-title">
                                                <h3>My Address</h3>
                                            </div>
                                            <!--end::Heading-->
                                           
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body p-0">
                                            <!--begin::Table wrapper-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
                                                    <!--begin::Thead-->
                                                    <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                                                        <tr>
                                                             <th>S/No.</th>
                                                            <th class="min-w-100px">Name</th>
                                                            <th class="min-w-100px">Address</th>
                                                            <th class="min-w-100px">Phone</th>
                                                            <th class="min-w-100px">Postal code</th>
                                                            <th class="min-w-100px">City</th>
                                                            <th class="min-w-100px">Province/State</th>
                                                            <th class="min-w-100px">Country</th>
                                                            <th class="min-w-100px">Created At</th>
                                                            <th class="text-end min-w-70px">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <!--end::Thead-->
                                                    <!--begin::Tbody-->
                                                    <tbody class="fw-6 fw-semibold text-gray-600">

                                                        <?php
                                                        if(count($alladdresses) >0):
                                                            $s = 1;
                                                            foreach($alladdresses as $address): ?>


                                                        <tr>
                                                            <td>#<?php echo $s;
                                                                $s++?> </td>
                                                            <td>
                                                                <?php echo $address->firstname; ?>,  <?php echo $address->lastname; ?>
                                                            </td>
                                                            
                                                            <td><?php echo $address->address; ?></td>
                                                            <td><?php echo $address->phone; ?></td>
                                                            <td><?php echo $address->postal_code; ?></td>
                                                            <td><?php echo $address->city; ?></td>
                                                            <td><?php echo $address->province_or_state; ?></td>
                                                            <td><?php echo $address->name; ?></td>
                                                            <td><?php echo APHTools::justDate($address->created_at); ?></td>
                                                            
                                                        <td class="text-end">
                                                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                            <!--begin::Menu-->
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" data-viewtype="Edit" data-object="APHAddress" data-name="Address" data-id_object="<?php echo $address->id_address; ?>" class="item_view_edit_process_btn menu-link px-3">Edit</a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="javascript:void(0)" data-object="APHAddress" data-name="Address" data-id_object="<?php echo $address->id_address; ?>" class="delete_item_from_the_list menu-link px-3" data-kt-customer-table-filter="delete_row">Delete</a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu-->
                                                        </td>
                                                        </tr>

                                                    <?php endforeach;
                                                        else: ?>
                                                        <tr> <td colspan="10"> No address created yet </td></tr>
                                                    <?php
                                                        endif;
?>
                                                       
                                                     
                                                    </tbody>
                                                    <!--end::Tbody-->
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Table wrapper-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>


	



<?php
            require_once(dirname(__FILE__).'/before_footer.php');

get_footer();

else:

    wp_redirect(get_page_link(13));
    exit;

endif;

?>