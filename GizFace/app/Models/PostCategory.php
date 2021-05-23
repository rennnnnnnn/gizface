<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PostCategory extends Model
{
    protected $guarded = ['id'];

    public function getAllRecord(): ?array
    {
        $result = self::select(
            'id',
            'category',
        )
            ->orderBy('id')
            ->pluck('category', 'id');
        if (!$result) {
            return null;
        }
        return $result->toArray();
    }
}
