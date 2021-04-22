<?php

namespace App\Controller\Service;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalClient
{
    /**
     * @return
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * @return
     */
    public static function environment()
    {
        return new SandboxEnvironment(PAYPAL_ID, PAYPAL_SECRET);
    }
}
