<?php

namespace App\Management\Api\UsersApi\SearchService;

use App\Management\BaseSearchService;
use App\Management\Api\UsersApi\Entity;

class Search extends BaseSearchService
{
    public static function apply($filters, $type = 'page')
    {
        // filter the unset columns

        foreach($filters as $key => $val)
        {
            if(empty($val) || $val == '' || $val == null || $val == 'all' || $val == '~')
            {
                unset($filters[$key]);
            }
        }

        $query = BaseSearchService::applyDecoratorsFromRequest($filters, (new Entity)->newQuery(), 'Filters', __NAMESPACE__);

        if($type == 'page'){

            return BaseSearchService::getResultsWithPaginate($query, $filters['per_page']);
        }
        else{

            return BaseSearchService::getResultsWithGet($query);
        }
    }
}
