<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Service;

use Oqq\Broetchen\Command\CreateOrder;
use Oqq\Broetchen\Domain\Order\Exception\OrderNotFoundException;
use Oqq\Broetchen\Domain\Order\Exception\OrdersNotFoundException;
use Oqq\Broetchen\Domain\Order\Order;
use Oqq\Broetchen\Domain\Order\OrderCollection;
use Oqq\Broetchen\Domain\Order\OrderId;
use Oqq\Broetchen\Domain\Order\OrderRepository;
use Oqq\Broetchen\Domain\Order\OrderService;
use Oqq\Broetchen\Domain\Service\ServiceId;
use Oqq\Broetchen\Domain\User\UserId;

final class RepositoryOrderService implements OrderService
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function addOrder(CreateOrder $command)
    {
        $order = $command->order();

        $this->orderRepository->insert($order);
    }

    public function getOrderWithId(OrderId $orderId): Order
    {
        $order = $this->orderRepository->findOrderWithId($orderId);

        if (null === $order) {
            throw OrderNotFoundException::withOrderId($orderId);
        }

        return $order;
    }

    public function getOrdersFromUser(UserId $userId): OrderCollection
    {
        $orders = $this->orderRepository->findOrdersForUserWithId($userId);

        if (null === $orders) {
            throw OrdersNotFoundException::withUserId($userId);
        }

        return $orders;
    }

    public function getOrdersForService(ServiceId $serviceId): OrderCollection
    {
        $orders = $this->orderRepository->findOrdersForServiceWithId($serviceId);

        if (null === $orders) {
            throw OrdersNotFoundException::withServiceId($serviceId);
        }

        return $orders;
    }
}
