<?php

namespace App\Services;

use App\Interfaces\{
    OrderServiceInterface,
    CartItemRepositoryInterface,
    OrderRepositoryInterface,
    ShippingInformationRepositoryInterface
};
use App\Enums\OrderStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrderService implements OrderServiceInterface
{
    public function __construct(
        public CartItemRepositoryInterface $cartItemRepository,
        public OrderRepositoryInterface $orderRepository,
        public ShippingInformationRepositoryInterface $shippingInformationRepository
    )
    {
        
    }

    public function createOrder(string $cartId, array $orderDetails)
    {
        DB::beginTransaction();

        try {
            $cartItems = $this->cartItemRepository->getAllByCartId($cartId);

            $shippingCost = $this->shippingInformationRepository
                                ->getByShippingableId($cartId)
                                ->shipping_cost;

            $order = $this->orderRepository->save([
                'user_id' => optional(auth()->user())->id ?? null,
                'payment_method' => $orderDetails['payment_method'],
                'status' => OrderStatusEnum::PENDING
            ]);

            $totalPrice = $this->calculateTotalPrice($shippingCost, $cartItems);

            $isCartItemMoveSuccess = $this->cartItemRepository->moveToOrderItemsTable($cartItems, $order);

            if (! $isCartItemMoveSuccess) {
                throw new \Exception('Failed to move cart item to order_items table');
            }

            $isOrderUpdateSuccess = $this->orderRepository->update($order->id, ['total_price' => (float) $totalPrice]);
            
            if (! $isOrderUpdateSuccess) {
                throw new \Exception('Update order failed');
            }

            DB::commit();

            return $order->fresh();

        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function updateOrder(string $orderId, array $orderDetails)
    {
        DB::beginTransaction();
        try {
            $this->orderRepository->update($orderId, $orderDetails);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function getOrder(string $orderId)
    {
        return $this->orderRepository->getById($orderId);
    }

    private function calculateTotalPrice($shippingCost, $cartItems)
    {
        $totalPrice = $shippingCost;

        $cartItems->each(function ($cartItem) use (&$totalPrice) {
            $totalPrice = $totalPrice + ($cartItem->productVariant->price * $cartItem->quantity);
        });

        return $totalPrice;
    }
}
