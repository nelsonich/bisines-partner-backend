<?php

namespace Database\Seeders\DatabaseSeeders;

use Database\Seeders\DatabaseSeeders\Development\ProductSeeder;
use Database\Seeders\DatabaseSeeders\Development\ReviewSeeder;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
  public function run()
  {
    $this->call(ProductSeeder::class);
    $this->call(ReviewSeeder::class);
  }
}
