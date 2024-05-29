<?php

declare(strict_types=1);

namespace App\VOs;

final class EmailAddress
{
    private const AT_SYMBOL = "@";
    public string $email;
    public string $username;
    public string $domain;

    public function __construct(string $value)
    {
        $this->setEmail($value);
    }

    public function __set(string $property, $value): void
    {
        if ($property === 'email') {
            $this->setEmail($value);
        }
    }

    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new \InvalidArgumentException("Property {$property} does not exist.");
    }

    private function validate(string $value): bool
    {
        if (!$value || strlen($value) < 9) {
            return false;
        }

        [$username, $domain] = explode(self::AT_SYMBOL, $value);

        if (strlen($username) < 4 || strlen($domain) < 6) {
            return false;
        }

        return true;
    }

    private function setEmail(string $value): void
    {
        if ($this->validate($value)) {
            $this->email = $value;

            $this->setUsername($value)
                ->setDomain($value);
        } else {
            throw new \InvalidArgumentException("Invalid email address.");
        }
    }

    private function setUsername(string $value): EmailAddress
    {
        $this->username = explode(self::AT_SYMBOL, $value)[0];

        return $this;
    }

    private function setDomain(string $value): EmailAddress
    {
        $this->domain = explode(self::AT_SYMBOL, $value)[1];

        return $this;
    }
}