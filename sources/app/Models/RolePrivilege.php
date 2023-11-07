<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RolePrivilege
 *
 * @property int $role_id
 * @property string $privilege
 * @property int $active_flag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_user_id
 * @property int $updated_user_id
 * @property-read \App\Models\Privilege $privileges
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePrivilege newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePrivilege newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePrivilege query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePrivilege whereActiveFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePrivilege whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePrivilege whereCreatedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePrivilege wherePrivilege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePrivilege whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePrivilege whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RolePrivilege whereUpdatedUserId($value)
 * @mixin \Eloquent
 */
class RolePrivilege extends Model
{
    protected $table = 'roles_privileges';

    static public $useUpdateUserId = true;

    static public $useOrganization = false;

    protected $fillable = [
        'role_id',
        'privilege'
    ];

    public function privileges()
    {
        return $this->belongsTo('App\Models\Privilege', 'privilege', 'name');
    }
}
