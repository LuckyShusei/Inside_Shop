<?php

namespace App\Http\Controllers;

use App\Models\Privilege;

class PrivilegesController extends BaseResourceController
{

    protected function _setData()
    {
        $this->Model = new Privilege();
    }

}
