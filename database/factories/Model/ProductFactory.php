<?php

namespace Database\Factories\Model;

use App\Models\Model\Product;
use App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'name' => $this->faker->word,
            'detail' => $this->faker->word,
            'price' =>  $this->faker->numberBetween(100, 300),
            'stock' =>  $this->faker->randomDigit,
            'discount' => $this->faker->numberBetween(2, 30),
            'shop_id'=> function () {
                return Shop::all()->random();
            },
        ];
    }
}
