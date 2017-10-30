<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Domain\Order;

use Assert\Assertion;
use Oqq\Broetchen\Domain\Product\ProductCollection;
use Oqq\Broetchen\Domain\Service\ServiceId;
use Oqq\Broetchen\Domain\User\UserId;

final class Order
{
    private $orderId;
    private $userId;
    private $serviceId;
    private $products;

    public static function fromArray(array $values): self
    {
        Assertion::choicesNotEmpty($values, ['order_id', 'user_id', 'service_id', 'products']);

        $userId = UserId::fromString($values['user_id']);
        $serviceId = ServiceId::fromString($values['service_id']);
        $orderId = OrderId::fromString($values['order_id']);
        $products = ProductCollection::fromArray($values['products']);

        return new self($orderId, $userId, $serviceId, $products);
    }

    public function orderId(): OrderId
    {
        return $this->orderId;
    }

    public function getArrayCopy(): array
    {
        return [
            'order_id' => $this->orderId->toString(),
            'user_id' => $this->userId->toString(),
            'service_id' => $this->serviceId->toString(),
            'products' => $this->products->getArrayCopy(),
        ];
    }

    private function __construct(
        OrderId $orderId,
        UserId $userId,
        ServiceId $serviceId,
        ProductCollection $products
    ) {
        $this->orderId = $orderId;
        $this->userId = $userId;
        $this->serviceId = $serviceId;
        $this->products = $products;
    }
}
