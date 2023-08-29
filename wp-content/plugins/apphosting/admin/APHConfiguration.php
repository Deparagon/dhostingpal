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
class APHConfiguration
{
    public function __construct()
    {
        add_action('admin_init', array($this, 'configurationInformation'));
        add_action('admin_menu', array($this, 'addMainMenu'));
    }


    public function addMainMenu()
    {
        add_menu_page(esc_html__('App Hosting', 'apphosting'), esc_html__('App Hosting', 'apphosting'), 'manage_options', 'apphosting_settings', array($this, 'ConfigurationContent'), 'dashicons-exerpt-view', '3.3');
    }


    public function configurationInformation()
    {
        register_setting('apphosting_m_conset', 'APP_HOST_ENABLE', ['type'=>'integer','sanitize_callback'=>array($this, 'validateReturnInt')]);
        register_setting('apphosting_m_conset', 'APP_HOST_LIVE', ['type'=>'integer','sanitize_callback'=>array($this, 'validateReturnInt')]);
        register_setting('apphosting_m_conset', 'APH_LIVE_FWAVE_KEY', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);
        register_setting('apphosting_m_conset', 'APH_LIVE_FWAVE_SECRETKEY', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);
        register_setting('apphosting_m_conset', 'APH_LIVE_WAVE_ENCYKEY', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);

        register_setting('apphosting_m_conset', 'APH_TEST_FWAVE_KEY', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);
        register_setting('apphosting_m_conset', 'APH_TEST_FWAVE_SECRETKEY', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);

        register_setting('apphosting_m_conset', 'APH_TEST_FWAVE_ENCYKEY', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);

        register_setting('apphosting_m_conset', 'APH_INTERNETBS_REG_STATUS', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);
        register_setting('apphosting_m_conset', 'APH_INTERNETBS_KEY', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);

        register_setting('apphosting_m_conset', 'APH_INTERNETBS_PASSWORD', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);
        register_setting('apphosting_m_conset', 'APH_INTERNETBS_USERNAME', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);


        register_setting('apphosting_m_conset', 'APH_PAYSTACK_PUBLIC_KEY', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);
        register_setting('apphosting_m_conset', 'APH_PAYSTACK_SECRET_KEY', ['type'=>'string','sanitize_callback'=>array($this, 'validateReturnString')]);
    }



    public function ConfigurationContent()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/AppHost_APHCurrency.php';
        $cobj = new AppHost_APHCurrency();
        $currencies = $cobj->getActiveCurrencies();

        $APP_HOST_ENABLE = esc_html(get_option('APP_HOST_ENABLE'));
        $APP_HOST_LIVE = esc_html(get_option('APP_HOST_LIVE'));
        $APH_LIVE_FWAVE_KEY = esc_html(get_option('APH_LIVE_FWAVE_KEY'));
        $APH_LIVE_FWAVE_SECRETKEY = esc_html(get_option('APH_LIVE_FWAVE_SECRETKEY'));
        $APH_LIVE_WAVE_ENCYKEY = esc_html(get_option('APH_LIVE_WAVE_ENCYKEY'));


        $APH_TEST_FWAVE_KEY = esc_html(get_option('APH_TEST_FWAVE_KEY'));
        $APH_TEST_FWAVE_SECRETKEY = esc_html(get_option('APH_TEST_FWAVE_SECRETKEY'));
        $APH_TEST_FWAVE_ENCYKEY = esc_html(get_option('APH_TEST_FWAVE_ENCYKEY'));


        $APH_INTERNETBS_REG_STATUS = esc_html(get_option('APH_INTERNETBS_REG_STATUS'));
        $APH_INTERNETBS_KEY = esc_html(get_option('APH_INTERNETBS_KEY'));
        $APH_INTERNETBS_PASSWORD = esc_html(get_option('APH_INTERNETBS_PASSWORD'));
        $APH_INTERNETBS_USERNAME = esc_html(get_option('APH_INTERNETBS_USERNAME'));

        $APH_PAYSTACK_PUBLIC_KEY = esc_html(get_option('APH_PAYSTACK_PUBLIC_KEY'));
        $APH_PAYSTACK_SECRET_KEY = esc_html(get_option('APH_PAYSTACK_SECRET_KEY'));



