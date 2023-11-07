<?php

namespace App\Models;

class Item extends BaseResourceModel
{
    protected $collection = 'items';

    static public $useOrganization = true;

    static public $useSortOrder = true;

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}