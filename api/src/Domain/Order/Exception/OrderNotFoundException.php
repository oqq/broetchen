<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Domain\Order\Exception;

use Oqq\Broetchen\Domain\Order\OrderId;
use Oqq\Broetchen\Exception\DomainException;
use Oqq\Broetchen\Exception\RuntimeException;

class OrderNotFoundException extends RuntimeException implements DomainException
{
    public static function withOrderId(OrderId $orderId): self
    {
        return new self(sprintf('The order with id "%s" was not found!', $orderId->toString()));
    }
}
