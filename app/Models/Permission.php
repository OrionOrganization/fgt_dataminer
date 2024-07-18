<?php

namespace App\Models;

use App\Traits\Models\TranslatedNameTrait;
use Backpack\PermissionManager\app\Models\Permission as BackpackPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends BackpackPermission
{
    use HasFactory, TranslatedNameTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'permissions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | EXTRA
    |--------------------------------------------------------------------------
    */

    public static function getList(): array
    {
        $data = [];

        $list = Permission::pluck('name');

        foreach ($list as $item) {
            $data[$item] = __("permission.$item");
        }

        return $data;
    }
}
