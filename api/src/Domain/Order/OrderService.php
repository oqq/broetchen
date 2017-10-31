<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Domain\Order;

use Oqq\Broetchen\Command\CreateOrder;
use Oqq\Broetchen\Domain\Order\Order;
use Oqq\Broetchen\Domain\Order\OrderCollection;
use Oqq\Broetchen\Domain\Order\OrderId;
use Oqq\Broetchen\Domain\Service\ServiceId;
use Oqq\Broetchen\Domain\User\UserId;

interface OrderService
{
    public function getOrderWithId(OrderId $orderId): Order;

    public function addOrder(CreateOrder $order);

    public function getOrdersFromUser(UserId $userId): OrderCollection;

    public function getOrdersForService(ServiceId $serviceId): OrderCollection;
}
