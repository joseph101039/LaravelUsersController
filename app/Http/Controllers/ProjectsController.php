<?php

namespace App\Http\Controllers;

use App\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    private $projectModel;

    public function __construct()
    {
        $this->projectModel = new Projects();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->projectModel->get();
        //
//        return view('project');
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
        $data = [
            'project_name' => $request->project_name,
            'user_id' => $request->user_id,
            'description' => $request->description
        ];

        //return $this->projectModel->create($request->toArray());
        return $this->projectModel->create($data);


//        if(auth()->check()) {
//            $this->validate([
//                'project_name' => 'required|min:1|max:255',
//                'user_id' => 'required|numeric|gt:1',
//                'description' => 'required|min:1'
//            ]);
//
//            if($request['id'] == auth()->id()) {
//                Projects::firstOrNew($request);
//            }
//        }
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
        return Projects::find($id);
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
//        Projects::where('id', $id)->update([
//            'project_name'=> $request->project_name,
//            'user_id' => $request->user_id,
//            'description' => $request->description,
//        ]);

        Projects::find($id)->update([
            'project_name'=> $request->project_name,
            'user_id' => $request->user_id,
            'description' => $request->description,
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
        //Projects::where('id', $id)->delete();
        Projects::destroy($id);
    }
}
