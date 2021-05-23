<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class SkillMaster extends Model
{
    protected $guarded = ['id'];

    public function getSkillList()
    {
        $categoryConf = config('consts.categoryMaster');

        $notInList = [
            $categoryConf['DB'],
            $categoryConf['OS'],
            $categoryConf['TOOL'],
        ];

        return self::select(
            'id',
            'skill',
            'category_id'
        )
            ->whereNotIn('category_id', $notInList)
            ->orderBy('id')
            ->get();
    }

    /**
     * スキルとカテゴリーIDをキーにレコード存在チェック
     *
     * @param string $skill
     * @param integer $categoryId
     * @return bool
     */
    public function checkExistsRecordBySkill(string $skill, int $categoryId): bool
    {
        $result = \DB::table('skill_masters')
            ->where('skill', $skill)
            ->where('category_id', $categoryId)
            ->exists();
        return $result;
    }

    /**
     * スキルをキーにidを取得
     *
     * @param string $skill
     * @return void
     */
    public function getIdBySkill(string $skill)
    {
        $result = self::select('id')
            ->where('skill', $skill)
            ->first();
        return $result;
    }

    /**
     * インサート
     *
     * @param string $skill
     * @param integer $categoryId
     * @param string $userName
     * @return void
     */
    public function insertRecord(string $skill, int $categoryId, string $userName)
    {
        $self = new SkillMaster();
        $self->category_id = $categoryId;
        $self->skill = $skill;
        $self->created_user = $userName;
        $self->save();
        return $self->id;
    }
}
