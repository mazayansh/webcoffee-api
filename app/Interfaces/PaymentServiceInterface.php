<?php

namespace App\Interfaces;

interface PaymentServiceInterface
{
    public function createPayment(array $paymentDetails);

    public function getPayment(string $orderId);

    public function chargeBankTransfer($order);

    public function sendWaitingForPaymentMail($shippingInfo, $paymentDetails);
}
