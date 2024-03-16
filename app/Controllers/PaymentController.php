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

    public function __construct()
    {
        $this->omniPay = new Omnipay();
        $this->gateway = $this->omniPay::create('Stripe');
    }

    // $settings = $this->gateway->getDefaultParameters();
    // var_dump($settings);

    // Autorização
    public function authorization()
    {
        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey('sk_test_51OumV1RsVKQv0KO6UYtbT0kCMACTlryxKKzUqYMBL6aet0mCqkDhPGgmfwRLK8gBbtbp9C0Lr4zNTlphYJqpYbSX00wgB6aieF');

        $response = $gateway->authorize([
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
            print_r($response);
        } else {
            // payment failed: display message to customer
            echo 'Pagamento falhou';
            echo $response->getMessage();
        }
    }


    //capture
    //refund
    // void


}
