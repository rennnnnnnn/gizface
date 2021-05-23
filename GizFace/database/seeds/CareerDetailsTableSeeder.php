<?php

use Illuminate\Database\Seeder;
use App\Models\CareerDetail;

class CareerDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データクリア
        \DB::table('career_details')->truncate();

        $careerDetail = factory(CareerDetail::class, 90)->create();
    }
}
