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
class APHReply extends APHModel
{
    public $id_reply;
    public $id_ticket;
    public $user_id;
    public $source;
    public $message;
    public $reply_attachment;
    public $status;
    public $deleted;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_replies';
    }



    public function existCheckField()
    {
        return 'id_reply';
    }

    public function primaryKey()
    {
        return 'id_reply';
    }


     public function getTicketReplies($id)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT t.*, r.message AS reply_message, reply_attachment, source, r.status AS reply_status FROM ".$this->table." r INNER JOIN ".$wpdb->prefix."aph_hosting_tickets t ON t.id_ticket = r.id_ticket WHERE r.id_ticket = %d AND t.deleted = %d ORDER BY ".$this->primaryKey()." DESC ", $id, 0);
         return $wpdb->get_results($sql, OBJECT);
     }




     public function addressById($id_address)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT a.*, name, code, currency_code FROM ".$this->table." a INNER JOIN ".$wpdb->prefix."aph_hosting_countries c ON c.id_country = a.id_country WHERE id_address = %d AND a.deleted = %d ORDER BY ".$this->primaryKey()." DESC ", $id_address, 0);
         return $wpdb->get_row($sql, OBJECT);
     }


      public function countMineByRead($id, $read=1)
      {
          global $wpdb;
          $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE user_id = %d AND read = %d", $id, $read);
          return  $wpdb->get_var($sql);
      }



      public function countMineByReplied($id, $replied=1)
      {
          global $wpdb;
          $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE user_id = %d AND replied = %d", $id, $replied);
          return  $wpdb->get_var($sql);
      }



      public function countMineAndActive($id)
      {
          global $wpdb;
          $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE user_id = %d AND active =%d AND deleted = %d", $id, 1, 1);
          return  $wpdb->get_var($sql);
      }



    public static function fieldUpdate($id, $field, $value, $t = '%s')
    {
        return (new self())->updateKey($id, $field, $value, $t);
    }



   public static function fetchMine($id)
   {
       return (new self())->allMine($id);
   }



    public function requiredFields()
    {
        return array('id_ticket', 'message');
    }

    public function definitions()
    {
        return array(
                'id_reply'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'id_ticket'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'user_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'reply_attachment'=>array('type'=>'STRING', 'validate'=>'isString'),
                'status'=>array('type'=>'HTML', 'validate'=>'isString'),
                'message'=>array('type'=>'STRING', 'validate'=>'isString'),
                'deleted'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }
}
