<?php

namespace App\Factories\Services;

interface IExternProductFactory
{
    public function getProducts($url): string;
}
