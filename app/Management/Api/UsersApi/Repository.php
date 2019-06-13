<?php

namespace App\Management\Api\UsersApi;
use App\Management\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Repository extends BaseRepository
{
    private $entity;
    const MODEL = Entity::class;

    public function __construct()
    {
        $this->entity = new Entity();
    }

    /**
     *  random string generator for photo name
     * @param int $length
     * @return string $randomString
     * */
    private function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    /**
     *  Upload the user profile photo to local server storage without updating the photo name in database .
     * @param string $photo
     * @return array $result
     * */
    public function uploadProfilePhoto($photo)
    {
        // base64 format image with header
        if($photo) {
            // strip the image MIME
            if(preg_match('/^data:image\/(\w+);base64,/', $photo)) {
                $photoBase64 = substr($photo, strpos($photo, ',') + 1);
            }

            $photoDecode = base64_decode($photoBase64);
            if($photoDecode !== false) {
                $photoName = self::generateRandomString(20).'.jpeg';
                while(Storage::disk('local')->exists('images\\'.$photoName)){
                    $photoName = self::generateRandomString(20).'.jpeg';
                }

                // if the photo cannot be storage, do not update the image file name.
                if(Storage::disk('local')->put('images\\' . $photoName, $photoDecode)) {
                    return array('success' => true, 'name' => $photoName);
                }
            }
        }

        return array('success' => false, 'name' => null);
    }

    /**
     *  Find all user id by account
     * @param string $account
     * @return array $userIdList
     * */
    public function getIdByAccount($account)
    {
        return $this->entity->where('account', $account)->get('id');
    }

    /**
     *  Soft delete the specified user from storage
     * @param int $id
     * @return array $result
     * */
    public function softDelete($id)
    {
        try{
            $entity = $this->find($id);
            // set deleted_at to current
            $entity->deleted_at = Carbon::now();
            $entity->save();
        }
        catch(\Exception $e){
            return array('success'=>false, 'message'=>$e->getMessage());
        }
        return array('success'=>true, 'message'=>'done');

    }
}
