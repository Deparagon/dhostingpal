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

class APHInternalActions
{
    public $authuser;
    public $user_id;
    public function internalActions()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHTools.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHPlan.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHDomain.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHCountry.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHDomainPrice.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHAddress.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHOrder.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHPaystack.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHCustomer.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHLogger.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHTicket.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'classes/APHReply.php';

        $request_token = APHTools::getValue('request_token');
        $this->return_url = home_url();
        $authuser = wp_get_current_user();
        if (is_object($authuser) && isset($authuser->ID) && (int) $authuser->ID >0):
            $this->authuser = $authuser;
            $this->user_id = $authuser->ID;

        else:
            APHTools::displayError('Invalid access, you need to login before you can have access to this page');

        endif;


        if ($request_token === 'APSHXFLDHIRKJAOFVQRLUKEWQTURTBKJAQCFPNJLQOUTDGVIXDMZGGFBVNSBNXLH') {
            $this->processDeletionProcess();
        }



        if ($request_token === 'APNHUJQFGAANFTNNAZCXTOIBJNPNLOBQXCSCQUMRBSJZFGGPOCLRZLIERFRZVSQF') {
            $this->processViewEditModel();
            exit;
        }

        if ($request_token === 'APTPYAVGNYCXXEHSJHXBPFESGAHUFWFZMNHSQYQSSTNPPLDISJXDCGKDLENBHOTV') {
            $this->updatedEditedAddress();
            exit;
        }
        if($request_token ==='APRBDAPGLPOMQWHQPTHGIAEKKQUOWRTOJXEQRCTSQZHWGOSWJURYYOKGOQFAKAZG') {
            $this->saveSupportTicket();
            exit;
        }

        if($request_token ==='APNOFFLIWQIMKKPTFHQQGPSDKTQGTUPCVWCPWZJIJGMPFHMQTOMROGOWSDLZVSBZ') {
            $this->saveSupportReply();
            exit;
        }

        if($request_token==='APNOLSBPAJWRLKTPCFCGTXARACZSKALILUTUJNMATOAABXNGDPVVLIWOUXUNTFXB') {
            $this->performTicketActions();
            exit;
        }

