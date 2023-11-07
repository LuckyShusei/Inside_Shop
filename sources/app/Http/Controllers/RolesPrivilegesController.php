<?php

namespace App\Http\Controllers;

use App\Models\RolePrivilege;

class RolesPrivilegesController extends BaseResourceController
{
    protected function _setData()
    {
        $this->Model = new RolePrivilege();
    }

}
