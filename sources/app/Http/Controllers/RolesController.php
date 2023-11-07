<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseResourceRequest;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\RolePrivilege;
use Illuminate\Support\Facades\Auth;


class RolesController extends BaseResourceController
{
    protected function _setData()
    {
        $this->Model = new Role();
    }

    public function show($id) : Response
    {
        $Data = Role::with(['privileges:id,name,sort_order'])->find($id);
        return response($Data);
    }

    protected function setPrivileges (Model $Data, BaseResourceRequest $request, bool $create_mode): Model
    {
        if (isset($request['privileges']) && $request['privileges']) {
            if (!$create_mode) {
                RolePrivilege::where('role_id', $Data['id'])->delete();
            }

            foreach ($request['privileges'] as $privilege) {
                $RolePrivilege = new RolePrivilege();
                $RolePrivilege->role_id = $Data['id'];
                $RolePrivilege->privilege = $privilege['name'];
                $RolePrivilege->active_flag = 1;
                $RolePrivilege->created_user_id = Auth::id();
                $RolePrivilege->updated_user_id = Auth::id();
                $RolePrivilege->save();
            }
        }
        return $Data;
    }

    protected function afterStore(Model $Data, BaseResourceRequest $request): Model
    {
        return $this->setPrivileges($Data, $request, true);
    }

    protected function afterUpdate(Model $Data, BaseResourceRequest $request): Model
    {
        return $this->setPrivileges($Data, $request, false);
    }

}
