<?php
/**
 * Repository : ProductRepository.
 *
 * This file used to handling all product related activities, which all in ProductInterface
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Models\Repositories\Product;

use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductInterface
{
    // Our Eloquent model
    protected $productModel;

    /**
     * Setting our class to the injected model.
     *
     * @return ProductRepository
     */
    public function __construct(Model $productModel)
    {
        $this->productModel = $productModel;
    }

    /**
     * Store products.
     */
    public function store($data)
    {
        $productObject = $this->productModel::where('UNIQUE_KEY', $data['UNIQUE_KEY'])->first();

        if ($productObject) {
            $productObject->update($data);
        } else {
            $this->productModel::create($data);
        }
    }
}