        if($request_token ==='APCUHHFTXIMXTRDHFCOIRBPDVHSQQJWZPWWPUOMSHXJLNEDRXZAWYMZWGZHWUTDQ') {
            $this->saveProfileDetails();
            exit;
        }
    }


    public function processDeletionProcess()
    {
        $de_object = APHTools::getValue('object');
        $id = (int) APHTools::getValue('id');

        if ($de_object =='') {
            APHTools::displayError('No object was selected for deletion, refresh page and try again');
        }
        if (!$id >0) {
            APHTools::displayError('No item was selected for deletion, refresh page and try again');
        }

        $instant = new $de_object();
        $instant->softDelete($id);

        APHTools::displaySuccess('Deleted successfully');

        // do deletion here
    }


    public function performTicketActions()
    {
        $de_object = APHTools::getValue('object');
        $id = (int) APHTools::getValue('id');
        $fx =  APHTools::getValue('viewtype');

        if ($de_object =='') {
            APHTools::displayError('Select a ticket');
        }
        if (!$id >0) {
            APHTools::displayError('No ticket was selected for update, refresh page and try again');
        }
        if($fx =='') {
            APHTools::displayError('No action selected for this ticket');
        }


        $instant = new $de_object();
        if($fx =='Closed' || $fx =='Open') {
            $instant->updateKey($id, 'status', $fx, '%s');
        } else {
            $instant->updateKey($id, 'read', 1, '%d');
        }


        APHTools::displaySuccess($fx.' action performed on ticket successfully');
    }



    public function processViewEditModel()
    {
        $de_object = APHTools::getValue('object');
        $id = (int) APHTools::getValue('id');
        $viewtype = APHTools::getValue('viewtype');
        if ($de_object =='') {
            APHTools::displayError('No object was selected for view');
        }
        if (!$id >0) {
            APHTools::displayError('No item was selected for edit/view');
        }

        $instance = new $de_object();
        if ($viewtype =='Edit') {
            $instance->getEditor($id);
        } else {
        }

        APHTools::displayError('Error occur reponding to your request, contact support');
    }


    public function saveProfileDetails()
    {
        $firstname = APHTools::getValue('user_firstname');
        $lastname = APHTools::getValue('user_lastname');
        $phone = APHTools::getValue('phone');

        if($firstname =='') {
            APHTools::displayError('First name is required');
        }
        if($lastname =='') {
            APHTools::displayError('Last name is required');
        }

        if($phone =='') {
            APHTools::displayError('Phone number is required');
        }

        update_user_meta($this->user_id, 'phone', $phone);

        $d = wp_update_user(array('ID'=>$this->user_id, 'user_firstname'=>$firstname, 'user_lastname'=>$lastname));
        if($d >0) {
            APHTools::displaySuccess('Profile details updated successfully');
        }

        if(is_wp_error($d)) {
            if(count($d->errors) >0) {
                foreach($d->errors as $er) {
                    APHTools::displayError($er);
                }
            }
        }
    }


    public function updatedEditedAddress()
    {
        $instance = new APHAddress();
        $instance->validateFields($_POST);
        if ($instance->saveField()) {
            APHTools::displaySuccess('Saved successfully');
        }
    }

    public function saveSupportTicket()
    {
        $message = APHTools::getValue('message');
        $subject = APHTools::getValue('subject');
        $t_instance = new APHTicket();

        if(trim($subject) =='') {
            APHTools::displayError('Ticket subject is required, fill in the subject /title');
        }
        $support_attachment = '';

        if(trim($message) =='') {
            APHTools::displayError('Message is required, fill in the message box');
        }

        if(isset($_FILES)) {
            if (isset($_FILES['attachment'])) {
                $upload_dir = wp_upload_dir();

                if (! empty($upload_dir['basedir'])) {
                    $user_dirname = $upload_dir['basedir'].'/contacts';
                    if (! file_exists($user_dirname)) {
                        wp_mkdir_p($user_dirname);
                    }
                    $filename = wp_unique_filename($user_dirname, $_FILES['attachment']['name']);

                    move_uploaded_file($_FILES['attachment']['tmp_name'], $user_dirname .'/'. $filename);
                    $support_attachment = $upload_dir['baseurl'].'/contacts/'.$filename;
                }
            }
        }
        $reference = 'DHPT'.APHTools::codeGenerator(11);

        $ticket = array('user_id'=>$this->user_id, 'reference'=>$reference, 'department'=>'Account', 'email'=>$this->authuser->user_email, 'phone'=>get_user_meta($this->user_id, 'phone', true), 'subject'=>$subject, 'fullname'=> $this->authuser->user_firstname.' '.$this->authuser->user_lastname, 'message'=>$message, 'attachment'=>$support_attachment, 'status'=>'Open', 'created_at'=>date('Y-m-d H:i:s'));
        $t_instance->filled = $ticket;
        $t_instance->saveField();

        $support = $t_instance->getLatest();
        if(is_object($support) && (int) $support->id_ticket > 0) {
            APHTools::displaySuccess('Ticket opened successfully, our support team will get back to you soon');
        }

        APHTools::displayError('Could not open new support ticket at this moment, try again later');
    }


    public function saveSupportReply()
    {
        $message = APHTools::getValue('message');
        $subject = APHTools::getValue('compose_subject');
        $id_ticket = (int) APHTools::getValue('id_ticket');
        $r_instance = new APHReply();

        if(trim($subject) =='') {
            APHTools::displayError('Ticket subject is required, fill in the subject /title');
        }
        $support_attachment = '';

        if(trim($message) =='') {
            APHTools::displayError('Message is required, fill in the message box');
        }

        if($id_ticket ==0) {
            APHTools::displayError('Invalid ticket selected, ensure that you selected the right ticket.');
        }

        if(isset($_FILES)) {
            if (isset($_FILES['rattachment'])) {
                $upload_dir = wp_upload_dir();

                if (! empty($upload_dir['basedir'])) {
                    $user_dirname = $upload_dir['basedir'].'/contacts';
                    if (! file_exists($user_dirname)) {
                        wp_mkdir_p($user_dirname);
                    }
                    $filename = wp_unique_filename($user_dirname, $_FILES['rattachment']['name']);

                    move_uploaded_file($_FILES['rattachment']['tmp_name'], $user_dirname .'/'. $filename);
                    $support_attachment = $upload_dir['baseurl'].'/contacts/'.$filename;
                }
            }
        }
        $reference = 'DHPT'.APHTools::codeGenerator(11);

        $reply = array('user_id'=>$this->user_id, 'id_ticket'=>$id_ticket, 'source'=>$this->authuser->user_firstname.' '.$this->authuser->user_lastname, 'message'=>$message,'status'=>'Open', 'reply_attachment'=>$support_attachment);

        $r_instance->filled = $reply;
        $r_instance->saveField();

        APHTicket::fieldUpdate($id_ticket, 'read', 1, '%d');
        APHTicket::fieldUpdate($id_ticket, 'replied', 1, '%d');
        APHTools::displaySuccess('You have successfully replied this ticket');
    }
}
