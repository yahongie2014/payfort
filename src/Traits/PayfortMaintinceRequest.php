<?php

namespace LaravelPayfort\Traits;


trait PayfortMaintinceRequest
{

    /**
     * Display payfort payment page to tokenize customer credit card info
     *
     * @see https://docs.payfort.com/docs/merchant-page/build/index.html#parameters-submission-type
     *
     * @param array $data
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function CapturePage($data)
    {
        # Prepare redirection page request parameters
        $requestParams = [
            'command' => 'CAPTURE',
            'access_code' => $this->config['access_code'],
            'merchant_identifier' => $this->config['merchant_identifier'],
            'merchant_reference' => $data['merchant_reference'],
            'amount' => $data['amount'],
            'currency' => $this->config['merchant_identifier'],
            'language' => $this->config['language'],
            'fort_id' => $data['fort_id'],
            'signature' =>  $data['signature'],
            'order_description' => $data['merchant_reference']
        ];

        $response = $this->callPayfortAPI($requestParams);


        /*
         * According to payfort documentation
         * 22 refers to SDK Token creation success.
         * @see https://docs.payfort.com/docs/in-common/build/index.html#statuses
         */
        if ($response->status != '22') {
            throw new PayfortRequestException($response->response_message);
        }

        /*
         * According to payfort documentation
         * 22  refers to SDK Token creation success.
         * 000 refers to success message
         * @see https://docs.payfort.com/docs/in-common/build/index.html#messages
         */
        if ($response->response_code != '22000') {
            throw new PayfortRequestException($response->response_message);
        }

        return $response->status;

    }



    /**
     * Display payfort redirection page
     *
     * @param array $requestParams
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    private function callPayfortAPI($requestParams)
    {
        # Add payfort request signature to request data
        $requestParams['signature'] = $this->calcPayfortSignature($requestParams, 'request');

        try {
            # Make http request
            $rawResponse = $this->httpClient->post($this->payfortEndpoint, [
                'json' => $requestParams
            ])->getBody();

            $response = json_decode($rawResponse);

            if (data_get($response, 'status') == '00') {
                throw new PayfortException(data_get($response, 'response_message'));
            }

            # Verify response signature
            if (data_get($response, 'signature') != $this->calcPayfortSignature(((array)$response), 'response')) {
                throw new PayfortException('Payfort response signature mismatched');
            }

            return $response;

        } catch (\Exception $e) {
            throw new PayfortException($e);
        }
    }

}