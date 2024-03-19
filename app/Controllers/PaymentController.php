<?php

namespace App\Controllers;

use Omnipay\Omnipay;

/*
1. Criar um repositório no [GitHub](https://github.com) e compartilhar com a equipe da GPM;
2. Criar uma nova integração seguindo os padrões da biblioteca [Omnipay](https://github.com/thephpleague/omnipay);
3. Você deve fazê-la com o gateway de pagamento Asaas ou Stripe;
4. Foque mais nas seguintes operações: autorização, captura, estorno e cancelamento;
5. Escreva testes para garantir que a integração está funcionando corretamente;
6. Escreva um README explicando como instalar, configurar e utilizar a sua integração.
*/

class PaymentController extends BaseController
{
    private $omniPay;
    private $gateway;
    private $transactionReference;

    public function __construct()
    {
        $this->omniPay = new Omnipay();
        $this->gateway = $this->omniPay::create('Stripe');
    }

    // Autorização
    public function authorization()
    {
        $this->gateway->setApiKey('sk_test_51OumV1RsVKQv0KO6UYtbT0kCMACTlryxKKzUqYMBL6aet0mCqkDhPGgmfwRLK8gBbtbp9C0Lr4zNTlphYJqpYbSX00wgB6aieF');

        $response = $this->gateway->authorize([
            'amount' => '10.00',
            'currency' => 'USD',
            'token' => 'tok_visa',
        ])->send();

        if ($response->isRedirect()) {
            // redirect to offsite payment gateway
            echo 'redirecionamento gateway';
            $response->redirect();
        } elseif ($response->isSuccessful()) {
            // payment was successful: update database
            echo 'Pagamento realizado ';
            $this->transactionReference = $response->getTransactionReference();
            print_r($this->transactionReference);
        } else {
            // payment failed: display message to customer
            echo 'Pagamento falhou';
            echo $response->getMessage();
        }

        return $response;
    }

    public function capture()
    {
        $this->gateway->setApiKey('sk_test_51OumV1RsVKQv0KO6UYtbT0kCMACTlryxKKzUqYMBL6aet0mCqkDhPGgmfwRLK8gBbtbp9C0Lr4zNTlphYJqpYbSX00wgB6aieF');

        try {
            $response = $this->gateway->capture([
                'amount' => '10.00',
                'transactionReference' =>  'ch_3OvpleRsVKQv0KO60Pfwedq9'
            ])->send();
        } catch (\Throwable $th) {
            print_r($th);
        }

        if ($response->isRedirect()) {
            // redirect to offsite payment gateway
            echo 'redirecionamento gateway';
            $response->redirect();
        } elseif ($response->isSuccessful()) {
            // payment was successful: update database
            echo 'Pagamento realizado ';
            print_r($response);
        } else {
            // payment failed: display message to customer
            echo 'Pagamento falhou';
            echo $response->getMessage();
        }
        return $response;
    }


    //refund
    public function refund()
    {
        $this->gateway->setApiKey('sk_test_51OumV1RsVKQv0KO6UYtbT0kCMACTlryxKKzUqYMBL6aet0mCqkDhPGgmfwRLK8gBbtbp9C0Lr4zNTlphYJqpYbSX00wgB6aieF');
        try {
            $response = $this->gateway->refund([
                'amount' => '10.00',
                'transactionReference' =>  'ch_3OvpplRsVKQv0KO608bvl9TN'
            ])->send();
        } catch (\Throwable $th) {
            print_r($th);
        }

        if ($response->isRedirect()) {
            // redirect to offsite payment gateway
            echo 'redirecionamento gateway';
            $response->redirect();
        } elseif ($response->isSuccessful()) {
            // payment was successful: update database
            echo 'Pagamento realizado ';
            print_r($response);
        } else {
            // payment failed: display message to customer
            echo 'Pagamento falhou';
            echo $response->getMessage();
        }
        return $response;
    }


    public function void()
    {
        $this->gateway->setApiKey('sk_test_51OumV1RsVKQv0KO6UYtbT0kCMACTlryxKKzUqYMBL6aet0mCqkDhPGgmfwRLK8gBbtbp9C0Lr4zNTlphYJqpYbSX00wgB6aieF');
        try {

            $response = $this->gateway->capture([
                'transactionReference' =>  'ch_3OvpplRsVKQv0KO608bvl9TN'
            ])->send();
        } catch (\Throwable $th) {
            $th->getMessage();
        }

        if ($response->isRedirect()) {
            // redirect to offsite payment gateway
            echo 'redirecionamento gateway';
            $response->redirect();
        } elseif ($response->isSuccessful()) {
            // payment was successful: update database
            echo 'Pagamento realizado ';
            print_r($response);
        } else {
            // payment failed: display message to customer
            echo 'Pagamento falhou';
            echo $response->getMessage();
        }
        return $response;
    }
}
