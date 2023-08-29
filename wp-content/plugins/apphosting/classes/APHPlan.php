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
class APHPlan extends APHModel
{
    public $id_plan;
    public $plan_type;
    public $app_type;
    public $name;
    public $plan_code;
    public $plan_code_id;
    public $sub_name;
    public $memory_size;
    public $disk_space;
    public $bandwidth;
    public $monthly_price;
    public $yearly_price;
    public $description;
    public $price_currency;
    public $status;
    public $payload;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        parent::__construct();
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_plans';
    }



    public function existCheckField()
    {
        return 'name';
    }

    public function primaryKey()
    {
        return 'id_plan';
    }




    public function requiredFields()
    {
        return array('plan_type','app_type', 'name', 'sub_name', 'memory_size', 'disk_space', 'bandwidth', 'monthly_price', 'yearly_price', 'description', 'status');
    }

    public function definitions()
    {
        return array(
                'id_plan'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'plan_type'=>array('type'=>'STRING', 'validate'=>'isString'),
                'app_type'=>array('type'=>'STRING', 'validate'=>'isString'),
                'name'=>array('type'=>'STRING', 'validate'=>'isString'),
                'sub_name'=>array('type'=>'STRING', 'validate'=>'isString'),
                'plan_code'=>array('type'=>'STRING', 'validate'=>'isString'),
                'plan_code_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'memory_size'=>array('type'=>'STRING', 'validate'=>'isString'),
                'disk_space'=>array('type'=>'STRING', 'validate'=>'isString'),
                'bandwidth'=>array('type'=>'STRING', 'validate'=>'isString'),
                'monthly_price'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'yearly_price'=>array('type'=>'FLOAT', 'validate'=>'isFloat'),
                'price_currency'=>array('type'=>'STRING', 'validate'=>'isString'),
                'description'=>array('type'=>'HTML', 'validate'=>'isString'),
                'payload'=>array('type'=>'STRING', 'validate'=>'isString'),
                'status'=>array('type'=>'STRING', 'validate'=>'isString'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }



    public static function fieldUpdate($id, $field, $value, $t = '%s')
    {
        return (new self())->updateKey($id, $field, $value, $t);
    }


    public function getAllPlans()
    {
        return $this->getAll();
    }


    public function getActivePlans()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE status =%s ORDER BY ".$this->primaryKey()." ASC ", 'active');
        return $wpdb->get_results($sql, OBJECT);
    }
}
