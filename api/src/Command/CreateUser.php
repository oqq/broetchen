<?php

declare(strict_types=1);

namespace Oqq\Broetchen\Command;

use Assert\Assertion;
use Oqq\Broetchen\Domain\City;
use Oqq\Broetchen\Domain\Postcode;
use Oqq\Broetchen\Domain\Username;
use Oqq\Broetchen\Domain\EmailAddress;
use Oqq\Broetchen\Domain\User\UserId;

final class CreateUser
{
    private $city;
    private $emailAddress;
    private $postCode;
    private $username;
    private $userId;

    public static function fromArray(array $values): self
    {
        Assertion::choicesNotEmpty($values, ['email_address', 'username', 'post_code', 'city']);

        $city = City::fromString($values['city']);
        $emailAddress = EmailAddress::fromString($values['email_address']);
        $postCode = Postcode::fromString($values['post_code']);
        $username = Username::fromString($values['username']);
        $userId = UserId::generate();

        return new self($userId, $emailAddress, $username, $postCode, $city);
    }

    public function emailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    public function city(): City
    {
        return $this->city;
    }

    public function postCode(): postCode
    {
        return $this->postCode;
    }

    public function username(): Username
    {
        return $this->username;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function getArrayCopy(): array
    {
        return [
            'city' => $this->city->toString(),
            'email_address' => $this->emailAddress->toString(),
            'post_code' => $this->postCode->toString(),
            'username' => $this->username->toString(),
            'user_id' => $this->userId->toString(),
        ];
    }

    private function __construct(UserId $userId, EmailAddress $emailAddress, Username $username, Postcode $postcode, City $city)
    {
        $this->emailAddress = $emailAddress;
        $this->city = $city;
        $this->username = $username;
        $this->postCode = $postcode;
        $this->userId = $userId;
    }
}
