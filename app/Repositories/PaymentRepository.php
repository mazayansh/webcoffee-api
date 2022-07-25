<?php

namespace App\Repositories;

use App\Interfaces\PaymentRepositoryInterface;
use App\Models\Payment;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function save(array $paymentDetails)
    {
        return Payment::create($paymentDetails);
    }
}
