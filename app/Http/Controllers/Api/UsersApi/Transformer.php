<?php
namespace App\Http\Controllers\Api\UsersApi;

use Illuminate\Pagination;
use Illuminate\Support\Facades\Storage;

class Transformer
{
    /** Transform the data format get from Users Service
     * @param Pagination\Paginator $result
     * @return Pagination\LengthAwarePaginator $data
    */
    public function UsersTransformerPostProcessing($result, $per_page)
    {

        $userData = [];
        $currentPage = $result->currentPage();
        $totalItem = $result->total();  //number of total entity in search result
        $result = $result->items();     // paginate object to array, each element is a Entity(Model) object


        $key = 1;
        foreach($result as $entity)
        {
            $val = $entity->toArray();
            //dd($val);
            $photo = null;
            if(isset($val['photo'])){
                // check if the user profile image exists. If it's existed, read and encode as base64.
                if(Storage::disk('local')->exists('images\\'.$val['photo'])){
                    $photo = base64_encode(Storage::get('images\\'.$val['photo']));
                }
            }

            $userData[$key]['key']          =   $key;
            $userData[$key]['id']           =   $val['id'];
            $userData[$key]['firstName']    =   $val['first_name'];
            $userData[$key]['gender']       =   ($val['gender'] == 1)?'女':'男';
            $userData[$key]['photo']        =   $photo?'data:image/jpeg;base64,'.$photo:null;
            $userData[$key]['lastName']     =   $val['last_name'];
            $userData[$key]['interest']     =   json_decode($val['interest']);
            $userData[$key]['city']         =   $val['city'];
            $userData[$key]['address']      =   $val['address'];
            $userData[$key]['tel']          =   $val['tel'];
            $userData[$key]['birthday']     =   $val['birthday'];
            $userData[$key]['account']      =   $val['account'];
            $userData[$key]['password']     =   $val['password'];
            $key++;
        };

        return new Pagination\LengthAwarePaginator($userData, $totalItem, $per_page);
    }

    /**
     * Pre-processing before update the instance
     * @param array $userData
     * @return array $data
     *
     * */

    public function UserTransformerPreProcessing($userData)
    {
        if(isset($userData['interest'])) {
            $userData['interest'] = json_encode($userData['interest']);
        }
        if(isset($userData['gender'])){
            $userData['gender'] =  ($userData['gender'] == '女' ) ? 1:0;
        }


        return $userData;
    }
}
