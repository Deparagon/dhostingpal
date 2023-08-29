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
class APHTicket extends APHModel
{
    public $id_ticket;
    public $user_id;
    public $reference;
    public $email;
    public $phone;
    public $fullname;
    public $subject;
    public $message;
    public $attachment;
    public $status;
    public $note;
    public $replied;
    public $read;
    public $deleted;
    public $created_at;
    public $updated_at;

    public $filled;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix.'aph_hosting_tickets';
    }



    public function existCheckField()
    {
        return 'id_ticket';
    }

    public function primaryKey()
    {
        return 'id_ticket';
    }


     public function getTicketReplies($id)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT a.*, r.message AS reply_message, reply_attachment, source, r.status AS reply_status FROM ".$this->table." a INNER JOIN ".$wpdb->prefix."aph_hosting_replies r ON r.id_ticket = a.id_ticket WHERE user_id = %d AND a.deleted = %d ORDER BY ".$this->primaryKey()." DESC ", $id, 0);
         return $wpdb->get_results($sql, OBJECT);
     }



     public function getByReference($user_id, $reference)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT * FROM ".$this->table." a WHERE user_id = %d AND a.deleted = %d AND reference = %s  ", $user_id, 0, $reference);
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





   public static function fetchMine($id)
   {
       return (new self())->allMine($id);
   }


     public static function fieldUpdate($id, $field, $value, $t = '%s')
     {
         return (new self())->updateKey($id, $field, $value, $t);
     }



    public function requiredFields()
    {
        return array('reference', 'message', 'subject');
    }

    public function definitions()
    {
        return array(
                'id_ticket'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'user_id'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'reference'=>array('type'=>'STRING', 'validate'=>'isString'),
                'subject'=>array('type'=>'STRING', 'validate'=>'isString'),
                'fullname'=>array('type'=>'STRING', 'validate'=>'isString'),
                'message'=>array('type'=>'STRING', 'validate'=>'isString'),
                'phone'=>array('type'=>'STRING', 'validate'=>'isString'),
                'email'=>array('type'=>'STRING', 'validate'=>'isString'),
                'attachment'=>array('type'=>'STRING', 'validate'=>'isString'),
                'status'=>array('type'=>'HTML', 'validate'=>'isString'),
                'note'=>array('type'=>'STRING', 'validate'=>'isString'),
                'read'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'replied'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'deleted'=>array('type'=>'INTERGER', 'validate'=>'isInteger'),
                'created_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                'updated_at'=>array('type'=>'STRING', 'validate'=>'isString'),
                 );
    }



    public function getAllPlans()
    {
        return $this->getAll();
    }
}
