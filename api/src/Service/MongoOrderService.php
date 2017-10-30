<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Service;

use MongoDB\Collection;
use Oqq\Broetchen\Command\CreateOrder;
use Oqq\Broetchen\Domain\Order\Order;
use Oqq\Broetchen\Domain\Order\OrderCollection;
use Oqq\Broetchen\Domain\Order\OrderId;
use Oqq\Broetchen\Domain\Service\ServiceId;
use Oqq\Broetchen\Domain\User\UserId;
use Oqq\Broetchen\Exception\OrderNotFoundByIdException;

final class MongoOrderService implements OrderServiceInterface
{
    private $collection;

    public function __construct(Collection $orderCollection)
    {
        $this->collection = $orderCollection;
    }

    public function getOrderWithId(OrderId $orderId): Order
    {
        $order = $this->collection->findOne(['order_id' => $orderId->toString()]);

        if (null === $order) {
            throw new OrderNotFoundByIdException($orderId);
        }

        return Order::fromArray(iterator_to_array($order));
    }

    public function addOrder(CreateOrder $command)
    {
        $order = $command->order();

        $this->collection->insertOne(array_merge(
            [
                '_id' => $order->orderId()->toString(),
            ], $order->getArrayCopy()
        ));
    }

    public function getOrdersFromUser(UserId $userId): OrderCollection
    {
        $orders = $this->collection->find(['user_id' => $userId->toString()]);

        return OrderCollection::fromArray($orders->toArray());
    }

    public function getOrdersForService(ServiceId $serviceId): OrderCollection
    {
        $orders = $this->collection->find(['service_id' => $serviceId->toString()]);

        return OrderCollection::fromArray(iterator_to_array($orders->toArray()));
    }
}
