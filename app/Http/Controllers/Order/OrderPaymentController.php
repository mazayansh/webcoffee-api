<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\{
    OrderServiceInterface,
    ShippingInformationServiceInterface,
    PaymentServiceInterface
};
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReceivedMail;
use App\Http\Resources\OrderPaymentResource;

class OrderPaymentController extends Controller
{
    public function __construct(
            public OrderServiceInterface $orderService, 
            public ShippingInformationServiceInterface $shippingInformationService,
            public PaymentServiceInterface $paymentService)
    {

    }

    public function show($orderId)
    {
        $payment = $this->paymentService->getPayment($orderId);

        return new OrderPaymentResource($payment);
    }

    public function handleNotification(Request $request)
    {
        try {
            $notificationBody = json_decode($request->getContent(), true);
            
            $paymentStatus = $notificationBody['transaction_status'];
            $orderId = $notificationBody['order_id'];

            $this->orderService->updateOrder($orderId, ['status' => $paymentStatus]);

            $isPaymentSuccess = ($paymentStatus == 'settlement') || ($paymentStatus == 'capture');

            if ($isPaymentSuccess) {
                $shippingInfo = $this->shippingInformationService->getShippingInfo($orderId);

                $mailInfo = [
                    'settlement_time' => $notificationBody['settlement_time'],
                    'gross_amount' => number_format(intval($notificationBody['gross_amount']), 0, ",", "."),
                    'customer_name' => $shippingInfo->first_name." ".$shippingInfo->last_name
                ];

                Mail::to($shippingInfo->email)->send(new PaymentReceivedMail($mailInfo));
            }

            return response()->json([
                'message' => 'Order payment status successfully updated',
                'status' => $paymentStatus
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([], 500);
        }
    }
}
