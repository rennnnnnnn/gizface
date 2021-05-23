<?php

use App\Models\Career;
use App\Models\SkillMaster;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        App\Models\User::truncate();
        $this->call([
            UsersTableSeeder::class,
            SocialProvidersTableSeeder::class,
            CategoryMastersTableSeeder::class,
            PostsCommentsTableSeeder::class,
            SkillMastersTableSeeder::class,
            ProfilesTableSeeder::class,
            CareersTableSeeder::class,
            CareerDetailsTableSeeder::class,
            JobProcessesTableSeeder::class,
            // PostsTableSeeder::class,
        ]);

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
