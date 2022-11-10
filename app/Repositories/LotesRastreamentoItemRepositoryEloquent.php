<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\lotes_rastreamento_itemRepository;
use App\Models\LotesRastreamentoItem;
use App\Validators\LotesRastreamentoItemValidator;

/**
 * Class LotesRastreamentoItemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LotesRastreamentoItemRepositoryEloquent extends BaseRepository implements LotesRastreamentoItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LotesRastreamentoItem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
