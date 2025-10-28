<?php

namespace App\Order\Domain\Model;

enum Status: string
{
    case PENDING_PAYMENT = 'pending_payment';
    case PAID = 'paid';
    case PAYMENT_FAILED = 'payment_failed';
    case CANCELLED = 'cancelled';
    case SHIPPED = 'shipped';
    case COMPLETED = 'completed';
}
