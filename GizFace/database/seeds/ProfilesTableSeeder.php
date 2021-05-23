<?php

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データクリア
        \DB::table('profiles')->truncate();

        $profile = factory(Profile::class, 30)->create();
    }
}
