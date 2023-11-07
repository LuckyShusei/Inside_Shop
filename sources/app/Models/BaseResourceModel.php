<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseResourceModel extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $collection;

    static public $useUpdateUserId = true;

    static public $useOrganization = false;

    static public $useSortOrder = false;

    public function __construct(array $attributes = [])
    {
        $collection_setting = \Mopi::getResource($this->collection);
        foreach ($collection_setting as $key => $val) {
            $this->fillable[] = $key;
        }
        parent::__construct($attributes);
    }
}