        settings_errors();



        ?>
<div class="admin-main-container-wave">
<form method="post" action="options.php">
        <?php settings_fields('apphosting_m_conset');
        ?>
<div class="card">
    <div class="card-header bg-white"><?php esc_html_e('Flutterwave Payment Solution and Bill Payment Services Configuration', 'apphosting'); ?> </div>
  <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                   <p class="alert alert-info"><strong><?php esc_html_e('If you do not have Flutterwave Account, Sign Up', 'apphosting'); ?></strong> <a target="_blank" href="https://dashboard.flutterwave.com/signup?referrals=RV743526"><?php esc_html_e('here', 'apphosting'); ?></a></p>
  

<div class="row mb-3">
    <label for="APP_HOST_ENABLE" class="col-sm-4 form-check-label col-form-label col-form-label-sm">
        <?php esc_html_e('Enable Flutterwave', 'apphosting'); ?>
  </label>
    <div class="col-sm-8">
        <input class="form-check-input" value="1" type="checkbox" name="APP_HOST_ENABLE" id="APP_HOST_ENABLE"  <?php if ($APP_HOST_ENABLE ==1) {
            echo 'checked';
        } ?>>
    </div>
</div>


<div class="row mb-3">
    <label for="APP_HOST_LIVE" class="col-sm-4 form-check-label col-form-label col-form-label-sm">
        <?php esc_html_e('Enable Live Transactions', 'apphosting'); ?>
  </label>
    <div class="col-sm-8">
        <input class="form-check-input" value="1" type="checkbox" name="APP_HOST_LIVE" id="APP_HOST_LIVE"  <?php if ($APP_HOST_LIVE ==1) {
            echo 'checked';
        } ?>>
    </div>
</div>

<h4 class="setting-line-head"> <?php esc_html_e('Live Keys', 'apphosting'); ?></h4>
<div class="row mb-3">
  <label for="APH_LIVE_FWAVE_KEY" class="col-sm-4 col-form-label col-form-label-sm"> <?php esc_html_e('Public Key', 'apphosting'); ?></label>
  <div class="col-sm-8">
    <input type="text"  value="<?php echo esc_html($APH_LIVE_FWAVE_KEY); ?>" name="APH_LIVE_FWAVE_KEY" class="form-control form-control-sm" id="APH_LIVE_FWAVE_KEY" placeholder="<?php esc_html_e('Public Key', 'apphosting'); ?>">
  </div>
</div>
<div class="row mb-3">
  <label for="APH_LIVE_FWAVE_SECRETKEY" class="col-sm-4 col-form-label"><?php esc_html_e('Secret Key', 'apphosting'); ?></label>
  <div class="col-sm-8">
    <input type="text" name="APH_LIVE_FWAVE_SECRETKEY" value="<?php echo esc_html($APH_LIVE_FWAVE_SECRETKEY); ?>" placeholder="<?php esc_html_e('Secret Key', 'apphosting'); ?>">
  </div>
</div>
<div class="row">
  <label for="APH_LIVE_WAVE_ENCYKEY" class="col-sm-4 col-form-label"><?php esc_html_e('Encryption Key', 'apphosting'); ?></label>
  <div class="col-sm-8">
    <input type="text" name="APH_LIVE_WAVE_ENCYKEY"  value="<?php echo esc_html($APH_LIVE_WAVE_ENCYKEY); ?>" class="form-control" id="APH_LIVE_WAVE_ENCYKEY" placeholder="<?php esc_html_e('Encryption Key', 'apphosting'); ?>">
  </div>
</div>




<h4 class="setting-line-head"> <?php esc_html_e('Sandbox Keys', 'apphosting'); ?></h4>
<div class="row mb-3">
  <label for="APH_TEST_FWAVE_KEY" class="col-sm-4 col-form-label col-form-label-sm"> <?php esc_html_e('Public Key', 'apphosting'); ?></label>
  <div class="col-sm-8">
    <input type="text" class="form-control form-control-sm" name="APH_TEST_FWAVE_KEY"  value="<?php echo esc_html($APH_TEST_FWAVE_KEY); ?>" id="APH_TEST_FWAVE_KEY" placeholder="<?php esc_html_e('Live Key', 'apphosting'); ?>">
  </div>
</div>
<div class="row mb-3">
  <label for="APH_TEST_FWAVE_SECRETKEY" class="col-sm-4 col-form-label"><?php esc_html_e('Secret Key', 'apphosting'); ?></label>
  <div class="col-sm-8">
    <input type="text" class="form-control" name="APH_TEST_FWAVE_SECRETKEY"  value="<?php echo esc_html($APH_TEST_FWAVE_SECRETKEY); ?>" id="APH_TEST_FWAVE_SECRETKEY" placeholder="<?php esc_html_e('Secret Key', 'apphosting'); ?>">
  </div>
</div>
<div class="row">
  <label for="APH_TEST_FWAVE_ENCYKEY" class="col-sm-4 col-form-label"><?php esc_html_e('Encryption Key', 'apphosting'); ?></label>
  <div class="col-sm-8">
    <input type="text" class="form-control" name="APH_TEST_FWAVE_ENCYKEY" value="<?php echo esc_html($APH_TEST_FWAVE_ENCYKEY); ?>" id="APH_TEST_FWAVE_ENCYKEY" placeholder="<?php esc_html_e('Encryption Key', 'apphosting'); ?>">
  </div>
</div>

