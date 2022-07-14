<?php

namespace App\Helpers;

use Illuminate\Database\Query\Builder;

class QueryHelper
{
    public static function hasJoin(Builder $builder, $table)
    {
        foreach ($builder->joins as $joinClause) {
            if ($joinClause->table == $table) {
                return true;
            }
        }

        return false;
    }
}