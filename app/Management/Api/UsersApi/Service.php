<?php
namespace App\Management\Api\UsersApi;

use App\Management\BaseService;
use App\Management\Api\UsersApi\Repository as UsersRepository;
use Illuminate\Http\Request;



class Service extends BaseService
{
    private $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $userData
     * @param  int  $id
     * @return array $updateResult
     */


    public function update($userData, $id)
    {
        $uploadResult = null;
        // error status and message processing
        $retMessage = '';

        if(isset($userData['photo']))
        {
            $uploadResult = $this->usersRepository->uploadProfilePhoto($userData['photo']);
            if($uploadResult['success'])
            {
                // Photo file name will be updated due to the success of the photo storage.
                $userData['photo'] = $uploadResult['name'];
            }
            else{
                // Photo file name will not be updated due to the failure of the photo storage.
                unset($userData['photo']);
            }
        }

        if($this->usersRepository->update($userData, $id)) {
            $retStatus = true;
            $retMessage .= 'Requests has been updated,';
            if(isset($uploadResult['success']))
            {
                if ($uploadResult['success']) {
                    $retMessage .= 'and the photo is successfully uploaded to local storage';
                } else {
                    $retStatus = false;
                    $retMessage .= ' but the photo is not uploaded to local storage.';
                }
            }
        }else{
            $retStatus = false;
            $retMessage .= 'All requests are failed.';
        }

        return array('success' => $retStatus, 'message' => $retMessage);

    }
    /**
     *  Store a newly created instance in storage
     *  @param  array $userData
     * @return array $result
     * */
    public function store($userData)
    {
        $storeResult = null;

        if(isset($userData['photo']))
        {
            $uploadResult = $this->usersRepository->uploadProfilePhoto($userData['photo']);
            if($uploadResult['success'])
            {
                // Photo file name will be updated due to the success of the photo storage.
                $userData['photo'] = $uploadResult['name'];
            }
        }


        $retMessage = '';
        if($this->usersRepository->create($userData))
        {
            $storeResult = true;
            $retMessage .= 'New user has been created, ';

            // check if photo upload is successful
            if ($storeResult['success']) {
                $retMessage .= 'and the photo is successfully uploaded to local storage';
            } else {
                $retStatus = false;
                $retMessage .= ' but the photo is not uploaded to local storage.';
            }
        }
        else{
            $retStatus = false;
            $retMessage .= 'Create requests are failed.';
        }


        return array('success' => $retStatus, 'message' => $retMessage);
    }


    /**
     *  Delete the specified resource in storage
     * @param int $id
     * @return array $result
     * */

    public function destroy($id)
    {
        return $this->usersRepository->softDelete($id);
    }

    /**
     * Update the specified account is already existed.
     *
     * @param  string $account
     * @return array $matchedId
     */
    public function checkUniqueAccount($account)
    {
        $userId = $this->usersRepository->getIdByAccount($account);

        return count($userId)?json_encode([['id'=>$userId[0]->id]]):json_encode([]);
    }

}
