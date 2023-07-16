<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function payment()
    {
        $provider = new PayPalClient;

// Through facade. No need to import namespaces
        $provider = \PayPal::setProvider();
        $accessToken = $provider->getAccessToken();

        $data = json_decode('{
            "intent": "CAPTURE",
            "purchase_units": [
              {
                "amount": {
                  "currency_code": "PHP",
                  "value": "100.00"
                }
              }
            ],
            "application_context": {
                "return_url": "http://127.0.0.1:8000/paypal_success",
                "cancel_url": "http://127.0.0.1:8000/paypal_cancel"
            }
        }', true);
        $data['return_url'] = route('paypal_success');
        $data['cancel_url'] = route('paypal_cancel');
        $order = $provider->createOrder($data);
        if($order){

        }
        $successRedirect = $this->success();
        echo '<pre>';
        print_r($order);
        exit;
        return redirect($order);
    }

    public function success($request)
    {
        $provider = new PayPalClient;
        $provider = \PayPal::setProvider();
        $accessToken = $provider->getAccessToken();
        $order_id = '0B79704078068804T';
        $order = $provider->capturePaymentOrder($order_id);
        echo '<pre>';
        print_r($order);
        exit;
        return "Payment successful. Thank you!";
    }

    public function cancel()
    {
        return "Payment canceled. Please try again.";
    }

}
