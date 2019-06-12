<?php

namespace App\Helpers;

use Illuminate\Http\Request;

//use Illuminate\Support\Arr;

trait UpdateAttrHelper
{
    /**
     *
     *  For update method
     * @param Request $request
     * @param array $attributes
     * @return array $data
     * */
    public static function filterUnsetAttribute(Request $request, $attributes)
    {
        $userData = [];
        $requestArr = $request->all();
        foreach ($attributes as $attr) {
            if (isset($requestArr[$attr])) {
                $userData[$attr] = $request[$attr];
            }
        }

        return $userData;
    }

    /**
     *
     *  For store method,  assign null to unset attributes.
     * @param Request $request
     * @param array $attributes
     * @return array $data
     * */
    public function setUnsetAttributeNull(Request $request, $attributes)
    {
        $userData = [];
        $requestArr = $request->all();

        foreach ($attributes as $attr) {
            if (isset($requestArr[$attr])) {
                $userData[$attr] = $requestArr[$attr];
            } else {
                $userData[$attr] = null;
            }
        }
        return $userData;
    }
}


