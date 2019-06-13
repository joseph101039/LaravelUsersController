<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/10/16
 * Time: 下午1:54
 */

namespace App\Management;

use Illuminate\Database\Eloquent\Builder;

interface IFilter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value);
}
