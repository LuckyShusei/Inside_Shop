<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Organization
 *
 * @property int $id
 * @property string $name
 * @property string|null $information_mail_from
 * @property string|null $information_mail_to
 * @property string|null $logo_image
 * @property int $active_flag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $created_user_id
 * @property int $updated_user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Organization onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereActiveFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereCreatedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereInformationMailFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereInformationMailTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereLogoImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereUpdatedUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Organization withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Organization withoutTrashed()
 * @mixin \Eloquent
 */
class Organization extends BaseResourceModel
{
    protected $collection = 'organizations';

    static public $useSortOrder = true;

}
