<?php
/**
 * Interface : ProductInterface.
 *
 * This file used to initialise all product related activities
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Models\Repositories\Product;

interface ProductInterface
{
    /**
     * Store products.
     */
    public function store($data);
}
