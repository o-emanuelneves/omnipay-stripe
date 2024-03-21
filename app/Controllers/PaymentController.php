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
        $this->gateway->setApiKey($this->apiKey);
    }

    public function authorization($mock)
    {
        try {
            $response = $this->gateway->authorize([
                'amount' => $mock['amount'],
                'currency' => $mock['currency'],
                'token' => $mock['token'],
            ])->send();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $response;
    }

    public function capture($mock)
    {
        try {
            $response = $this->gateway->capture([
                'amount' => $mock['amount'],
                'transactionReference' => $mock['transactionReference']
            ])->send();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $response;
    }

    public function refund($mock)
    {
        try {
            $response = $this->gateway->refund([
                'amount' => $mock['amount'],
                'transactionReference' => $mock['transactionReference']
            ])->send();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        return $response;
    }

    public function void($mock)
    {
       
        try {
            $response = $this->gateway->capture([
                'transactionReference' => $mock['transactionReference']
            ])->send();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $response;
    }

    public function getAuthorization()
    {
        $mock = [
            'amount' => '10.00',
            'currency' => 'USD',
            'token' => 'tok_visa',
        ];

        $response = $this->authorization($mock);

        if ($response->isRedirect()) {
            echo "Foi recebido um redirecinamento para o Gateway de pagamentos.";
            $response->redirect();
        } elseif ($response->isSuccessful()) {
            echo "Autorização concluída com sucesso! A referência de transação é: {$response->getTransactionReference()}";
        } else {
            echo "A autorização falhou \n";
            return $response->getMessage();
        }
    }
    
    public function getCapture($transactionReference)
    {
        $mock = [
            'amount' => '10.00',
            'transactionReference' =>  $transactionReference
        ];

        $response = $this->capture($mock);

        if ($response->isRedirect()) {
            echo "Foi recebido um redirecinamento para o Gateway de pagamentos.";
            $response->redirect();
        } elseif ($response->isSuccessful()) {
            echo "Compra concluída com sucesso!";
        } else {
            echo "A autorização falhou \n";
            return $response->getMessage();
        }
    }

    public function getRefund($transactionReference)
    {
        $mock = [
            'amount' => '10.00',
            'transactionReference' =>  $transactionReference
        ];

        $response = $this->refund($mock);

        if ($response->isRedirect()) {
            echo "Foi recebido um redirecinamento para o Gateway de pagamentos.";
            $response->redirect();
        } elseif ($response->isSuccessful()) {
            echo "Reembolso concluído com sucesso!";
        } else {
            echo "O Reembolso falhou \n";
            return $response->getMessage();
        }
    }

    public function getVoid($transactionReference){
        $mock = [
            'transactionReference' =>  $transactionReference
        ];

        $response = $this->void($mock);

        if ($response->isRedirect()) {
            echo "Foi recebido um redirecinamento para o Gateway de pagamentos.";
            $response->redirect();
        } elseif ($response->isSuccessful()) {
            echo "Cancelamento concluído com sucesso!";
        } else {
            echo "O cancelamento falhou \n";
            return $response->getMessage();
        }
    }

}
