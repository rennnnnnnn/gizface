<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    protected $guarded = ['id'];
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = [
        'from',
        'to',
    ];
    // 論理削除
    use SoftDeletes;

    /**
     * レコード存在チェック
     *
     * @param integer $profileId
     * @return void
     */
    public function checkExistsRecord(int $profileId): bool
    {
        $result = \DB::table('careers')
            ->where('profile_id', $profileId)
            ->whereNull('deleted_at')
            ->exists();
        return $result;
    }
    /**
     * ユーザーの最新のsortNoを取得
     *
     * @param integer $profileId
     * @return void
     */
    public function checkLatestSortByProfileId(int $profileId)
    {
        $result = self::select(
            'sort'
        )
            ->where('profile_id', $profileId)
            ->orderBy('sort', 'DESC')
            ->take(1)
            ->first();
        return $result;
    }

    /**
     * レコード保存
     *
     * @param Request $request
     * @param integer $sort
     * @return int
     */
    public function insertRecord(Request $request, int $sort): int
    {
        $from = new Carbon($request->from);
        $from = $from->format('Y-m-d');

        if (is_null($request->to)) {
            $to = null;
        } else {
            $to = new Carbon($request->to);
            $to = $to->format('Y-m-d');
        }

        $self = new Career();
        $self->profile_id = $request->profileId;
        $self->from = $from;
        $self->to = $to;
        $self->company = $request->company;
        $self->job_title = $request->jobTitle;
        $self->job_detail = $request->jobDetail;
        $self->team_scale = $request->scale;
        $self->sort = $sort;
        $self->save();
        return $self->id;
    }

    /**
     * レコード更新
     *
     * @param Request $request
     * @return void
     */
    public function updateRecord(Request $request, string $now)
    {
        $from = new Carbon($request->from);
        $from = $from->format('Y-m-d');

        if (is_null($request->to)) {
            $to = null;
        } else {
            $to = new Carbon($request->to);
            $to = $to->format('Y-m-d');
        }

        \DB::table('careers')
            ->where('id', $request->careerId)
            ->whereNull('deleted_at')
            ->update([
                'company' => $request->company,
                'job_title' => $request->jobTitle,
                'from' => $from,
                'to' => $to,
                'job_detail' => $request->jobDetail,
                'team_scale' => $request->scale,
                'updated_at' => $now
            ]);
    }

    /**
     * profile_idとidをキーにレコード存在チェック
     *
     * @param integer $id
     * @return boolean
     */
    public function checkExistsRecordByProfileIdAndId(int $id): bool
    {
        $result = \DB::table('careers')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->exists();
        return $result;
    }

    /**
     * idをキーにレコードを一件取得
     *
     * @param integer $id
     * @return void
     */
    public function getRecordById(int $id)
    {
        $result = self::select('*')
            ->where('id', $id)
            ->first();
        return $result;
    }

    /**
     * 論理削除
     *
     * @param integer $id
     * @return void
     */
    public function deleteRecord(int $id)
    {
        return self::find($id)->delete();
    }
}
