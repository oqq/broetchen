<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Domain\Order\Exception;

use Oqq\Broetchen\Domain\Service\ServiceId;
use Oqq\Broetchen\Domain\User\UserId;
use Oqq\Broetchen\Exception\DomainException;
use Oqq\Broetchen\Exception\RuntimeException;

class OrdersNotFoundException extends RuntimeException implements DomainException
{
    public static function withUserId(UserId $userId): self
    {
        return new self(sprintf('No orders for user with id "%s" were found', $userId->toString()));
    }

    public static function withServiceId(ServiceId $serviceId): self
    {
        return new self(sprintf('No orders for service with id "%s" were found', $serviceId->toString()));
    }
}
