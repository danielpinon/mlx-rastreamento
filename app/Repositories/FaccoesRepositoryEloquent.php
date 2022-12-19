<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FaccoesRepository;
use App\Models\Faccoes;
use App\Validators\FaccoesValidator;

/**
 * Class FaccoesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FaccoesRepositoryEloquent extends BaseRepository implements FaccoesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Faccoes::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    

    public function findToken($token)
    {
        return Faccoes::where('FAC_TOKEN',$token)->first();
    }
}
