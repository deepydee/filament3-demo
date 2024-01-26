<?php

namespace Modules\Order\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Catalog\Models\Product;
use Modules\Order\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::all()->pluck('id');
        $productIds = Product::all()->pluck('id');


        for ($i = 0; $i < 50; $i++) {
            Order::factory()
                ->for(User::find($userIds->random()))
                ->for(Product::find($productIds->random()))
                ->create();
        }
    }
}
