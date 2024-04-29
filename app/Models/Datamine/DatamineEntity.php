<?php

namespace App\Models\Datamine;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class DatamineEntity extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'datamine_entities';
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

    public function datamineRaws()
    {
        return $this->hasMany(DatamineDividaAbertaRaw::class, 'cpf_cnpj', 'key');
    }

    public function value()
    {
        return $this->belongsTo(DatamineEntityValue::class, 'id', 'id');
    }

    public function ibge()
    {
        return $this->belongsTo(Ibge::class, 'code_ibge', 'code_ibge');
    }

    public function datamineCnpj()
    {
        return $this->belongsTo(DatamineCnpj::class, 'key_unmask', 'id');
    }

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
