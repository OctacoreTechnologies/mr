<?php

namespace App\Http\Controllers\RoleAndPermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $permissions=Permission::orderByDesc('created_at')->paginate(5);
        return response()->view('permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|unique:permissions|min:3'
     ]);

      if(!$validator->fails()){
         Permission::create($validator->validate());
         session()->flash('success','permission is created successfully');
         return redirect()->route('admin.permission.index');
      }
      else{
         return redirect()->route('admin.permission.index')->withInput()->withErrors($validator->errors());
      }
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission=Permission::findOrFail($id);
        return response()->view('permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|unique:permissions,name,'.$id.',id|min:3'
        ]);
        if($validator->fails()){
            return redirect()->route('permission.create')->withInput()->withErrors($validator->errors());
        }
        $permission=Permission::findOrFail($id)->update(
            ['name'=>$request->name]
        );

        session()->flash('success','permission is updated successfully');
        return redirect()->route('admin.permission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission=Permission::findOrFail($id);
        $permission->delete();
        session()->flash('success','permission is deleted successfully');
        return redirect()->route('admin.permission.index');
    }
}
