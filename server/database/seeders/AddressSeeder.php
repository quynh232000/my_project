<?php

namespace Database\Seeders;

use DB;
use Exception;
use File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        try {

            $sql = File::get(database_path('sql\addressdb.sql'));
            DB::unprepared($sql);

            $this->command->info('SQL file executed successfully.');
        } catch (Exception $e) {
            $this->command->error('Error executing SQL file: ' . $e->getMessage());
        }
    }
}
