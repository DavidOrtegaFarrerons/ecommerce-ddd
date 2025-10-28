<?php

namespace App\Order\Domain\Model;

use App\Shared\Domain\Model\Money;

class Order
{
    private OrderId $orderId;
    private OrderNumber $orderNumber;
    private array $orderItems;
    private Money $totalPrice;
    private string $shippingAddress;
    private Status $status;
}