            </div>
            <div class="col-sm-6">

                <div class="row">
                    <div class="col-sm-6 col-12">
                        
                        <div class="form-group">
                            <label for="APH_INTERNETBS_REG_STATUS">Internet BS State</label>
                            <select  name="APH_INTERNETBS_REG_STATUS" class="form-control">
                                <option value="Dev" <?php if ($APH_INTERNETBS_REG_STATUS =="Dev"): echo "selected"; endif; ?>>Development</option>
                                <option value="Live" <?php if ($APH_INTERNETBS_REG_STATUS =="Live"): echo "selected"; endif; ?>>Live</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        
                        <div class="form-group">
                            <label for="APH_INTERNETBS_KEY"> API Key</label>
                            <input type="text" value="<?php echo $APH_INTERNETBS_KEY; ?>" name="APH_INTERNETBS_KEY" class="form-control"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        
                        <div class="form-group">
                            <label for="APH_INTERNETBS_PASSWORD"> BS Password</label>
                            <input type="password" value="<?php echo $APH_INTERNETBS_PASSWORD; ?>" name="APH_INTERNETBS_PASSWORD" class="form-control"/>
                        </div>
                    </div>

                    <div class="col-sm-6 col-12">
                        
                        <div class="form-group">
                            <label for="APH_INTERNETBS_USERNAME"> BS Username</label>
                            <input type="text" value="<?php echo $APH_INTERNETBS_USERNAME; ?>" name="APH_INTERNETBS_USERNAME" class="form-control"/>
                        </div>
                    </div>
                    
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        
                        <div class="form-group">
                            <label for="APH_PAYSTACK_PUBLIC_KEY"> Paystack Public Key</label>
                            <input type="text" value="<?php echo $APH_PAYSTACK_PUBLIC_KEY; ?>" name="APH_PAYSTACK_PUBLIC_KEY" class="form-control"/>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        
                        <div class="form-group">
                            <label for="APH_PAYSTACK_SECRET_KEY">Paystack Secret Key</label>
                            <input type="password" value="<?php echo $APH_PAYSTACK_SECRET_KEY; ?>" name="APH_PAYSTACK_SECRET_KEY" class="form-control"/>
                        </div>
                    </div>
                    
                </div>
                

            </div>
        </div>




 




















</div>
</div>
  
  <div class="card-footer">
       <div class="col-12">
    <button class="btn btn-primary" type="submit"><?php esc_html_e('Save', 'apphosting'); ?></button>
  </div>
  </div>
</div>
</form>
</div>
<div class="cls"></div>



        <?php
    }

    public function validateReturnString($stext)
    {
        return sanitize_text_field($stext);
    }

    public function validateReturnInt($value)
    {
        return (int) $value;
    }

    public function validateReturnNumber($no)
    {
        return (float) $no;
    }
}// close class


new APHConfiguration();
