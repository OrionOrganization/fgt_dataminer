<?php

namespace App\Models\Datamine;

use App\Traits\Crud\HandlesCrudFields;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class DatamineEntityValue extends Model
{
    use CrudTrait;
    use HandlesCrudFields;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'datamine_entities_values';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'value_all',
        'value_indicador_ajuizado',
        'value_n_indicador_ajuizado',
        'value_type_tax_benefit',
        'value_type_in_collection',
        'value_type_in_negociation',
        'value_type_guarantee',
        'value_type_suspended',
        'value_type_others'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getFormattedValue($attribute)
    {
        return $this->money($this->$attribute);
    }

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
}
