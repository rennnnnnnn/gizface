<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewCareerJobProcessesTable extends Migration
{
    /**
     * Run the migrations.
     * careers.TBLとjop_processes.TBLを結合したTBL(参照用)
     * @return void
     */
    public function up()
    {
        Schema::table('careers', function (Blueprint $table) {
            $sql = '
            create view career_job_processes
            as
            select
            careers.*,
            (
                select
                process
                from
                job_processes
                where
                careers.id = job_processes .career_id
                and
                job_processes .process = \'要件定義\'
            ) as process_rq_definition
            ,(
                select
                process
                from
                job_processes
                where
                careers.id = job_processes.career_id
                and
                job_processes.process = \'基本設計\'
            ) as process_basic_design
            ,(
                select
                process
                from
                job_processes
                where
                careers.id = job_processes.career_id
                and
                job_processes.process = \'詳細設計\'
            ) as process_detail_design
            ,(
                select
                process
                from
                job_processes
                where
                careers.id = job_processes.career_id
                and
                job_processes.process = \'実装・単体\'
            ) as process_installation
            ,(
                select
                process
                from
                job_processes
                where
                careers.id = job_processes.career_id
                and
                job_processes.process = \'結合テスト\'
            ) as process_interface_test
            ,(
                select
                process
                from
                job_processes
                where
                careers.id = job_processes.career_id
                and
                job_processes.process = \'総合テスト\'
            ) as process_integration_test
            ,(
                select
                process
                from
                job_processes
                where
                careers.id = job_processes.career_id
                and
                job_processes.process = \'保守・運用\'
            ) as process_op_maintenance
            from
            careers
            where careers.deleted_at is null
            ';
            \DB::connection()->getPdo()->exec($sql);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            $sql = 'drop view if exists career_job_processes';
            \DB::connection()->getPdo()->exec($sql);
        });
    }
}
