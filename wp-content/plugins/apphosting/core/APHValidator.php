<?php
/**
 *
 */
class APHValidator
{
    public $errors =array();

    public function __construct()
    {
        add_action('init', array($this, 'validate'));
    }



    public function validate()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHTools.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHPaystack.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHOrder.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHInvoice.php';
        require_once plugin_dir_path(dirname(__FILE__)).'classes/APHLogger.php';



        $reference = APHTools::getValue('trxref');
        if (!$reference || $reference =='') {
            return false;
        }

        $ref = APHTools::getValue('reference');

        $oobject = new APHOrder();
        $i_instance = new APHInvoice();
        $ins_stack = new APHPaystack();

        $invoice = $i_instance->getByField('reference', $reference);
        if (!is_object($invoice)  || ! (int)$invoice->id_invoice > 0) {
            //
            APHLogger::log('Invoice object not found in db', 'Paystack Validation');
            return false;
        }


        $order = $oobject->getById($invoice->id_order);

        if (!is_object($order) ||  !(int) $order->id_order > 0) {
            APHLogger::log('Could not load order object with from the invoice, issue needs escalation.', 'Paystack Validation');
        }


        $resp = $ins_stack->verifyPayment($reference);



        if (!is_object($resp)) {
            APHLogger::log('Paystack Payment verifyPayment failed. reference: '.$reference, 'Paystack Validation');
            return;
        }

        if ($invoice->active !=1) {
            APHLogger::log('This Invoice '.$invoice->id_invoice.' is no longer active. Support needed, reference: '.$reference, 'Paystack Validation');
            //redirect to dashboard
        }

        if ($invoice->status !='Unpaid') {
            APHLogger::log('Invoice '.$invoice->id_invoice.' has been processed  earlier '.$reference, 'Paystack Validation');
            //redirect to dashboard
            return;
        }
        $to_be_paid = $invoice->invoice_amount * 100;
        if ($resp->status=='success' && $resp->gateway_response =='Successful') {
            $amountpaid = $resp->amount/100;
            APHInvoice::fieldUpdate($invoice->id_invoice, 'paid_amount', $amountpaid);
            if ($to_be_paid !=  $resp->amount) {
                APHLogger::log($invoice->id_invoice.' shows that amount paid '.$resp->amount.' is not equal to the order total '.$to_be_paid, 'Paystack Validation');
                return;
                //redirect to dashboard
            }

            APHOrder::fieldUpdate($invoice->id_invoice, 'status', 'Paid');
            if (isset($resp->authorization) && isset($resp->authorization->authorization_code)) {
                APHOrder::fieldUpdate($invoice->id_invoice, 'token', $resp->authorization->authorization_code);
                APHOrder::fieldUpdate($invoice->id_invoice, 'expiry', $resp->authorization->exp_year.'-'.$resp->authorization->exp_month.'-01');

                APHOrder::fieldUpdate($invoice->id_invoice, 'last_4digits', $resp->authorization->last4);
                APHOrder::fieldUpdate($invoice->id_invoice, 'first_6digits', $resp->authorization->bin);
                APHOrder::fieldUpdate($invoice->id_invoice, 'order_note', $resp->authorization->signature);
            }
            APHOrder::fieldUpdate($order->id_invoice, 'payment_date', date('Y-m-d'));

            APHLogger::log($order->id_order.' is marked as paid and is ready for processing, manually or via cron ', 'Paystack Validation');


            wp_safe_redirect(get_page_link(11).'?alerti=0&message='.esc_html__('Payment completed succesfully, check your email/phone for details', 'apphost'));
            exit;
        }
    }
}


new APHValidator();
