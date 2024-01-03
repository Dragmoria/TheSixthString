<?php

namespace Service;

use Lib\Database\Entity\PaymentProvider;
use Lib\Enums\PaymentMethod;
use Lib\Helpers\TaxHelper;
use Mollie\Api\MollieApiClient;
use Mollie\Api\Resources\Payment;

//mollie api client code downloaded from https://github.com/mollie/mollie-api-php
//mollie needed the following packages:
//https://github.com/guzzle/guzzle
//https://github.com/php-fig/http-client/tree/master
//https://github.com/composer/ca-bundle
//https://github.com/php-fig/http-message
//https://github.com/guzzle/promises

class PaymentService extends BaseDatabaseService {
    public function createPayment(int $orderId, PaymentMethod $method): Payment {
        $mollieClient = $this->getMollieApiClient();

        $orderTotal = $this->executeQuery("select orderTotal from `order` where id = ?", [$orderId])[0]->orderTotal ?? null;
        $orderTotal = TaxHelper::calculatePriceIncludingTax($orderTotal);
        $orderTotalFormatted = number_format($orderTotal, 2, ".");

        return $mollieClient->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $orderTotalFormatted,
            ],
            "method" => strtolower($method->name),
            "description" => "Betaling van bestelling #$orderId",
            "redirectUrl" => "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/ShoppingCart/FinishPayment",
        ]);
    }

    public function getPaymentByOrderId(int $orderId): Payment {
        $paymentId = $this->executeQuery("select paymentId from orderpayment where orderId = ?", [$orderId])[0]->paymentId ?? null;

        $mollieClient = $this->getMollieApiClient();
        return $mollieClient->payments->get($paymentId);
    }

    public function createOrderPayment(int $orderId, PaymentMethod $paymentMethod, ?string $paymentId): void {
        $this->executeQuery("insert into orderpayment (orderId, method, paymentId) values (?,?,?)", [$orderId, $paymentMethod->value, $paymentId]);
    }

    private function getMollieApiCredentials(): ?PaymentProvider {
        return $this->executeQuery("select * from paymentprovider where lower(name) = ? limit 1", ["mollie_test"], PaymentProvider::class)[0] ?? null;
    }

    private function getMollieApiClient() : MollieApiClient {
        $mollieClient = new MollieApiClient();

        $apiCredentials = $this->getMollieApiCredentials();
        $mollieClient->setApiKey($apiCredentials->apiSecret);

        return $mollieClient;
    }
}