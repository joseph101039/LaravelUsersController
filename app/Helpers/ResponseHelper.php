<?php

namespace App\Helpers;

trait ResponseHelper
{
    public static function responseMaker($code, $message, $data = null)
    {
        // Please refer to the recommended HTTP request code:
        // https://blog.gslin.org/archives/2016/05/25/6596/%E6%BC%82%E4%BA%AE%E7%9A%84-http-response-code-cheatsheet/

        $department_code = '22';
        $project_code = '02';
        switch ($code) {
            case '101':
                $response = [
                    'http_code' => 200,
                    'status_message' => '新增成功',
                    'return_data' => $data
                ];
                break;
            case 0:
                $response = [
                    'http_code' => 200,
                    'error_code' => null,
                    'status_message' => $message,
                    'return_data' => $data
                ];
                break;
            case 1:
                $response = [
                    'http_code' => 400,
                    'status_message' => $message,
                    'return_data' => $data
                ];
                break;

            case 2:
                $response = [
                    'http_code' => 204,
                    'error_code' => '200002',
                    'status_message' => '無法找到該使用者',
                    'return_data' => $data
                ];
                break;

            case 3:
                $response = [
                    'http_code' => 204,
                    'error_code' => '200004',
                    'status_message' => '找無此目錄',
                    'return_data' => $data
                ];
                break;

            case 4:
                $response = [
                    'http_code' => 204,
                    'error_code' => '200005',
                    'status_message' => '找不到該檔案路徑',
                    'return_data' => $data
                ];
                break;
            case 5:
                $response = [
                    'http_code' => 405,
                    'error_code' => '200006',
                    'status_message' => '拒絕存取',
                    'return_data' => $data
                ];
                break;
            case 6:
                $response = [
                    'http_code' => 204,
                    'error_code' => '200006',
                    'status_message' => '請輸入API HTML路徑',
                    'return_data' => $data
                ];
                break;

            case 7:
                $response = [
                    'http_code' => 415,
                    'error_code' => '200007',
                    'status_message' => '檔案格式錯誤',
                    'return_data' => $data
                ];
                break;

            case 8:
                $response = [
                    'http_code' => 304,
                    'error_code' => '200008',
                    'status_message' => '建立資料失敗',
                    'return_data' => $data
                ];
                break;

            case 9:
                $response = [
                    'http_code' => 415,
                    'error_code' => '200009',
                    'status_message' => '輸入資料有誤',
                    'return_data' => $data
                ];
                break;

            case 10:
                $response = [
                    'http_code' => 415,
                    'error_code' => '200009',
                    'status_message' => '建立HTML檔失敗',
                    'return_data' => $data
                ];
                break;
            case 16:
                $response = [
                    'http_code' => 400,
                    'error_code' => '200013',
                    'status_message' => '此方法不允許存取',
                    'return_data' => $data
                ];
                break;

            case 17:
                $response = [
                    'http_code' => 200,
                    'error_code' => null,
                    'status_message' => '查無資料',
                    'return_data' => null
                ];
                break;

            case 18:
                $response = [
                    'http_code' => 405,
                    'error_code' => '200006',
                    'status_message' => '拒絕存取，請使用公司Email',
                    'return_data' => $data
                ];
                break;

            default:
                $response = [
                    'http_code' => 400,
                    'error_code' => '200003',
                    'status_message' => '錯誤的Request',
                    'return_data' => $data
                ];
                break;
        }
        $response['status_code'] = $department_code.$project_code.$code;
        return $response;
    }


}
