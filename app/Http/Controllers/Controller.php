<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Helpers\ResponseHelper;
use App\Helpers\UpdateAttrHelper;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ResponseHelper;
    use UpdateAttrHelper;

    public function responseMaker($code, $message, $data)
    {
        $result = ResponseHelper::responseMaker($code, $message, $data);

        $http_code = $result['http_code'];
        unset($result['http_code']);
        return response()->json($result, $http_code)->header('Content-Type', 'application\json');

    }

    public function filterUnsetAttr(Request $request, $attributes)
    {
        return UpdateAttrHelper::filterUnsetAttribute($request, $attributes);
    }

}
