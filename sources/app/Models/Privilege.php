<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Privilege
 *
 * @property int $id
 * @property string $name
 * @property int $active_flag
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $created_user_id
 * @property int $updated_user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Privilege onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege whereActiveFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege whereCreatedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Privilege whereUpdatedUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Privilege withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Privilege withoutTrashed()
 * @mixin \Eloquent
 */
class Privilege extends Model
{
    use SoftDeletes;

    static public $useUpdateUserId = true;

    static public $useOrganization = false;

    static public $useSortOrder = true;

    protected $fillable = [
        'name',
    ];
}
