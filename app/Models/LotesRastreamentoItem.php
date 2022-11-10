<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LotesRastreamentoItem.
 *
 * @package namespace App\Models;
 */
class LotesRastreamentoItem extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'LOTE_ID',
        'LOTE_ITEM_IDENTIFY',
        'LOTE_ITEM_STATUS'
    ];

}
