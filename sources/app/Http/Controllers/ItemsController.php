<?php

namespace App\Http\Controllers;

use App\Models\Item;

class ItemsController extends BaseResourceController
{
    protected function _setData()
    {
        $this->Model = new Item();
    }
}
