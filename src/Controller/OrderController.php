<?php

namespace App\Controller;

use App\Controller\Service\PayPalClient;
use Pam\Controller\MainController;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class OrderController extends MainController
{
    public function createMethod($debug = false)
    {
        $request = new OrdersCreateRequest();
        $request->headers["prefer"] = "return=representation";

        $request->body  = self::buildRequestBody();
        $client         = PayPalClient::client();
        $response       = $client->execute($request);

        return $response;
    }

    public function captureMethod($orderId, $debug = false)
    {
        $request    = new OrdersCaptureRequest($orderId);
        $client     = PayPalClient::client();
        $response   = $client->execute($request);

        return $response;
    }

    private static function buildRequestBody()
    {
        return array(
            "intent" => "CAPTURE",
            "application_context" =>
                array(
                    "return_url" => "https://arithmancie.com/index.php?access=theme",
                    "cancel_url" => "https://arithmancie.com/index.php?access=home"
                ),
            "purchase_units" =>
                array(
                    0 =>
                        array(
                            "amount" =>
                                array(
                                    "currency_code" => "EUR",
                                    "value" => "10.00"
                                )
                        )
                )
        );
    }
}
