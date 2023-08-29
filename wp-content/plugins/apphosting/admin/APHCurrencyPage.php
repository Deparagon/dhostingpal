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
class APHCurrencyPage
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'addMenu'));
        add_action('wp_ajax_ajaxCurrencyEditor', array($this, 'ajaxCurrencyEditor'));
    }

    public function addMenu()
    {
        add_submenu_page('apphosting_settings', esc_html__('Currencies', 'apphost'), esc_html__('Currencies', 'apphost'), 'manage_options', 'app_hostcurrencies', array($this, 'display'));
    }

    public function display()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHCurrency.php';
        $cobj = new APHCurrency();
        $currencies = $cobj->getCurrencies();
        $iso_codes = APHCurrency::getISos();
        $worldcurrencies = APHCurrency::getWordCurrencies();



        ?>

          <div class="admin-main-container-wave">
              <div class="card">
                <div class="card-header bg-white"><?php esc_html_e('Currencies', 'apphost'); ?> <button class="button_open_new_c_form btn btn-md btn-success"><?php esc_html_e('Add New', 'apphost'); ?></button></div>
                <div class="card-body">
                
                <div class="table_responsive">
                    <table id="table_is_data_t" class="table table-stripped table-bordered">
                        <thead>
                            <th><?php esc_html_e('Name', 'apphost'); ?> </th> <th><?php esc_html_e('Code', 'apphost'); ?> </th> <th><?php esc_html_e('Sign', 'apphost'); ?> </th> <th><?php esc_html_e('Active', 'apphost'); ?> </th> <th><?php esc_html_e('Conversion Rate', 'apphost'); ?> </th> <th><?php esc_html_e('Is Default', 'apphost'); ?> </th>
                        </thead>

                        <tbody>

                            <?php if (count($currencies) >0) :
                                foreach ($currencies as $cur) :?>
                                <tr>
                                    <td><?php echo esc_html($cur->name); ?></td>
                                    <td><?php echo esc_html($cur->iso_code); ?></td>
                                    <td><?php echo esc_html($cur->sign); ?></td>
                                    <td><?php if ($cur->active==1) {
                                        echo '<span data-currency_id="'.esc_html($cur->id_currency).'" data-value="'.esc_html($cur->active).'" class="toggleactivestate green-icon dashicons dashicons-saved"></span>';
                                    } else {
                                        echo '<span data-currency_id="'.esc_html($cur->id_currency).'" data-value="'.esc_html($cur->active).'" class="toggleactivestate red-icon dashicons dashicons-no"></span>';
                                    }?></td>
                                    <td><input type="number" class="form-control currency_rate_value" data-currency_id="<?php echo esc_html($cur->id_currency);?>" value="<?php echo esc_html($cur->rate); ?>" name="currency_rate"></td>
                                    <td><?php if ($cur->is_default==1) {
                                        echo '<button type="button"  data-currency_id="'.esc_html($cur->id_currency).'" data-value="'.esc_html($cur->is_default).'"  class="toggledefaultcurrency btn btn-xs btn-success">'.esc_html__('Yes', 'apphost').'</button>';
                                    } else {
                                        echo '<button type="button"  data-currency_id="'.esc_html($cur->id_currency).'" data-value="'.esc_html($cur->is_default).'"  class="toggledefaultcurrency btn btn-xs btn-danger">'.esc_html__('No', 'apphost').'</button>';
                                    } ?> </td>
                                  
                                </tr>


                                <?php  endforeach;
        endif;
        ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
                
                  
              </div>
         
            <div id="hidden_add_new_currency_form" class="admin-main-container-wave display_none">
                <form method="post" action="" id="add_new_currency_form">
              <div class="card">
                <div class="card-header bg-white"><?php esc_html_e('New Currency', 'apphost'); ?> </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7 col-12 col-xs-12">
                            <div class="form-group">
                                <label for=""><?php esc_html_e('Currency Name', 'apphost'); ?></label>
                                <select name="thecurrency" id="thecurrency" class="form-select">
                                    <?php if (count($worldcurrencies) >0) : ?>
                                        <?php foreach ($worldcurrencies as $wc) : ?>
                                            <?php if (!in_array($wc->code, $iso_codes)) : ?>
                                            <option value="<?php echo esc_html($wc->code.'|'.$wc->symbol.'|'.$wc->name.'|'.$wc->country_code); ?>"> <?php echo esc_html($wc->name); ?> </option>
                                            <?php endif;
                                        endforeach;
                                    endif; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for=""><?php esc_html_e('Currency Exchange', 'apphost'); ?></label>

                                <input type="number" step="any" name="currency_rate" class="form-control">
                            </div>

                        </div>
                        
                    </div>

                </div>
                 <div class="card-footer">
                     <div class="form-group">
                        <button type="submit" class="btn btn-md btn-success" id="submit_add_currency"><?php esc_html_e('Add Currency', 'apphost'); ?></button>
                     </div>
                 </div>
            </div>
           </form>
        </div>




        <?php if (count($currencies) >0) :
            echo '<input type="hidden" id="var_counted_rows" value="1">';
        endif;
        ?>
