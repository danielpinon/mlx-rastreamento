<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SetoresRepository;
use App\Models\Setores;
use App\Validators\SetoresValidator;

/**
 * Class SetoresRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SetoresRepositoryEloquent extends BaseRepository implements SetoresRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Setores::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
