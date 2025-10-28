<?php

namespace App\Cart\Domain\Model\Cart;

use App\Identity\Domain\Model\UserId;

interface CartRepository
{
    public function nextIdentity() : CartId;
    public function add(Cart $cart);
    public function remove(Cart $cart);

    public function ofUserId(UserId $userId) : ?Cart;
}
