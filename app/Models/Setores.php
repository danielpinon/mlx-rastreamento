<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Setores.
 *
 * @package namespace App\Models;
 */
class Setores extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'SETOR_ORDEM',
        'SETOR_NAME',
        'SETOR_TOKEN',
        'SETOR_STATUS',
        'SETOR_STATUS_EXCLUSIVE_MLX'
    ];

}
