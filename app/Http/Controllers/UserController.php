<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination;


class UserController extends Controller
{
    private $UserModel;

    public function __construct()
    {
        $this->UserModel  = new User();
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $allUsers = $this->UserModel->paginate(6);
        $total = $allUsers->total();
        $allUsers = $allUsers->items();

		//$allUsers = $this>UserModel->get();
        $userData = [];
        foreach ($allUsers as $user)
        {
            $photo = null;
            if($user->photo){
                // check if the user profile image exists.
                if(Storage::disk('local')->exists('images\\'.$user->photo)){
                    $photo = base64_encode(Storage::get('images\\'.$user->photo));
                }
            }


            $data = [
                'id'        =>  $user->id,
                'firstName' =>  $user->first_name,
                'gender'    => ($user->gender)?"女":"男",
                'photo'     =>  $photo?'data:image/jpeg;base64,'.$photo:"",
                'lastName'  =>  $user->last_name,
                'interest'  =>  json_decode($user->interest),
                'city'      =>  $user->city??"",
                'address'   =>  $user->address??"",
                'tel'       =>  $user->tel,
                'birthday'  =>  $user->birthday, // check not null?
                'account'   =>  $user->account,
                'password'  =>  $user->password,

            ];

            array_push($userData, $data);
        }
        return json_encode(new Pagination\LengthAwarePaginator($userData, $total, 6));
       //dd(json_encode($userData));
//        return json_encode($userData);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $photoName = null;
        if($request->photo) {
            // strip the photo header information
            if(preg_match('/^data:image\/(\w+);base64,/', $request->photo))
            {
                $photoBase64 = substr($request->photo, strpos($request->photo, ',') + 1);
            }
            $photoDecode = base64_decode($photoBase64);
            if($photoDecode !== false)
            {
                $photoName = self::generateRandomString(20).'.jpeg';
                while(Storage::disk('local')->exists('images\\'.$photoName)){
                    $photoName = self::generateRandomString(20).'.jpeg';
                }
                if(!Storage::disk('local')->put('images\\' .  $photoName, $photoDecode))
                {
                    $photoName = null;
                }
            }
        }



        $interestStr = json_encode($request->interest);

        $userData = [
            'firstName' =>  $request->first_name,
            'lastName'  =>  $request->last_name,
            'tel'       =>  $request->tel,
            'birthday'  =>  $request->birthday,
            'gender'    => ($request->gender)=="女"?1:0,
            'interest'  =>  $interestStr?$interestStr:json_encode([]),
            'city'      =>  $request->city,
            'address'   =>  $request->address,
            'account'   =>  $request->account,
            'password'  =>  $request->password,
            'photo'     => $photoName,
        ];

        return $this->UserModel->create($userData);


        //return true;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $photoName = null;
        if($request->photo) {
            // strip the photo header information
            if(preg_match('/^data:image\/(\w+);base64,/', $request->photo))
            {
                $photoBase64 = substr($request->photo, strpos($request->photo, ',') + 1);
            }
            $photoDecode = base64_decode($photoBase64);
            if($photoDecode !== false)
            {
                $photoName = self::generateRandomString(20).'.jpeg';
                while(Storage::disk('local')->exists('images\\'.$photoName)){
                    $photoName = self::generateRandomString(20).'.jpeg';
                }

                // if the photo cannot be storaged, do not update the image file name.
                if(!Storage::disk('local')->put('images\\' . $photoName, $photoDecode))
                {
                    $photoName = null;
                }
            }
        }



        $interestStr = json_encode($request->interest);

        $userData = [
            'firstName' =>  $request->first_name,
            'lastName'  =>  $request->last_name,
            'tel'       =>  $request->tel,
            'birthday'  =>  $request->birthday,
            'gender'    => ($request->gender)=="女"?1:0,
            'interest'  =>  $interestStr?$interestStr:json_encode([]),
            'city'      =>  $request->city,
            'address'   =>  $request->address,
            'account'   =>  $request->account,
            'password'  =>  $request->password,
        ];

        if(isset($photoName))
        {
            $userData['photo'] = $photoName;
        }

        User::find($id)->update(
            $userData
        );
        //return response()->json($request);

        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // use soft delete method
        $user = User::find($id);
        if($user)
        {
            $user->deleted_at = Carbon::now();
            $user->save();
        }

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
     * check if the account already exists.
     * @param string $account
     * @return array $matchedId
     * */

    public function checkIfAccountExisted($account)
    {
        //return id of existed user
        $userId = User::where('account', $account)->get('id');
        return count($userId)?json_encode([['id'=>$userId[0]->id]]):json_encode([]);
    }
}
