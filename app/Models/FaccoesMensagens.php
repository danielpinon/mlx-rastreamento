<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FaccoesMensagens.
 *
 * @package namespace App\Models;
 */
class FaccoesMensagens extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FAC_ID',
        'FAC_MSG_APP',
        'LOTE_ID',
        'FAC_MSG_READ'
    ];
    
    /**
     * Get the faccoes that owns the FaccoesUsers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faccoes()
    {
        return $this->belongsTo(Faccoes::class, 'FAC_ID', 'id');
    }
}
