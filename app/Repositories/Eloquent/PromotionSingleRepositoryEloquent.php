<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Repositories\PromotionSingleRepository;
use App\Models\PromotionSingle;
use App\Validators\PromotionSingleValidator;

/**
 * Class PromotionSingleRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PromotionSingleRepositoryEloquent extends BaseRepository implements PromotionSingleRepository
{
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PromotionSingle::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PromotionSingleValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
