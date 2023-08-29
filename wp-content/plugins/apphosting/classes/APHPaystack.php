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

require_once dirname(__FILE__).'/paystack/src/autoload.php';
require_once dirname(__FILE__).'/APHLogger.php';
require_once dirname(__FILE__).'/APHTools.php';
//require_once dirname(__FILE__).'/APHOrder.php';
class APHPaystack
{
    public $paystack;
    public function __construct()
    {
        $this->paystack = new Yabacon\Paystack(get_option('APH_PAYSTACK_SECRET_KEY'));
    }

    public function updateAPlan($plan)
    {
        if ($plan->plan_code !='') {
            $this->updatePlan($plan);
            return true;
        } else {
            $this->createPlan($plan);
            return true;
        }
    }
    public function createPlan($p)
    {
        $plandata = [
              'name'=>$p->name,
              'description'=>$p->description,
              'amount'=>APHTools::toNg($p->monthly_price) *100,
              'interval'=>'monthly',
              'send_invoices'=>true,
              'currency'=>'NGN'
            ];

        try {
            $payplan = $this->paystack->plan->create($plandata);

            if (is_object($payplan) && isset($payplan->status) && $payplan->status ==true) {
                if (isset($payplan->data)) {
                    APHPlan::fieldUpdate($p->id_plan, 'plan_code', $payplan->data->plan_code);
                    APHPlan::fieldUpdate($p->id_plan, 'plan_code_id', $payplan->data->id);
                    return true;
                }
            }
        } catch(\Yabacon\Paystack\Exception\ApiException $e) {
            APHLogger::log($e->getMessage(), 'Plan');
            return false;
        }
    }


        public function updatePlan($p)
        {
            try {
                $payplan = $this->paystack->plan->create([
                  'name'=>$p->name,
                  'description'=>$p->description,
                  'amount'=>APHTools::toNg($p->monthly_price) *100,
                  'interval'=>'monthly',
                  'send_invoices'=>true,
                  'currency'=>'NGN',
                ], ['id'=>$p->plan_code_id]);

                return true;
            } catch(\Yabacon\Paystack\Exception\ApiException $e) {
                APHLogger::log($e->getMessage(), 'Plan');
                return false;
            }
        }


    public function initiatePayment($invoice, $email)
    {
        try {
            $trans = $this->paystack->transaction->initialize([
              'amount'=>$invoice->invoice_amount*100,
              'email'=>$email,
              'reference'=>$invoice->reference,
            ]);

            if (is_object($trans) && isset($trans->status) && $trans->status ==true) {
                if (isset($trans->data)) {
                    APHInvoice::fieldUpdate($invoice->id_invoice, 'payment_url', $trans->data->authorization_url);
                    APHInvoice::fieldUpdate($invoice->id_invoice, 'payment_type', 'Paystack');
                    APHInvoice::fieldUpdate($invoice->id_invoice, 'access_code', $trans->data->access_code);

                    return true;
                }
            }
        } catch(\Yabacon\Paystack\Exception\ApiException $e) {
            APHLogger::log($e->getMessage(), 'initialize Transaction');
            return false;
        }
    }

    public function createCustomer($authuser)
    {
        try {
            $customer = $this->paystack->customer->create([
              'email'=>$authuser->user_email,
              'first_name'=>$authuser->first_name,
              'last_name'=>$authuser->last_name,
              'phone'=>$authuser->phone,
            ]);

            if (is_object($customer) && $customer->status ==true && isset($customer->data)) {
                $args = array('user_id'=>$authuser->ID, 'customer_code'=>$customer->data->customer_code, 'customer_id'=>$customer->data->id, 'integration'=>$customer->data->integration, 'created_at'=>date('Y-m-d H:i:s'));
                $aphcustomer = new APHCustomer();
                $aphcustomer->filled = $args;
                $aphcustomer->datatypes = array('%d', '%s', '%d', '%d', '%s');
                $aphcustomer->saveField();

                return true;
            }
        } catch(\Yabacon\Paystack\Exception\ApiException $e) {
            APHLogger::log($e->getMessage(), 'Create Customer');
            return false;
        }
    }



    public function verifyPayment($stack_reference)
    {
        $response = $this->paystack->transaction->verify([
                'reference'=>$stack_reference
                ]);
        if (is_object($response) && isset($response->status) && $response->status ==1 && isset($response->data) && is_object($response->data)) {
            return $response->data;
        }
        return false;
    }


    public function paymentCharge($authuser, $order)
    {
        $this->paystack->transaction->charge([
                'reference'=>'unique',
                'authorization_code'=>'auth_code',
                'email'=>'e@ma.il',
                'amount'=>1000 // in kobo
              ]);
    }

    public function chargeToken()
    {
        $this->paystack->transaction->chargeToken([
               'reference'=>'unique',
               'token'=>'pstk_token',
               'email'=>'e@ma.il',
               'amount'=>1000 // in kobo
             ]);
    }
    public function createSubscription()
    {
        try {
            $plan = $this->paystack->customer->create([
              'email'=>$authuser->user_email,
              'first_name'=>$authuser->first_name,
              'last_name'=>$authuser->last_name,
              'phone'=>$authuser->phone,
            ]);

            $arg = array('user_id'=>$authuser->ID, '');
        } catch(\Yabacon\Paystack\Exception\ApiException $e) {
            APHLogger::log($e->getMessage(), 'Subscription');
            return false;
        }
    }
}