<div style="display:none;" class="translated_feew">
   <p id="success_trans"><?php esc_html_e('Sucsess', 'apphost'); ?></p> 
   <p id="yes_trans"><?php esc_html_e('Yes', 'apphost'); ?></p> 
   <p id="no_trans"><?php esc_html_e('No', 'apphost'); ?></p> 
</div>      
<div class="right_side_alert_message"></div>

        <?php
    }

    public function ajaxCurrencyEditor()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHTools.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHCurrency.php';

        if (isset($_POST)) {
            $typeof = APHTools::getValue('typeof');
            $value = (float) APHTools::getValue('value');
            $id_currency = (int) APHTools::getValue('id_currency');



            if ($typeof =='Rate') {
                if ($id_currency ==0) {
                    esc_html_e('Error! Currency id is required', 'apphost');
                    wp_die();
                }
                if ($value <0) {
                    esc_html_e('Rate most be greater than zero', 'apphost');
                    wp_die();
                }

                (new APHCurrency())->updateField($id_currency, 'rate', $value);
                echo esc_html('OK');
                wp_die();
            } elseif ($typeof =='Active') {
                if ($value ==1) {
                    (new APHCurrency())->updateField($id_currency, 'active', 0);
                } else {
                    (new APHCurrency())->updateField($id_currency, 'active', 1);
                }
                echo esc_html('OK');
                wp_die();
            } elseif ($typeof =='Isdefault') {
                $cobj = new APHCurrency();
                if ($value ==1) {
                    $default = $cobj->getDefault();
                    if (is_object($default) && $default->id_currency == $id_currency) {
                        esc_html_e('Set another currency as default and the old default currency will no longer be the default currency.', 'apphost');
                        wp_die();
                    } else {
                        $cobj->removeDefault();
                        $cobj->setDefault($id_currency);
                        echo esc_html('OK');
                        wp_die();
                    }
                } else {
                    $cobj->removeDefault();
                    $cobj->setDefault($id_currency);
                    echo esc_html('OK');
                    wp_die();
                }
            } elseif ($typeof =='newCurrency') {
                list($iso_code, $sign, $name, $country_code) = explode('|', APHTools::getValue('thecurrency'));
                $rate = (float) APHTools::getValue('currency_rate');
                if ($iso_code =='') {
                    esc_html_e('Currency code is required.', 'apphost');
                    wp_die();
                }

                if ($name =='' || $sign =='') {
                    esc_html_e('Currency name and sign are required.', 'apphost');
                    wp_die();
                }
                if ($rate < 0 || $rate ==0) {
                    esc_html_e('Error in currency conversion rate. Make correction and try again.', 'apphost');
                    wp_die();
                }

                $params = array('is_default'=>0, 'rate'=>$rate, 'country_code'=>$country_code, 'name'=>$name, 'description'=>$name, 'iso_code'=>$iso_code, 'sign'=>$sign);

                if ((new APHCurrency())->addCurrency($params)) {
                    echo esc_html('OK');
                    exit;
                }
                esc_html_e('Could not add new currency at this time. try again later.', 'apphost');
                wp_die();
            }
        }
    }
}// close class


new APHCurrencyPage();

?>
