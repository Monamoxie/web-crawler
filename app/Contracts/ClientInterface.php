<?php

namespace App\Contracts;
interface ClientInterface
{
    public function get(string $endpoint);
}