<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\faccoes_usersRepository;
use App\Models\FaccoesUsers;
use App\Validators\FaccoesUsersValidator;

/**
 * Class FaccoesUsersRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FaccoesUsersRepositoryEloquent extends BaseRepository implements FaccoesUsersRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FaccoesUsers::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findUser($id)
    {
        return FaccoesUsers::where('USER_ID',$id)->first()->faccoes;
    }
    
}
