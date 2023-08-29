<?php
/**
 * DESCRIPTION.
 *
 *   App hosting WordPress Plugin for domain hosting pal
 *
 *  @author    Paragon Kingsley
 *  @copyright 2023 Paragon Kingsley
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License ("AFL") v. 3.0
 */

require_once 'APHModel.php';
class APHAddress extends APHModel
{
    public $id_address;
    public $user_id;
    public $address_type;
    public $email;
    public $firstname;
    public $lastname;
    public $address;
    public $address_2;
    public $city;
    public $phone;
    public $phone_mobile;
    public $postal_code;
    public $province_or_state;
    public $id_country;
    public $country_code;
    public $company_name;
    public $note;
    public $passport;
    public $certificate;
    public $legislation;
    public $societiesregistry;
    public $policalpartyregistry;
    public $other;
    public $address_name;
    public $active;
    public $payload;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_addresses';
    }



    public function existCheckField()
    {
        return 'id_address';
    }

    public function primaryKey()
    {
        return 'id_address';
    }


     public function getMyAddresses($id)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT a.*, name, code, currency_code FROM ".$this->table." a INNER JOIN ".$wpdb->prefix."aph_hosting_countries c ON c.id_country = a.id_country WHERE user_id = %d AND a.deleted = %d ORDER BY ".$this->primaryKey()." DESC ", $id, 0);
         return $wpdb->get_results($sql, OBJECT);
     }



     public function addressById($id_address)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT a.*, name, code, currency_code FROM ".$this->table." a INNER JOIN ".$wpdb->prefix."aph_hosting_countries c ON c.id_country = a.id_country WHERE id_address = %d AND a.deleted = %d ORDER BY ".$this->primaryKey()." DESC ", $id_address, 0);
         return $wpdb->get_row($sql, OBJECT);
     }


     public function firstBillingAddress($user_id, $address_type)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT a.*, name, code, currency_code FROM ".$this->table." a INNER JOIN ".$wpdb->prefix."aph_hosting_countries c ON c.id_country = a.id_country WHERE user_id = %d AND address_type =%s AND a.deleted = %d ORDER BY ".$this->primaryKey()." DESC ", $user_id, $address_type, 0);
         return $wpdb->get_row($sql, OBJECT);
     }


      public function countMineByType($id, $type='Registrant')
      {
          global $wpdb;
          $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE user_id = %d AND address_type = %s", $id, $type);
          return  $wpdb->get_var($sql);
      }



      public function countMineAndActive($id)
      {
          global $wpdb;
          $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE user_id = %d AND active =%d AND deleted = %d", $id, 1, 1);
          return  $wpdb->get_var($sql);
      }





   public static function fetchMine($id)
   {
       return (new self())->allMine($id);
   }



    public function requiredFields()
    {
        return array('user_id', 'address_type', 'firstname', 'lastname', 'address', 'city', 'postal_code', 'province_or_state', 'phone', 'id_country', 'address_name');
    }

    public function definitions()
    {
        return array(
                'id_address'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'user_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'address_type'=>array('type'=>'STRING', 'validate'=>'isString'),
                'email'=>array('type'=>'STRING', 'validate'=>'isString'),
                'firstname'=>array('type'=>'STRING', 'validate'=>'isString'),
                'lastname'=>array('type'=>'STRING', 'validate'=>'isString'),
                'address'=>array('type'=>'STRING', 'validate'=>'isString'),
                'address_2'=>array('type'=>'STRING', 'validate'=>'isString'),
                'city'=>array('type'=>'HTML', 'validate'=>'isString'),
                'postal_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'phone'=>array('type'=>'STRING', 'validate'=>'isString'),
                'phone_mobile'=>array('type'=>'STRING', 'validate'=>'isString'),
                'province_or_state'=>array('type'=>'STRING', 'validate'=>'isString'),
                'id_country'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'country_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'company_name'=>array('type'=>'STRING', 'validate'=>'isString'),
                'note'=>array('type'=>'STRING', 'validate'=>'isString'),
                'passport'=>array('type'=>'STRING', 'validate'=>'isString'),
                'certificate'=>array('type'=>'STRING', 'validate'=>'isString'),
                'legislation'=>array('type'=>'STRING', 'validate'=>'isString'),
                'societiesregistry'=>array('type'=>'STRING', 'validate'=>'isString'),
                'policalpartyregistry'=>array('type'=>'STRING', 'validate'=>'isString'),
                'active'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'other'=>array('type'=>'STRING', 'validate'=>'isString'),
                'address_name'=>array('type'=>'STRING', 'validate'=>'isString'),
                'payload'=>array('type'=>'HTML', 'validate'=>'isHtml'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }



    public function getAllPlans()
    {
        return $this->getAll();
    }



    public function getEditor($id)
    {
        $countries = (new APHCountry())->getActives();
        $address = $this->getById($id);
        if(!is_object($address) && $address->id_address ==0) {
            APHTools::displayError('Not a valid address object');
        }
        ob_start();
        ?>
        <form method="post" id="ap_submit_address_update_form" action="">
       <h4 class="title-top-forms">Edit Address</h4>
   <div class="row mb-3 ">
                                                <div class="col-sm-12 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" value="<?php echo $address->email; ?>" name="email" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                 
                                            </div>

                                            <input type="hidden" value="<?php echo $address->id_address; ?>" name="id_address" id="id_address">

                                             <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="firstname">First Name</label>
                                                        <input type="text" value="<?php echo $address->firstname; ?>" name="firstname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="lastname">Last Name</label>
                                                        <input type="text" value="<?php echo $address->lastname; ?>" name="lastname" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="address">Address</label>
                                                        <input type="text" value="<?php echo $address->address; ?>" name="address" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                 
                                                  <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label>
                                                        <input type="text" value="<?php echo $address->phone; ?>" name="phone" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>


                                                
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="city">City </label>
                                                        <input type="text" value="<?php echo $address->city; ?>" name="city" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="postal_code">Postal Code</label>
                                                        <input type="text" value="<?php echo $address->postal_code; ?>" name="postal_code" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                        <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="province_or_state">State/Province </label>
                                                        <input type="text" value="<?php echo $address->province_or_state; ?>" name="province_or_state" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="id_country">Country</label>
                                                        
                                                        
                                                        <select name="id_country" class="form-control form-control-lg form-control-solid"> 
                                                            <?php
                                                      if(count($countries) >0):
                                                          foreach($countries as $country): ?>
                                                            <option value="<?php echo $country->id_country; ?>" <?php if($country->id_country ==$address->id_country) {
                                                                echo 'selected';
                                                            } ?>> <?php echo $country->name; ?> </option>

                                                        <?php
                                                          endforeach;
                                                      endif;
        ?>
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                           <div class="row mb-2">
                                                <div class="col-sm-6 possible_error_line">
                                                    <div class="form-group">
                                                        <label for="company_name">Company Name (optional) </label>
                                                        <input type="text" value="<?php echo $address->company_name; ?>" name="company_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 possible_error_line">

                                                    <div class="form-group">
                                                        <label for="address_name">Give this address a name</label>
                                                        <input type="text" value="<?php echo $address->address_name; ?>" name="address_name" class="form-control form-control-lg form-control-solid"/>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                                            </div>
                                        </form>

          <?php
          $contents = ob_get_contents();
        ob_clean();
        APHTools::ajaxReport('OK', 'success', $contents);
    }
}
