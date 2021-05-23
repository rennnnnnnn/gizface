<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class JobProcess extends Model
{
    protected $guarded = ['id'];


    /**
     * インサート
     *
     * @param array $saveList
     * @return void
     */
    public function insertRecord(array $saveList)
    {
        self::insert($saveList);
    }

    /**
     * career_idをキーにレコード取得
     *
     * @param integer $careerId
     * @return array|null
     */
    public function getRecordByCareerId(int $careerId): ?array
    {
        $result = self::select('process')
            ->where('career_id', $careerId)
            ->get();
        if (!empty($result)) {
            return $result->toArray();
        }
        return $result;
    }

    /**
     * レコードを物理削除
     *
     * @param integer $careerId
     * @return void
     */
    public function deleteRecordByCareerId(int $careerId)
    {
        self::where('career_id', $careerId)
            ->delete();
    }
}
