<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Domain\Order;

use Assert\Assertion;

final class OrderCollection
{
    private $orders;

    public static function fromArray(array $values): self
    {
        Assertion::notEmpty($values);

        $orders = [];

        foreach ($values as $product) {
            $orders[] = Order::fromArray($product);
        }

        return new self(...$orders);
    }

    public function getArrayCopy(): array
    {
        $orders = [];

        foreach ($this->orders as $product) {
            $orders[] = $product->getArrayCopy();
        }

        return $orders;
    }

    private function __construct(Order ...$orders)
    {
        $this->orders = $orders;
    }
}
