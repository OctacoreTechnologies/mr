<?php

namespace App\Http\Controllers\RoleAndPermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::orderByDesc('created_at')->paginate(5);
        return response()->view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions=Permission::orderByDesc('created_at')->get();
        return response()->view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|unique:roles',
        ]);
        // dd($request->all());
        if($validator->passes()){
            $role= Role::create(['name'=>$request->name]);
            session()->flash('success','role is created successfully');

            if(!empty($request->permission)){
                foreach($request->permission as $permission){
                    $role->givePermissionTo($permission);
                }
            }
            return redirect()->route('admin.role.index');
        }
        else{
            return redirect()->route('admin.role.create')->withInput()->withErrors($validator->errors());
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
        $role=Role::findOrFail($id);
        $assignPermission=$role->permissions->pluck('name');
        $permissions=Permission::orderByDesc('created_at')->get();
        // dd($permissions);
        return response()->view('roles.edit',[
            'role'=>$role,
            'assignPermission'=>$assignPermission,
            'permissions'=>$permissions
        ]);
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
            'name'=>'required|unique:roles,name,'.$id.',id',
        ]);
        // dd($request->all());
        if($validator->passes()){
            $role= Role::findOrFail($id);
            $role->update(['name'=>$request->name]);
            if(!empty($request->permission)){
                $role->syncPermissions($request->permission);
            }
            else{
                $role->syncPermissions([]);
            }
            session()->flash('success','role is updated successfully');
            return redirect()->route('admin.role.index');
        }
        else{
            return redirect()->route('admin.role.create')->withInput()->withErrors($validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=Role::findOrFail($id);
        $role->delete();
        session()->flash('success','role is deleted successfully');
        return redirect()->route('admin.role.index');
    }
}
