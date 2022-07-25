<?php

namespace App\Services;

use App\Interfaces\PaymentServiceInterface;
use App\Interfaces\PaymentRepositoryInterface;
use Midtrans\{
    Config as MidtransConfig,
    CoreApi as MidtransApi,
    Transaction as MidtransTransaction
};

class PaymentService implements PaymentServiceInterface
{
    public function __construct(public PaymentRepositoryInterface $paymentRepository)
    {

    }

    public function createPayment(array $paymentDetails)
    {
        return $this->paymentRepository->save($paymentDetails);
    }

    public function chargeBankTransfer($order)
    {
        MidtransConfig::$serverKey = env('MIDTRANS_SERVERKEY');
        MidtransConfig::$isProduction = env('production')? true : false;

        $transactionDetails = [
            "order_id" => $order->id,
            "gross_amount" => (float) $order->total_price
        ];

        $customerDetails = [
            'first_name' => $order->shipping->first_name,
            'last_name' => $order->shipping->last_name,
            'email' => $order->shipping->email,
            'phone' => $order->shipping->phone,
            'address' => $order->shipping->address
        ];

        $paymentDetails = [];

        switch ($order->payment_method) {
            case 'bca': case 'bni': case 'bri':
                $chargeRequest = [
                    'payment_type' => 'bank_transfer',
                    'transaction_details' => $transactionDetails,
                    'bank_transfer' => [
                        'bank' => $order->payment_method
                    ],
                    'customer_details' => $customerDetails
                ];

                $chargeResponse = MidtransApi::charge($chargeRequest);

                $paymentDetails = [
                    'transaction_id' => $chargeResponse->transaction_id,
                    'transaction_time' => $chargeResponse->transaction_time,
                    'payment_type' => $chargeResponse->payment_type,
                    'message' => $chargeResponse->status_message,
                    'va_number' => $chargeResponse->va_numbers[0]->va_number,
                    'fraud_status' => $chargeResponse->fraud_status
                ];

                break;
            case 'mandiri':
                $chargeRequest = [
                    'payment_type' => 'echannel',
                    'transaction_details' => $transactionDetails,
                    'echannel' => [
                        'bill_info1' => 'Payment:',
                        'bill_info2' => 'Online purchase'
                    ],
                    'customer_details' => $customerDetails
                ];

                $chargeResponse = MidtransApi::charge($chargeRequest);

                $paymentDetails = [
                    'transaction_id' => $chargeResponse->transaction_id,
                    'transaction_time' => $chargeResponse->transaction_time,
                    'payment_type' => $chargeResponse->payment_type,
                    'message' => $chargeResponse->status_message,
                    'bill_key' => $chargeResponse->bill_key,
                    'biller_key' => $chargeResponse->biller_code,
                    'fraud_status' => $chargeResponse->fraud_status
                ];

                break;
            case 'permata':
                $chargeRequest = [
                    'payment_type' => 'permata',
                    'transaction_details' => $transactionDetails,
                    'customer_details' => $customerDetails
                ];

                $chargeResponse = MidtransApi::charge($chargeRequest);

                $paymentDetails = [
                    'transaction_id' => $chargeResponse->transaction_id,
                    'transaction_time' => $chargeResponse->transaction_time,
                    'payment_type' => $chargeResponse->payment_type,
                    'message' => $chargeResponse->status_message,
                    'va_number' => $chargeResponse->permata_va_number,
                    'fraud_status' => $chargeResponse->fraud_status
                ];

                break;
            default:
                throw new \Exception('Please select bank: bca, bni, bri, mandiri, permata', 402);
                break;
        }

        return array_merge($paymentDetails, ['order_id' => $order->id]);
    }
}
