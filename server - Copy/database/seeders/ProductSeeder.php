<?php

namespace Database\Seeders;

use App\Jobs\SeedingProductJob;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batchSize = 20; //a bunch per batch
        $totalRecords = 50; //total records
        $batches = (int) floor($totalRecords / $batchSize);
        for ($i = 0; $i < $batches; $i++) {
            SeedingProductJob::dispatch($i, $batchSize)->onQueue('seeding_product');
        }

        // alter
        // 10 thous records ==> sequentially
        // Product::factory()->count(10000)->create();
    }
}
