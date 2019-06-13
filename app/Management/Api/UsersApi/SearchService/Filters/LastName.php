<?php
/**
 * Created by PhpStorm.
 * User: steven_wang
 * Date: 2018/12/18
 * Time: 上午 09:26
 */

namespace App\Management\Api\UsersApi\SearchService\Filters;

use App\Management\IFilter;
use Illuminate\Database\Eloquent\Builder;

class LastName implements IFilter
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('last_name', $value);
    }

}
