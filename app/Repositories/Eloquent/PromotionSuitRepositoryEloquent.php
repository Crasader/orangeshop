<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Repositories\PromotionSuitRepository;
use App\Models\PromotionSuit;
use App\Validators\PromotionSuitValidator;

/**
 * Class PromotionSuitRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PromotionSuitRepositoryEloquent extends BaseRepository implements PromotionSuitRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PromotionSuit::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PromotionSuitValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
