<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\lotes_rastreamento_item_setorRepository;
use App\Models\LotesRastreamentoItemSetor;
use App\Validators\LotesRastreamentoItemSetorValidator;

/**
 * Class LotesRastreamentoItemSetorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LotesRastreamentoItemSetorRepositoryEloquent extends BaseRepository implements LotesRastreamentoItemSetorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LotesRastreamentoItemSetor::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
