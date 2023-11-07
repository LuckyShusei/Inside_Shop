<?php

namespace App\Http\Controllers;

use App\Models\Partner;

class PartnersController extends BaseResourceController
{
    protected function _setData()
    {
        $this->Model = new Partner();
    }
}
