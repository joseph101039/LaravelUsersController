<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $allUsers = $this->UserModel->get();

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
                'firstName' =>  $user->firstName,
                'gender'    => ($user->gender)?"女":"男",
                'photo'     =>  $photo??"",
                'lastName'  =>  $user->lastName,
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
       //dd(json_encode($userData));
        return json_encode($userData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $userData = [
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'password'  =>  $request->password,
        ];
        return $this->UserModel->create($userData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        User::find($id)->update([
            'name'  => $request->name,
            'email' => $request->email,
            'password'  => $request->password,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        User::destroy($id);
    }
}
