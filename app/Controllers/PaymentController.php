<?php

namespace App\Controllers;

use Omnipay\Omnipay;

class PaymentController extends BaseController
{
    private $omniPay;
    private $gateway;
    private $apiKey;

    public function __construct()
    {
        $this->omniPay = new Omnipay();
        $this->gateway = $this->omniPay::create('Stripe');
        $this->apiKey = getenv('API_SECRET');
    }

    public function authorization()
    {
        $this->gateway->setApiKey($this->apiKey);
        $response = $this->gateway->authorize([
            'amount' => '10.00',
            'currency' => 'USD',
            'token' => 'tok_visa',
        ])->send();

        return $response;
    }

    public function capture($transactionReference)
    {
        $this->gateway->setApiKey($this->apiKey);
        try {
            $response = $this->gateway->capture([
                'amount' => '10.00',
                'transactionReference' =>  $transactionReference
            ])->send();
        } catch (\Throwable $th) {
            $th->getMessage();
        }

        return $response;
    }

    public function refund($transactionReference)
    {
        $this->gateway->setApiKey($this->apiKey);
        try {
            $response = $this->gateway->refund([
                'amount' => '10.00',
                'transactionReference' =>  $transactionReference
            ])->send();
        } catch (\Throwable $th) {
            echo $th->getMessage();
            return false;
        }

        return $response;
    }


    public function void($transactionReference)
    {
        $this->gateway->setApiKey($this->apiKey);
        try {
            $response = $this->gateway->capture([
                'transactionReference' =>  $transactionReference
            ])->send();
        } catch (\Throwable $th) {
            $th->getMessage();
        }

        return $response;
    }
}
