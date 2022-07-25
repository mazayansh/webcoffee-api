<?php

namespace App\Interfaces;

interface PaymentServiceInterface
{
    public function createPayment(array $paymentDetails);
}
