<?php

namespace App\Management;
use Illuminate\Database\Eloquent\Builder;
//use Log; // unused currently

abstract class BaseSearchService
{
    public static function applyDecoratorsFromRequest($request, Builder $query, $filter_folder, $name_space)
    {
        foreach ($request as $filterName => $value) {
            if (empty($value) || $value == '' || $value == null) {
                unset($request[$filterName]);
                continue;
            }
            $decorator = $name_space . '\\'.$filter_folder.'\\' . studly_case($filterName);
            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }
        return $query;
    }

    public static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    public static function getResultsWithPaginate(Builder $query, $per_page)
    {
        return $query->paginate($per_page);
    }

    public static function getResultsWithGet(Builder $query)
    {
        return $query->get();
    }


}
