<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Domain\Product;

use Assert\Assertion;

final class ProductName
{
    private $value;

    public static function fromString(string $value): self
    {
        Assertion::notEmpty($value);

        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    private function __construct(string $value)
    {
        $this->value = $value;
    }
}
