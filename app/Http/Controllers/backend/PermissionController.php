<?php

namespace App\Http\Controllers\backend;

use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Permission';
        $this->checkpermission('permission-list');
        $permission = Permission::all();
        return view('backend.permission.list', compact('permission', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Permission';
        $this->checkpermission('permission-create');
        return view('backend.permission.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission_key' => 'required|unique:permissions'
        ]);
        $message = Permission::create([
            'name' => $request->name,
            'permission_key' => $request->permission_key,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        if ($message) {
            return redirect()->route('permission.list')->with('success_message', 'You are successfully created');
        } else {
            return redirect()->route('permission.create')->with('error_message', 'can not created at this time ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Permission';
        $this->checkpermission('permission-edit');
        $permission = Permission::find($id);
        return view('backend.permission.edit', compact('permission', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission_key' => 'required|unique:permissions,permission_key,'.$id,
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->permission_key = $request->permission_key;
        $permission->updated_at = date('Y-m-d H:i:s');
        $message = $permission->update();
        if ($message) {
            return redirect()->route('permission.list')->with('success_message', 'successfully updated');
        } else {
            return redirect()->route('permission.update')->with('error_message', 'failed to  update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checkpermission('permission-delete');
        $permisison = Permission::find($id);
        $permisison->delete();
        return redirect()->route('permission.list')->with('success_message', 'successfully deleted');


    }

    public function asign($id)
    {
        $title = 'Assign Permission';
        $this->checkpermission('permission-asign');

        $roledetails = Role::find($id);
        $permission = Permission::all();
        $currentpermission = $roledetails->permissions;
        return view('backend.permission.asign', compact('roledetails', 'permission', 'currentpermission','title'));
    }

    public function permissionasign(Request $request, $id)
    {
        $data['role_id'] = $id;
        $role = Role::find($id);
        $rp = RolePermission::where('role_id', '=', $id)->get();
        foreach ($rp as $r) {
            $r->delete();
        }
        if (isset($request->asignpermission)) {
            foreach ($request->asignpermission as $p) {
                $data['permission_id'] = $p;
                RolePermission::create($data);
            }
        } else {
            return redirect()->route('role.list')->with('success_message', 'Your Operation is successfull');
        }

        return redirect()->route('role.list')->with('success_message', 'Your Operation is successfull');
    }
}
