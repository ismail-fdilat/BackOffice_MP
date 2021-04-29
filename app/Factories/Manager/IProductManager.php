<?php
namespace App\Factories\Manager;

use App\Factories\Services\IExternProductFactory;

interface IProductManager
{
    public function make($name): IExternProductFactory;
}
