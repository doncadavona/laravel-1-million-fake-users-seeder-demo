<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OneMillionUsersSeeder extends Seeder
{
    protected static $users_count = 1000;

    protected static $chunk_size = 1000;

    /**
     * Create a million users quickly (~5 minutes)
     * in non-production environments such as
     * local and staging environments.
     */
    public function run(): void
    {
        return;

        if (app()->environment() == 'production') {
            return;
        }

        for ($i = 0; $i < self::$users_count / self::$chunk_size; $i++) {
            DB::beginTransaction();
            try {
                User::factory()
                    ->count(self::$chunk_size)
                    ->create();
            
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }
        }
    }
}
