<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\OrderServiceInterface;

class OrderPaymentController extends Controller
{
    public function __construct(public OrderServiceInterface $orderService)
    {

    }

    public function handleNotification(Request $request)
    {
        try {
            $notificationBody = json_decode($request->getContent(), true);
            
            $paymentStatus = $notificationBody['transaction_status'];
            $orderId = $notificationBody['order_id'];

            $this->orderService->updateOrder($orderId, ['status' => $paymentStatus]);

            // send email via queue

            return response()->json([
                'message' => 'Order payment status successfully updated',
                'status' => $paymentStatus
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([], 500);
        }
    }
}
