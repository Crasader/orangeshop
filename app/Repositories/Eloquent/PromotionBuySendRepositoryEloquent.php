<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Repositories\PromotionBuySendRepository;
use App\Models\PromotionBuySend;
use App\Validators\PromotionBuySendValidator;

/**
 * Class PromotionBuySendRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PromotionBuySendRepositoryEloquent extends BaseRepository implements PromotionBuySendRepository
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
        return PromotionBuySend::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PromotionBuySendValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
