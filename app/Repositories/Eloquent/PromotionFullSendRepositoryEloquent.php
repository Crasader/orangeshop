<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Repositories\PromotionFullSendRepository;
use App\Models\PromotionFullSend;
use App\Validators\PromotionFullSendValidator;

/**
 * Class PromotionFullSendRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class PromotionFullSendRepositoryEloquent extends BaseRepository implements PromotionFullSendRepository
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
        return PromotionFullSend::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PromotionFullSendValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
