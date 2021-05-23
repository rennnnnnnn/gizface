<?php

use Illuminate\Database\Seeder;
use App\Models\SocialProvider;

class SocialProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データクリア
        \DB::table('social_providers')->truncate();

        $socialProvider = factory(SocialProvider::class, 30)->create();
    }
}
