<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class User extends Model
{
    protected $guarded = ['id'];

    /**
     * 初ログイン 仮登録
     *
     * @return int
     */
    public function proRegister(): int
    {
        $self = new User();
        $self->member_status = config('const.MEMBER_STATUS.YET');
        $self->save();
        return $self->id;
    }

    /**
     * ログイン時ユーザー情報登録
     *
     * @param Request $request
     * @param string $now
     * @return void
     */
    public function register(Request $request, string $now)
    {
        $name = $request->lastName . ' ' . $request->firstName;
        $romaName = $request->lastRomaName . ' ' . $request->firstRomaName;

        \DB::table('users')
            ->where('id', $request->userId)
            ->whereNull('deleted_at')
            ->update([
                'name' => $name,
                'last_name' => $request->lastName,
                'first_name' => $request->firstName,
                'roma_name' => $romaName,
                'last_roma_name' => $request->lastRomaName,
                'first_roma_name' => $request->firstRomaName,
                'email' => $request->email,
                'member_status' => config('const.MEMBER_STATUS.DONE'),
                'updated_at' => $now
            ]);
    }

    /**
     * 名前更新
     *
     * @param Request $request
     * @param string $name
     * @param string $romaName
     * @param string $now
     * @return void
     */
    public function updateRecord(Request $request, string $name, string $romaName, string $now)
    {
        \DB::table('users')
            ->where('id', $request->userId)
            ->whereNull('deleted_at')
            ->update([
                'name' => $name,
                'last_name' => $request->lastName,
                'first_name' => $request->firstName,
                'roma_name' => $romaName,
                'last_roma_name' => $request->lastRomaName,
                'first_roma_name' => $request->firstRomaName,
                'updated_at' => $now
            ]);
    }
}
