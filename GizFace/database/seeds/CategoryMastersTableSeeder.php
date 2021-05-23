<?php

use Illuminate\Database\Seeder;

class CategoryMastersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // データクリア
        \DB::table('category_masters')->truncate();
        // データ挿入
        \DB::table('category_masters')->insert([
            [
                'category' => '言語',
            ],
            [
                'category' => 'FW',
            ],
            [
                'category' => 'DB',
            ],
            [
                'category' => 'サーバOS',
            ],
            [
                'category' => '役割',
            ],
            [
                'category' => 'ツール',
            ],
        ]);
    }
}
