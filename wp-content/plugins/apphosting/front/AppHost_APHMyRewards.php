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

class AppHost_APHMyRewards
{
    public function displayContent()
    {
        $user_id       = get_current_user_id();
        $myrewards     = (new AppHost_APHPoint())->customerPoints($user_id);
        $points        = (new AppHost_APHPoint())->pointBalance($user_id);
        $points_value  = AppHost_APHPoint::getPointValue($points);
        $pointcurrency = (new AppHost_APHCurrency())->getById(get_option('FW_FWAVE_POINT_CURRENCY'));

        $anon = 'No';
        if ($user_id === (int) get_option('wg_theAnonymousJohn')) {
            $myrewards = array();
            $anon      = 'Yes';
        }

        ?>
         <h2 class="bill_payment_top"> <?php esc_html_e('My Rewards', 'wave-gate');?></h2>
<div class="row">
     <div class="col-sm-8 col-12 col-xs-12"></div>
     <div class="col-sm-4 col-12 col-xs-12">
         <div class="point_box">
                 <p><?php esc_html_e('Points:', 'wave-gate');?> <?php echo esc_html($points); ?> </p>

                 <p><?php esc_html_e('Value:', 'wave-gate');?>  <?php if (is_object($pointcurrency)) {
                     echo esc_html($pointcurrency->sign . ' ' . $points_value);
                 }?></p>
         </div>
     </div>
</div>
 <div class="row">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table id="mybills_classic_table" class="table table-striped table-bordered">
                <thead>
                    <th><?php esc_html_e('Date', 'wave-gate');?>  </th>
                    <th><?php esc_html_e('Credit', 'wave-gate');?></th>
                    <th><?php esc_html_e('Debit', 'wave-gate');?></th>
                    <th><?php esc_html_e('Status', 'wave-gate');?></th>
                    <th><?php esc_html_e('Comments', 'wave-gate');?></th>
                </thead>

                <tbody>

                    <?php if (count($myrewards) > 0) :
                        foreach ($myrewards as $b) : ?>
                            <tr>
                                <td><?php echo esc_html(APHTools::slashDate($b->date_add)); ?></td>
                                <td><?php echo esc_html($b->credit); ?></td>
                                <td><?php echo esc_html($b->debit); ?></td>
                                <td>
                                                <?php
                                                if ($b->status == 'Pending') {
                                                    echo '<span class="btn btn-block btn-danger">' . esc_html($b->status) . '</span>';
                                                } elseif ($b->status == 'Approved') {
                                                    echo '<span class="btn btn-block btn-success">' . esc_html($b->status) . '</span>';
                                                } else {
                                                    echo '<span class="btn btn-block btn-warning">' . esc_html($b->status) . '</span>';
                                                };
                            ?>
                        </td>
                        <td><?php echo esc_html($b->comments); ?></td>


                    </tr>
                        <?php endforeach;
        else : ?>
                    <tr><td colspan="8"><?php if ($anon == 'Yes') {
                        esc_html_e('You are using a guest account, create account to enjoy the benefits of our reward system.', 'wave-gate');
                    } else {
                        esc_html_e('You do not have bill payments points yet', 'wave-gate');
                    }?>   </td></tr>
                    <?php endif;?>
                </tbody>


            </table>
        </div>
    </div>
 </div>



        <?php if (count($myrewards) > 0) : ?>
<input type="hidden" id="counted_rows_bills" value="haverows" name="counted_rows_bills">
<input type="hidden" id="has_reward_loads" value="1">
        <?php endif;?>


        <?php if ($points >= get_option('FW_FWAVE_MIN_CONVERTABLE_POINT')) : ?>
<h2 class="my_points_converstion"> <?php esc_html_e('Points To Airtime', 'wave-gate');?>  </h2>
<button id="start_point_conversion_process" class="btn btn-md btn-success"><?php esc_html_e('Start Points Conversion', 'wave-gate');?>   </button>


<div class="holding_points_to_airtime display_none">
   <div class="aajaxx_response"></div>
    <form method="post" action="" id="points_to_airtime_conversion_form">
        <div class="form-group">
            <label for="country"><?php esc_html_e('Country', 'wave-gate');?> </label>
            <select name="country" id="country_code_change" class="form-control">
                <option value="NG"> <?php esc_html_e('Nigeria', 'wave-gate');?> </option>
                <option value="GH"> <?php esc_html_e('Ghana', 'wave-gate');?> </option>
                <option value="US"> <?php esc_html_e('United States', 'wave-gate');?> </option>
                <option value="KE"> <?php esc_html_e('Kenya', 'wave-gate');?></option>
                <option value="UG"> <?php esc_html_e('Uganda', 'wave-gate');?> </option>
            </select>
        </div>


    <div class="form-group">
        <label for=""></label>
        <div class="network_provider_list"></div>
    </div>

    <div class="form-group">
        <label for="mobile_number"><?php esc_html_e('Mobile Number', 'wave-gate');?> </label>
        <input type="text" name="mobile_number" class="form-control" id="mobile_number">
    </div>

    <button id="complete_conversion_btn" class="btn btn-success btn-md"><?php esc_html_e('Convert Points', 'wave-gate');?>  </button>
</form>
</div>

                <?php
        endif;
    }
}
