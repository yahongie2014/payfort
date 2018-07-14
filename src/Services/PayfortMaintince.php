<?php

namespace LaravelPayfort\Services;

use GuzzleHttp\Client;
use LaravelPayfort\Traits\PayfortMaintinceRequest;


class PayfortMaintince extends Payfort
{

    use PayfortMaintinceRequest;

    /**
     * Payfort API Processor Constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        # Call parent constructor to initialize common settings
        parent::__construct($config);

        $this->payfortEndpoint = 'https://paymentservices.payfort.com/FortAPI/paymentApi';

        # Check if it is sandbox environment to make requests to Payfort sandbox url.
        if (data_get($this->config, 'sandbox', false)) {
            $this->payfortEndpoint = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';
        }

        $this->httpClient = new Client([
            'curl' => [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => false
            ],
            'headers' => [
                'Accept' => 'application/json'
            ],
        ]);
    }
}