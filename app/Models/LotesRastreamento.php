<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LotesRastreamento.
 *
 * @package namespace App\Models;
 */
class LotesRastreamento extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FAC_ID',
        'LOTE_DESC_SMALL',
        'LOTE_TOKEN',
        'LOTE_STATUS',
        'LOTE_QNT_ITENS',
        'LOTE_BIG_DESC'
    ];

    /**
     * Get the faccao that owns the LotesRastreamento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faccao()
    {
        return $this->belongsTo(Faccoes::class, 'FAC_ID', 'id');
    }

    /**
     * Get all of the itens for the LotesRastreamento
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itens()
    {
        return $this->hasMany(LotesRastreamentoItem::class, 'LOTE_ID', 'id');
    }

}
