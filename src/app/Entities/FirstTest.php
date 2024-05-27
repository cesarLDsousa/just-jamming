<?php

namespace App\Entities;

class FirstTest
{
    private string $str_test;

    public function __construct(string $str_test)
    {
        $this->str_test = $str_test;
    }

    public function __toString(): string
    {
        return $this->str_test;
    }
}