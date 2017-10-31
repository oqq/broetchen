<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Domain\Order;

use Oqq\Broetchen\Domain\Service\ServiceId;
use Oqq\Broetchen\Domain\User\UserId;

interface OrderRepository
{
    public function insert(Order $order): void;

    public function findOrderWithId(OrderId $orderId): ?Order;

    public function findOrdersForUserWithId(UserId $userId): ?OrderCollection;

    public function findOrdersForServiceWithId(ServiceId $serviceId): ?OrderCollection;
}
