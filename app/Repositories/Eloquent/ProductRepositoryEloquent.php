<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Repositories\ProductRepository;
use App\Models\Product;
use App\Validators\ProductValidator;

/**
 * Class ProductRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
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
        return Product::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProductValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
