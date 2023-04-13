<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FaccoesMensagensRepository;
use App\Models\FaccoesMensagens;
use App\Validators\FaccoesMensagensValidator;

/**
 * Class FaccoesMensagensRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FaccoesMensagensRepositoryEloquent extends BaseRepository implements FaccoesMensagensRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FaccoesMensagens::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
