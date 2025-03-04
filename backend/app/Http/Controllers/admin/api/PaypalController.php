<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\PaypalPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        $paypal_conf = config('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret']
        ));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function payWithPaypal(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'amount' => 'required',
            // 'user_id' => 'required|exists:users,id'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validate->errors()
            ], 422);
        }

        try {
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item = new Item();
            $item->setName('Item')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($request->amount);

            $item_list = new ItemList();
            $item_list->setItems([$item]);

            $amount = new Amount();
            $amount->setCurrency('USD')
                ->setTotal($request->amount);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Payment transaction');

            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(route('api.paypal.status'))
                          ->setCancelUrl(route('api.paypal.status'));


            $payment = new Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions([$transaction]);

            $payment->create($this->_api_context);

            $paypalPayment = PaypalPayment::create([
                'amount' => $request->amount,
                'user_id' => $request->user_id,
                'currency' => 'USD',
                'paypal_payment_id' => $payment->getId()
            ]);

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    return response()->json([
                        'success' => true,
                        'payment_id' => $payment->getId(),
                        'redirect_url' => $link->getHref()
                    ], 200);
                }
            }

            return response()->json(['success' => false, 'message' => 'Unknown error occurred'], 500);
        } catch (\Exception $ex) {
            return response()->json(['success' => false, 'message' => 'Payment failed', 'error' => $ex->getMessage()], 500);
        }
    }

    public function getPaymentStatus(Request $request)
    {
        $payment_id = $request->query('payment_id');
        $payer_id = $request->query('PayerID');

        if (!$payment_id || !$payer_id) {
            return response()->json(['success' => false, 'message' => 'Payment failed'], 400);
        }

        try {
            $payment = Payment::get($payment_id, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId($payer_id);
            $result = $payment->execute($execution, $this->_api_context);

            if ($result->getState() == 'approved') {
                PaypalPayment::where('paypal_payment_id', $payment_id)
                    ->update(['status' => 'approved']);

                return response()->json(['success' => true, 'message' => 'Payment successful'], 200);
            }
            return response()->json(['success' => false, 'message' => 'Payment not approved'], 400);
        } catch (\Exception $ex) {
            return response()->json(['success' => false, 'message' => 'Error processing payment', 'error' => $ex->getMessage()], 500);
        }
    }
}
