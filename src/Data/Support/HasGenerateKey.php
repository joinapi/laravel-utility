<?php

namespace Joinbiz\Data\Support;

use Illuminate\Database\Eloquent\Concerns\HasUniqueStringIds;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait HasGenerateKey
{
    use HasUniqueStringIds;

    public function newUniqueId()
    {

        $seq = $this->table . '_seq';

        return DB::selectOne("SELECT nextval(?)", [$seq])->nextval.'';
    }

    /**
     * Determine if given key is valid.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function isValidUniqueId($value): bool
    {
        return Str::length($value) > 0;
    }

}
