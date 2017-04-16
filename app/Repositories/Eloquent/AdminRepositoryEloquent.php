<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Repositories\AdminRepository;
use App\Models\Admin;
use App\Validators\AdminValidator;

/**
 * Class AdminRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class AdminRepositoryEloquent extends BaseRepository implements AdminRepository
{
    protected $fieldSearchable = [
        'username'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admin::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AdminValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
