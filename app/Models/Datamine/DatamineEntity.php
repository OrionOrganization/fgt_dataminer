<?php

namespace App\Models\Datamine;

use App\Enum\Datamine\DataMineEntitiesType;
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
    protected $casts = [
        'extra' => 'json'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function isTypePj(): bool
    {
        return ($this->type_entity == DataMineEntitiesType::PJ()->getValue());
    }

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
