<?php

use App\Controllers\PaymentController;
use PHPUnit\Framework\TestCase;


class PaymentGatewayTest extends TestCase
{
    
    private $gateway;
    private $paymentController;

    protected function setUp(): void
    {
        $this->paymentController = new PaymentController(); 
    }

    public function testAuthorization()
    {
        $response = $this->paymentController->authorization();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->getTransactionReference());
    }

    // public function testPurchase()
    // {
    //     $authorizationResponse = $this->gateway->authorize([...]); // Preencha com os parâmetros necessários para a autorização
    //     $this->assertTrue($authorizationResponse->isSuccessful());

    //     $transactionReference = $authorizationResponse->getTransactionReference();

    //     $purchaseResponse = $this->gateway->purchase([
    //         'transactionReference' => $transactionReference,
    //         // outros parâmetros necessários para a compra
    //     ])->send();

    //     $this->assertTrue($purchaseResponse->isSuccessful());
    // }

    // public function testRefund()
    // {
    //     $authorizationResponse = $this->gateway->authorize([...]); // Preencha com os parâmetros necessários para a autorização
    //     $this->assertTrue($authorizationResponse->isSuccessful());

    //     $transactionReference = $authorizationResponse->getTransactionReference();

    //     $refundResponse = $this->gateway->refund([
    //         'transactionReference' => $transactionReference,
    //         // outros parâmetros necessários para o reembolso
    //     ])->send();

    //     $this->assertTrue($refundResponse->isSuccessful());
    // }

    // public function testCancellation()
    // {
    //     $authorizationResponse = $this->gateway->authorize([...]); // Preencha com os parâmetros necessários para a autorização
    //     $this->assertTrue($authorizationResponse->isSuccessful());

    //     $transactionReference = $authorizationResponse->getTransactionReference();

    //     $cancelResponse = $this->gateway->void([
    //         'transactionReference' => $transactionReference,
    //         // outros parâmetros necessários para o cancelamento
    //     ])->send();

    //     $this->assertTrue($cancelResponse->isSuccessful());
    // }

    // public function testFailedAuthorization()
    // {
    //     $response = $this->gateway->authorize([...]); // Preencha com parâmetros que devem resultar em uma falha de autorização

    //     $this->assertFalse($response->isSuccessful());
    // }
}
