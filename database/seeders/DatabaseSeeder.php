<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\Invoice\Infrastructure\Database\Seeders\DatabaseSeeder as InvoiceDatabaseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            InvoiceDatabaseSeeder::class,
        ]);
    }
}
