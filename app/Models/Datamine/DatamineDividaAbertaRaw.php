<?php

namespace App\Models\Datamine;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class DatamineDividaAbertaRaw extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'datamine_divida_aberta_raws';
    // protected $primaryKey = 'id';
    public $timestamps = false;
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

    public function scopeCnpj($query, $cnpj)
    {
        return $query->where('cpf_cnpj', $cnpj);
    }

    public function scopeCpf($query, $cpf)
    {
        return $query->where('cpf_cnpj', $cpf);
    }

    public function scopeJudged($query)
    {
        return $query->where('indicador_ajuizado', 'SIM');
    }

    public function scopeUnjudged($query)
    {
        return $query->where('indicador_ajuizado', 'NAO');
    }

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
