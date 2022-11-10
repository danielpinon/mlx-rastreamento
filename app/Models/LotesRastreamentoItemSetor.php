<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LotesRastreamentoItemSetor.
 *
 * @package namespace App\Models;
 */
class LotesRastreamentoItemSetor extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'LOTE_ITEM_ID',
        'SETOR_ID',
        'STATUS',
        'INIT',
        'EXIT'
    ];

}
