<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Domain\Order;

use ArrayIterator;
use Assert\Assertion;
use Iterator;
use IteratorAggregate;
use Traversable;

final class OrderCollection implements IteratorAggregate
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

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->orders);
    }

    private function __construct(Order ...$orders)
    {
        $this->orders = $orders;
    }
}
