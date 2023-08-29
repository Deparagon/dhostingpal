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
class APHLogger extends APHModel
{
    public $id_log;
    public $user_id;
    public $log_type;
    public $message;
    public $payload;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_logs';
    }


    public function existCheckField()
    {
        return 'id_log';
    }

    public function primaryKey()
    {
        return 'id_log';
    }




    public function requiredFields()
    {
        return array( 'message');
    }

    public function definitions()
    {
        return array(
                'id_log'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'user_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'log_type'=>array('type'=>'STRING', 'validate'=>'isString'),
                'message'=>array('type'=>'STRING', 'validate'=>'isString'),
                'payload'=>array('type'=>'HTML', 'validate'=>'isString'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }




    public function doLog($message, $type='Default', $user_id = 0)
    {
        if ($user_id ==0) {
            $user_id = (int) get_current_user_id();
        }
        $this->filled = array('message'=>$message, 'log_type'=>$type, 'user_id'=>$user_id);
        $this->datatypes = array('%s', '%s', '%d');
        $this->saveField();

        return true;
    }

    public static function log($message, $type ='Default', $user_id = 0)
    {
        if ($user_id ==0) {
            $user_id = (int) get_current_user_id();
        }
        return (new self())->doLog($message, $type, $user_id);
    }


    public function getAllCustomers()
    {
        return $this->getAll();
    }





    public function dropCurrencies()
    {
        global $wpdb;
        require_once ABSPATH.'wp-admin/includes/upgrade.php';
        dbDelta('TRUNCATE TABLE '.$this->table);
        return true;
    }






    public function deleteMessage($id = '')
    {
        global $wpdb;
        $del = $wpdb->delete($this->table, array( $this->primaryKey() => $id), array('%d'));
        if ($del == 1) {
            return true;
        }

        return false;
    }


    public function existRows()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE %d  ", 1);
        $total = $wpdb->get_var($sql);
        if ((int) $total >0) {
            return true;
        }
        return false;
    }
}
