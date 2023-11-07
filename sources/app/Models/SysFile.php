<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysFile extends Model
{
    use SoftDeletes;

    static public $useUpdateUserId = true;

    static public $useOrganization = true;

    protected $table = 'sys_files';

    protected $guarded = ['id', 'created_at', 'update_at', 'deleted_at'];

    public $incrementing = false;
}
