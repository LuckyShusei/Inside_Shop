<?php

namespace App\Models;

class Project extends BaseResourceModel
{
    protected $collection = 'projects';

    static public $useOrganization = true;

    static public $useSortOrder = true;

    public function items()
    {
        return $this->hasMany(Item::class, 'project_id', 'id');
    }
}