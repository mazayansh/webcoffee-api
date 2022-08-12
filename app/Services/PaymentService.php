<?php

namespace App\Services;

use App\Interfaces\PaymentServiceInterface;
use App\Interfaces\PaymentRepositoryInterface;
use Midtrans\{
    Config as MidtransConfig,
    CoreApi as MidtransApi,
    Transaction as MidtransTransaction
};
use Illuminate\Support\Facades\Mail;
use App\Mail\WaitingForPaymentMail;
use Carbon\Carbon;

class PaymentService implements PaymentServiceInterface
{
    public function __construct(public PaymentRepositoryInterface $paymentRepository)
    {

    }

    public function createPayment(array $paymentDetails)
    {
        return $this->paymentRepository->save($paymentDetails);
    }

    public function getPayment(string $orderId)
    {
        return $this->paymentRepository->getByOrderId($orderId);
    }

    public function chargeBankTransfer($order)
    {
        MidtransConfig::$serverKey = config('constants.midtrans.server_key');
        MidtransConfig::$isProduction = config('app.env') == "production" ? true : false;

        $transactionDetails = [
            "order_id" => $order->id,
            "gross_amount" => (float) $order->total_price
        ];

        $customerDetails = [
            'first_name' => $order->shipping->first_name,
            'last_name' => $order->shipping->last_name,
            'email' => $order->shipping->email,
            'phone' => $order->shipping->phone
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
                    'bank' => $order->payment_method,
                    'gross_amount' => $chargeResponse->gross_amount,
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
                    'bank' => $order->payment_method,
                    'gross_amount' => $chargeResponse->gross_amount,
                    'message' => $chargeResponse->status_message,
                    'bill_key' => $chargeResponse->bill_key,
                    'biller_code' => $chargeResponse->biller_code,
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
                    'bank' => $order->payment_method,
                    'gross_amount' => $chargeResponse->gross_amount,
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

    public function sendWaitingForPaymentMail($shippingInfo, $paymentDetails) 
    {
        $paymentMethod = '';

        switch ($paymentDetails['bank']) {
            case 'bri':
                $paymentMethod = 'BRI Virtual Account';
                break;
            case 'bni':
                $paymentMethod = 'BNI Virtual Account';
                break;
            case 'bca':
                $paymentMethod = 'BCA Virtual Account';
                break;
            case 'mandiri':
                $paymentMethod = 'Mandiri Bill Payment';
                break;
            case 'permata':
                $paymentMethod = 'Permata Virtual Account';
                break;
        }

        $transactionTime = Carbon::createFromFormat('Y-m-d H:i:s', $paymentDetails['transaction_time'], 'Asia/Jakarta');
        $paymentExpiredAt = $transactionTime->addDay()->isoFormat('dddd, D MMMM Y HH:mm:ss');

        $mailInfo = [
            'payment_expired_at' => $paymentExpiredAt,
            'gross_amount' => number_format(intval($paymentDetails['gross_amount']), 0, ",", "."),
            'payment_method' => $paymentMethod,
            'va_number' => $paymentDetails['va_number'] ?? $paymentDetails['bill_key'].' - Biller code: '.$paymentDetails['biller_code'],
            'customer_name' => $shippingInfo->first_name." ".$shippingInfo->last_name,
            'address' => $shippingInfo->address,
            'city' => $shippingInfo->city,
            'state' => $shippingInfo->state,
            'postcode' => $shippingInfo->postcode,
            'phone' => $shippingInfo->phone
        ];

        Mail::to($shippingInfo->email)->send(new WaitingForPaymentMail($mailInfo));
    }
}
