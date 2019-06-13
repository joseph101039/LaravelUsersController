<?php

namespace App\Http\Controllers\Api\UsersApi;

use App\Management\Api\UsersApi\SearchService\Search as UsersSearch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Management\Api\UsersApi\Service as UsersService;
use App\Http\Controllers\Api\UsersApi\Transformer as UsersTransformer;

//use App\User;
//use Carbon\Carbon;


class Controller extends \App\Http\Controllers\Controller
{
    private $usersService;
    private $usersTransformer;
    private $usersColumn;


    public function __construct()
    {
        $this->usersService = new UsersService();
        $this->usersTransformer = new UsersTransformer();
        $this->usersColumn = ['first_name', 'last_name', 'tel', 'birthday', 'gender', 'interest', 'city', 'address', 'account', 'password'];

    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $response
     */
    public function index(Request $request)
    {
        // for search filter usage
        $filters = [
            'id'            =>  $request->id??null,
            'first_name'    =>  $request->firstName??null,
            'gender'        =>  isset($request->gender)?(($request->gender === '女')?1:0):null,
            'last_name'     =>  $request->last_name??null,
            'city'          =>  $request->city??null,
            'address'       =>  $request->address??null,
            'birthday'      =>  $request->birthday??null,
            'account'       =>  $request->account??null,
            'tel'           =>  $request->tel??null,
        ];

        // Set the number of element per page to 6, a fixed value
        try{
            $filters['per_page'] = $filters['per_page'] ?? 6;
            $searchResult = UsersSearch::apply($filters);

            if(count($searchResult) == 0){
                return $this->responseMaker(17, null, null);
            }

            $userData = $this->usersTransformer->UsersTransformerPostProcessing($searchResult, $filters['per_page']);
            $response = $this->responseMaker(0, null, $userData);
        }
        catch(\Exception $e){
            $response = $this->responseMaker(1, $e->getMessage(), null);
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response $response
     */

    public function update(Request $request, $id)
    {
        try{
            // call the helper to filter the request attributes for partial update
            $userData = $this->filterUnsetAttr($request, $this->usersColumn);
            // pre-processing the data format
            $userData = $this->usersTransformer->UserTransformerPreProcessing($userData);
            $result = $this->usersService->update($userData, $id);
            $response = $this->responseMaker(($result['success']) ? 101: 8, $result['message'], null);
        }
        catch(\Exception $e){
            return $this->responseMaker(1, $e->getMessage(), null);
        }

        return $response;
    }


    /**
     *  Store a newly created resource in storage
     *
     * @param Request $request
     * @return Response $response
     * */

    public function store(Request $request)
    {
        try{
            $userData = $this->setUnsetAttributeNull($request, $this->usersColumn);
            $userData = $this->usersTransformer->UserTransformerPreProcessing($userData);
            $result = $this->usersService->store($userData);
            $response = $this->responseMaker(($result['success']) ? 101: 8, $result['message'], null);

        }
        catch(\Exception $e){
            return $this->responseMaker(1, $e->getMessage(), null);

        }

        return $response;
    }


    /**
     * Soft delete the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response $response
     */
    public function destroy($id)
    {
        try{
            $result = $this->usersService->destroy($id);
            $response = $this->responseMaker($result['success']?101:7, $result['message'], null);
        }
        catch(\Exception $e){
            return $this->responseMaker(1, $e->getMessage(), null);
        }
        return $response;
    }




    /**
     * check if the account already exists .
     * @param string $account
     * @return array $matchedId
     * */

    public function checkIfAccountExisted($account)
    {
        //return id of existed user
        return $this->usersService->checkUniqueAccount($account);

    }
}
