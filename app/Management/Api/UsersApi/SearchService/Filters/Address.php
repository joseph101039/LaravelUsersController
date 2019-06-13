<?php

namespace App\Management\Api\UsersApi\SearchService\Filters;

use App\Management\IFilter;
use Illuminate\Database\Eloquent\Builder;


class Address implements IFilter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('address', $value);
    }
}
