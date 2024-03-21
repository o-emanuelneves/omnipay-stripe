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
        $response = $this->paymentController->authorization([
            'amount' => '10.00',
            'currency' => 'USD',
            'token' => 'tok_visa',
        ]);

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->getTransactionReference());
    }

    public function testCapture()
    {
        $authorizationResponse = $this->paymentController->authorization([
            'amount' => '15.00',
            'currency' => 'BRL',
            'token' => 'tok_visa',
        ]);
        $this->assertTrue($authorizationResponse->isSuccessful());

        $transactionReference = $authorizationResponse->getTransactionReference();

        $purchaseResponse = $this->paymentController->capture([
            'amount' => '10.00',
            'transactionReference' =>  $transactionReference
        ]);
        $this->assertTrue($purchaseResponse->isSuccessful());
    }

    public function testRefund()
    {
        $authorizationResponse = $this->paymentController->authorization([
            'amount' => '15.00',
            'currency' => 'BRL',
            'token' => 'tok_visa',
        ]);
        $this->assertTrue($authorizationResponse->isSuccessful());

        $transactionReference = $authorizationResponse->getTransactionReference();

        $purchaseResponse = $this->paymentController->refund([
            'amount' => '15.00',
            'transactionReference' =>  $transactionReference
        ]);
        $this->assertTrue($purchaseResponse->isSuccessful());
    }


    public function testVoid()
    {
        $authorizationResponse = $this->paymentController->authorization([
                    'amount' => '15.00',
                    'currency' => 'BRL',
                    'token' => 'tok_visa',
                ]);
        $this->assertTrue($authorizationResponse->isSuccessful());

        $transactionReference = $authorizationResponse->getTransactionReference();
        $voidResponse = $this->paymentController->void(['transactionReference' =>  $transactionReference]);
        $this->assertTrue($voidResponse->isSuccessful());
    }

    public function testVoidWithWrongAuthorization()
    {
        $faker = Factory::create();
        $transactionReference = [
            'transactionReference' => $faker->uuid
        ];
        $voidResponse = $this->paymentController->void($transactionReference);
        $this->assertFalse($voidResponse->isSuccessful() || $voidResponse->isRedirect());
    }

    public function testAuthorizationFailed()
    {
        $mock = [
            'amount' => '10.00',
            'currency' => 'USD',
            'token' => 'tokenInvalido',
        ];
        $authorizationResponse = $this->paymentController->authorization($mock);
        $this->assertFalse($authorizationResponse->isSuccessful() || $authorizationResponse->isRedirect());
    }
}
