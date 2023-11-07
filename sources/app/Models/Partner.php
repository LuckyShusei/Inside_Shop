<?php

namespace App\Models;

class Partner extends BaseResourceModel
{
    protected $collection = 'partners';

    static public $useOrganization = true;

    static public $useSortOrder = true;

}
