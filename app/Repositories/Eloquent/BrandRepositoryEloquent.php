<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Repositories\BrandRepository;
use App\Models\Brand;
use App\Validators\BrandValidator;

/**
 * Class BrandRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class BrandRepositoryEloquent extends BaseRepository implements BrandRepository
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
        return Brand::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return BrandValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
