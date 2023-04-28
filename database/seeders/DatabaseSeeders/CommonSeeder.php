<?php

namespace Database\Seeders\DatabaseSeeders;

use Database\Seeders\DatabaseSeeders\Common\UsersTableSeeder;
use Database\Seeders\DatabaseSeeders\Common\CategorySeeder;
use Database\Seeders\DatabaseSeeders\Common\LanguageSeeder;
use Database\Seeders\DatabaseSeeders\Common\ProductFieldTableSeeder;
use Database\Seeders\DatabaseSeeders\Common\ShippingCitiesTableSeeder;
use Illuminate\Database\Seeder;

class CommonSeeder extends Seeder
{
  public function run()
  {
    $this->call(UsersTableSeeder::class);
    $this->call(LanguageSeeder::class);
    $this->call(CategorySeeder::class);
    $this->call(ShippingCitiesTableSeeder::class);
    $this->call(ProductFieldTableSeeder::class);
  }
}
