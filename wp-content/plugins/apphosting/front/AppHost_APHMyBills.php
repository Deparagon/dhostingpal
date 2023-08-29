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

class AppHost_APHMyBills
{
    public function displayContent()
    {
        $user_id = get_current_user_id();
        $anon    = 'No';
        $mybills = (new AppHost_APHOrder())->customerBills($user_id);

        if ($user_id === (int) get_option('wg_theAnonymousJohn')) {
            $mybills = array();
            $anon    = 'Yes';
        }
        ?>

         <h2 class ="bill_payment_top"><?php esc_html_e('My Bills', 'wave-gate');?></h2>

         <div class ="row">
         <div class ="col-sm-12">
         <div class ="table-responsive">
            <table id="mybills_classic_table" class ="table table-striped table-bordered">
                <thead>
                    <th><?php esc_html_e('Date', 'wave-gate');?></th>
                    <th><?php esc_html_e('Reference', 'wave-gate');?></th>
                    <th><?php esc_html_e('Bill Name', 'wave-gate');?></th>
                    <th><?php esc_html_e('Customer Identitier', 'wave-gate');?></th> <th><?php esc_html_e('Amount', 'wave-gate');?></th> <th><?php esc_html_e('Provider Message', 'wave-gate');?></th>  <th><?php esc_html_e('Status', 'wave-gate');?></th>
                </thead>

                <tbody>

                    <?php if (count($mybills) > 0) :
                        foreach ($mybills as $b) : ?>
                                        <tr>
                                            <td><?php echo esc_html(APHTools::slashDate($b->date_add)); ?></td>
                                            <td><?php echo esc_html($b->bill_reference); ?></td>
                                            <td><?php echo esc_html($b->biller_name); ?></td>
                                            <td><?php echo esc_html($b->customer_identifier); ?></td>
                                            <td><?php echo esc_html($b->sign . ' ' . $b->service_amount); ?></td>
                                            <td><?php echo esc_html($b->bill_message);
                            if ($b->bill_extra != '') {
                                echo '. <br> Token: ' . esc_html($b->bill_extra);
                            }

                            ?></td>
                                            <td>
                                                <?php
                                if ($b->status == 'Pending') {
                                    echo '<span class="btn btn-block btn-danger">' . esc_html($b->status) . '</span>';
                                } elseif ($b->status == 'Processed') {
                                    echo '<span class="btn btn-block btn-warning">' . esc_html($b->status) . '</span>';
                                } elseif ($b->status == 'Completed') {
                                    echo '<span class="btn btn-block btn-success">' . esc_html($b->status) . '</span>';
                                } elseif ($b->status == 'Paid') {
                                    echo '<span class="btn btn-block btn-info">' . esc_html($b->status) . '</span>';
                                } else {
                                    echo '<span class="btn btn-block btn-warning">' . esc_html($b->status) . '</span>';
                                };?>
                        </td>

                    </tr>
                        <?php endforeach;
        else :
            ?>

                    <tr><td colspan="7"><?php if ($anon == 'Yes') {
                        esc_html_e('You are using guest account, you need to create an account to have bills recorded', 'wave-gate');
                    } else {
                        esc_html_e('You do not have bill payments yet', 'wave-gate');
                    }?> </td></tr>
                    <?php endif;?>
                </tbody>


            </table>
         </div>
         </div>
         </div>


             <?php if (count($mybills) > 0) : ?>
         <input type="hidden" id="counted_rows_bills" value="haverows" name="counted_rows_bills">
             <?php endif;
    }
}
