<?php

use App\Controllers\PaymentController;

use Faker\Factory;
use PHPUnit\Framework\TestCase;


class PaymentGatewayTest extends TestCase
{
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

    public function testPurchase()
    {
        $authorizationResponse = $this->paymentController->authorization();
        $this->assertTrue($authorizationResponse->isSuccessful());

        $transactionReference = $authorizationResponse->getTransactionReference();
        $purchaseResponse = $this->paymentController->capture($transactionReference);
        $this->assertTrue($purchaseResponse->isSuccessful());
    }

    public function testRefund()
    {
        $authorizationResponse = $this->paymentController->authorization();
        $this->assertTrue($authorizationResponse->isSuccessful());

        $transactionReference = $authorizationResponse->getTransactionReference();
        $refundResponse = $this->paymentController->refund($transactionReference);
        $this->assertTrue($refundResponse->isSuccessful());
    }

    public function testVoid()
    {
        $authorizationResponse = $this->paymentController->authorization();
        $this->assertTrue($authorizationResponse->isSuccessful());

        $transactionReference = $authorizationResponse->getTransactionReference();
        $voidResponse = $this->paymentController->void($transactionReference);
        $this->assertTrue($voidResponse->isSuccessful());
    }

    public function testRefundWithWrongAuthorization()
    {
        $faker = Factory::create();
        $transactionReference = $faker->uuid;
        $refundResponse = $this->paymentController->refund($transactionReference);
        $this->assertFalse($refundResponse == false);
    }

    public function testVoidWithWrongAuthorization()
    {
        $faker = Factory::create();
        $transactionReference = $faker->uuid;
        $voidResponse = $this->paymentController->void($transactionReference);
        $this->assertFalse($voidResponse == false);
    }

    public function testAuthorizationFailed()
    {
        $voidResponse = $this->paymentController->void($transactionReference);
        $this->assertFalse($voidResponse == false);
    }
}
