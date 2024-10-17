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

class APHModel
{
    public $filled;
    public $datatypes;
    public $latest_id;
    public $none_updatables = array();
    public $key_value;


    public function __construct()
    {
        global $wpdb;
        $this->none_updatables = array($this->primaryKey(), 'created_at');
    }

    public function existCheckField()
    {
        return 'name';
    }

    public function primaryKey()
    {
        return 'id';
    }

    public function requiredFields()
    {
        return array();
    }


    public function definitions()
    {
        return array();
    }



    public function validateFields($fields)
    {
        if (!is_array($fields)) {
            APHTools::displayError('No fields in the form submitted');
        }




        foreach ($fields as $name => $value) {
            if (in_array($name, array('action', 'request_token'))) {
                continue;
            }

            if (in_array($name, $this->requiredFields())) {
                if ($value =='') {
                    APHTools::displayError($name.' is required');

                    //validate more
                }
            }

            if ($name == $this->primaryKey()) {
                $this->key_value = (int) $value;
            }

            $fielddata =$this->definitions()[$name];
            if (is_array($fielddata)) {
                $callable = $fielddata['validate'];
                if ($callable !='') {
                    $this->$callable($name, $value);
                } else {
                    $this->isString($name, $value);
                }
            } else {
                $this->isString($name, $value);
            }
        }
    }


    public function isString($name, $value)
    {
        if (!in_array($name, $this->none_updatables)) {
            $this->datatypes[] = '%s';
        }
        $this->filled[$name] = htmlspecialchars($value);
    }


    public function isFloat($name, $value)
    {
        if (!in_array($name, $this->none_updatables)) {
            $this->datatypes[] = '%f';
            $this->filled[$name] = (float) $value;
        }
    }


    public function isInteger($name, $value)
    {
        if (!in_array($name, $this->none_updatables)) {
            $this->datatypes[] = '%d';
            $this->filled[$name] =  (int) $value;
        }
    }


    public function isHtml($name, $value)
    {
        if (!in_array($name, $this->none_updatables)) {
            $this->datatypes[] = '%s';
            $this->filled[$name] =   $value;
        }
        //remove scripts
    }



    public function isEmail($name, $value)
    {
        if (APHTools::isEmail($value)) {
            if (!in_array($name, $this->none_updatables)) {
                $this->datatypes[] = '%s';
                $this->filled[$name] = htmlspecialchars($value);
            }
        } else {
            APHTools::displayError($value.' is not a valid email cannot be filled in the field '.$name);
        }
    }


    public function saveField()
    {
        if ($this->checkExist($this->filled[$this->existCheckField()])) {
            $this->updateIfExist();
            return true;
        }

        global $wpdb;
        $this->filled['created_at'] = date('Y-m-d');
        $inserted = $wpdb->insert($this->table, $this->filled, $this->datatypes);

        $this->latest_id = $wpdb->insert_id;

        if ($inserted == 1) {
            return true;
        }
        return false;
    }




        public function allWithUsers()
        {
            global $wpdb;

            $sql = $wpdb->prepare("SELECT  b.*, U.id, u.user_login, u.display_name, u.user_email FROM ".$wpdb->prefix."users u INNER JOIN  $this->table b ON u.ID = b.user_id ORDER BY ".$this->primaryKey()." DESC ", 1);
            $result = $wpdb->get_results($sql);
            return $result;
        }



    public function allAndUsers()
    {
        global $wpdb;

        $sql = $wpdb->prepare("SELECT  b.*, u.ID, u.user_login, u.display_name, u.user_email FROM ".$wpdb->prefix."users u LEFT JOIN $this->table b   ON u.ID = b.user_id ORDER BY ID DESC ", 1);
        $result = $wpdb->get_results($sql);
        return $result;
    }


    public function leftUsers()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT u.ID, u.user_login, u.display_name, u.user_email FROM ".$wpdb->prefix."users u LEFT JOIN  $this->table b ON u.ID = b.user_id ORDER BY u.ID DESC ", 1);
        $result = $wpdb->get_results($sql);
        return $result;
    }



    public function getAll()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT  b.* FROM $this->table b ORDER BY ".$this->primaryKey()." DESC ", 1);
        $result = $wpdb->get_results($sql);
        return $result;
    }






    public function getFieldTypes($fields)
    {
        if (is_array($fields) && count($fields) >0) {
            foreach ($fields as $name => $value) {
                $fielddata =$this->definitions()[$name];
                if (is_array($fielddata)) {
                    $this->$fielddata['validate']($name, $value);
                } else {
                    $this->isString($name, $value);
                }
            }
        }

        return $this->datatypes;
    }


    public function checkExist($value)
    {
        $field = $this->existCheckField();
        global $wpdb;
        $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE ".$field." = %s  ", $value);
        $total = $wpdb->get_var($sql);
        if ((int) $total >0) {
            return true;
        }
        return false;
    }


    public function getByUniqueField()
    {
        $field = $this->existCheckField();
        $value = $this->filled[$this->existCheckField()];
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE deleted = 0 AND ".$field." = %s  ", $value);
        return $wpdb->get_row($sql);
    }


     public function myOwn($id)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE deleted = 0 AND user_id = %d", $id);
         return $wpdb->get_results($sql, OBJECT);
     }



     public function latestMine($id, $limit =4)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE deleted = 0 AND user_id = %d ORDER BY ".$this->primaryKey()." DESC LIMIT ".$limit, $id);
         return $wpdb->get_results($sql, OBJECT);
     }


    public function allMine($id)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE deleted = 0 AND user_id = %d ORDER BY ".$this->primaryKey()." DESC ", $id);
        return $wpdb->get_results($sql, OBJECT);
    }

    public function getMine($id)
    {
        return $this->allMine($id);
    }



     public function userFirst($id)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE deleted = 0 AND user_id = %d", $id);
         $result = $wpdb->get_row($sql, OBJECT);
         return $result;
     }


     public function countByUserId($id)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE deleted = 0 AND user_id = %d", $id);
         return  $wpdb->get_var($sql);
     }


