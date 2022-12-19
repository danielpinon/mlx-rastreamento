<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Faccoes.
 *
 * @package namespace App\Models;
 */
class Faccoes extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FAC_NAME',
        'FAC_TOKEN',
        'FAC_STATUS'
    ];

    /**
     * Get all of the lotes for the Faccoes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lotes()
    {
        return $this->hasMany(LotesRastreamento::class, 'FAC_ID', 'id');
    }
}
