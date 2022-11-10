<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\lotes_rastreamentoRepository;
use App\Models\LotesRastreamento;
use App\Validators\LotesRastreamentoValidator;

/**
 * Class LotesRastreamentoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LotesRastreamentoRepositoryEloquent extends BaseRepository implements LotesRastreamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LotesRastreamento::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}