public function countByStatus($id, $status='Open')
{
    global $wpdb;
    $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE deleted = 0 AND user_id = %d AND deleted = %d AND status =%s", $id, 0, $status);
    return  $wpdb->get_var($sql);
}



     public function countAllMine($id)
     {
         return $this->countByUserId($id);
     }

     public function countAll()
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE deleted = 0  ");
         return  $wpdb->get_var($sql);
     }


     public function countActiveByUserId($id)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT COUNT(".$this->primaryKey().") FROM $this->table WHERE deleted = 0 AND active = %d AND user_id = %d", 1, $id);
         return  $wpdb->get_var($sql);
     }

    public function checkIfUserHas($user_id)
    {
        $ob = $this->userFirst($user_id);
        if (is_object($ob) && isset($ob->user_id) && (int) $ob->user_id >0) {
            return true;
        }
        return false;
    }



    public function getLatest()
    {
        return $this->getById($this->latest_id);
    }

    public function getById($id)
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE deleted = 0 AND ".$this->primaryKey()." = %d", $id);
        $result = $wpdb->get_row($sql, OBJECT);
        return $result;
    }



     public function getByField($field, $value)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT * FROM $this->table WHERE deleted = 0 AND ".$field." = %s", $value);
         $result = $wpdb->get_row($sql, OBJECT);
         return $result;
     }

    public static function byField($field, $value)
    {
        return (new self())->getByField($field, $value);
    }



    public function updateKey($id, $key, $value, $t = "%s")
    {
        global $wpdb;
        $updated = $wpdb->update($this->table, array($key => $value), array($this->primaryKey() => $id), array($t), array('%d'));
        if ($updated == 1) {
            return true;
        }

        return false;
    }




    public function saveSelf()
    {
        global $wpdb;
        $fields = get_object_vars($this);

        $fieldtypes = $this->getFieldTypes($fields);
        $updated = $wpdb->update($this->table, $fields, array($this->primaryKey() => $this->$this->primaryKey()), $fieldtypes, array('%d'));
        if ($updated == 1) {
            return true;
        }

        return false;
    }


      public function updateIfExist()
      {
          global $wpdb;
          $obj = $this->getByUniqueField();

          if (isset($this->filled['created_at'])) {
              unset($this->filled['created_at']);
          }
          $primarykey = $this->primaryKey();
          $this->latest_id = $obj->$primarykey;
          if (is_object($obj) && (int) $obj->$primarykey >0) {
              $updated = $wpdb->update($this->table, $this->filled, array($primarykey => $obj->$primarykey), $this->datatypes, array('%d'));
              if ($updated == 1) {
                  return true;
              }
          }



          return false;
      }


        public function updateByPrimaryKey()
        {
            global $wpdb;
            $id = $this->primaryKey();
            $id_value = (int) $this->key_value;
            if ((int) $id_value > 0) {
                $wpdb->update($this->table, $this->filled, array($id => $id_value), $this->datatypes, array('%d'));
                return $this->getById($id_value);
            }



            return false;
        }






    public static function deleteD($id)
    {
        global $wpdb;
        $del = $wpdb->delete($this->table, array($this->primaryKey() => $id), array('%d'));
        if ($del == 1) {
            return true;
        }

        return false;
    }

    public function softDelete($id)
    {
        return $this->updateKey($id, 'deleted', 1, "%d");
    }



     public function LeftCombineAllThisUser($user_id)
     {
         global $wpdb;
         $sql = $wpdb->prepare("SELECT c.*,  u.ID, u.user_login, u.display_name, u.user_email FROM ".$wpdb->prefix."users u LEFT JOIN ".$this->table." c ON c.user_id = u.ID WHERE u.ID =%d ORDER BY u.ID DESC ", $user_id);
         $result = $wpdb->get_results($sql);
         return $result;
     }
}
