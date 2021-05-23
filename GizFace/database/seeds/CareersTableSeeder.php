<?php

use App\Models\Career;
use Illuminate\Database\Seeder;

class CareersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データクリア
        \DB::table('careers')->truncate();

        $career = factory(Career::class, 30)->create();
    }
}
