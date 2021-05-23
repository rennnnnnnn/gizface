<?php

use Illuminate\Database\Seeder;

class SkillMastersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データクリア
        \DB::table('skill_masters')->truncate();
        // データ挿入
        \DB::table('skill_masters')->insert([
            [
                'category_id' => 1,
                'skill' => 'PHP'
            ],
            [
                'category_id' => 1,
                'skill' => 'Python'
            ],
            [
                'category_id' => 2,
                'skill' => 'laravel'
            ],
            [
                'category_id' => 2,
                'skill' => 'Django'
            ],
            [
                'category_id' => 3,
                'skill' => 'mysql'
            ],
            [
                'category_id' => 4,
                'skill' => 'mac'
            ],
            [
                'category_id' => 5,
                'skill' => 'コーダー'
            ],
            [
                'category_id' => 5,
                'skill' => 'PL'
            ],
            [
                'category_id' => 6,
                'skill' => 'GitLab'
            ],
            [
                'category_id' => 6,
                'skill' => 'Docker'
            ],
            [
                'category_id' => 6,
                'skill' => 'jQuery3.3.1'
            ],

        ]);
    }
}
