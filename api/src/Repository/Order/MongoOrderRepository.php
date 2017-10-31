<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Repository\Order;

use MongoDB\Collection;
use Oqq\Broetchen\Domain\Order\Exception\OrderNotFoundException;
use Oqq\Broetchen\Domain\Order\Order;
use Oqq\Broetchen\Domain\Order\OrderCollection;
use Oqq\Broetchen\Domain\Order\OrderId;
use Oqq\Broetchen\Domain\Order\OrderRepository;
use Oqq\Broetchen\Domain\Service\ServiceId;
use Oqq\Broetchen\Domain\User\UserId;

final class MongoOrderRepository implements OrderRepository
{
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function insert(Order $order): void
    {
        $values = $order->getArrayCopy();
        $values['_id'] = $order->orderId()->toString();

        $this->collection->insertOne($values);
    }

    /**
     * @throws OrderNotFoundException
     */
    public function findOrderWithId(OrderId $orderId): Order
    {
        $values = $this->collection->findOne(['_id' => $orderId->toString()]);

        return Order::fromArray($values);
    }

    public function findOrdersForUserWithId(UserId $userId): OrderCollection
    {
        $values = $this->collection->find(['user_id' => $userId->toString()]);

        return OrderCollection::fromArray($values->toArray());
    }

    public function findOrdersForServiceWithId(ServiceId $serviceId): OrderCollection
    {
        $values = $this->collection->find(['service_id' => $serviceId->toString()]);

        return OrderCollection::fromArray($values->toArray());
    }
}
