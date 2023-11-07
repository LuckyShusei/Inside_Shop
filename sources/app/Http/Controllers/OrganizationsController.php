<?php

namespace App\Http\Controllers;

use App\Models\Organization;

class OrganizationsController extends BaseResourceController
{

    protected function _setData()
    {
        $this->Model = new Organization();
    }
}
