<?php

use Illuminate\Database\Seeder;

class JobProcessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // データクリア
        \DB::table('job_processes')->truncate();

        $dataCount = 30;
        $dummyData = [];
        $process = config('consts.jobProcess');

        // $dataCount件数分ダミーデータ作成
        for ($i = 1; $i <= $dataCount; $i++) {
            $dummyData[] = [
                'career_id' => $i,
                'process' => $process[array_rand($process)]
            ];
        }
        // データ挿入
        \DB::table('job_processes')->insert($dummyData);
    }
}
