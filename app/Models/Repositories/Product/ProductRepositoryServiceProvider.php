<?php
/**
 * ServiceProvider : ProductRepositoryServiceProvider.
 *
 * This file used to register ProductRepositoryService
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Models\Repositories\Product;

use App\Models\Entities\Product;
use Illuminate\Support\ServiceProvider;

class ProductRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Registers the ProductInterface with Laravels IoC Container.
     */
    public function register()
    {
        // Bind the returned class to the namespace 'App\Models\Repositories\Product\ProductInterface
        $this->app->bind(
            'App\Models\Repositories\Product\ProductInterface',
            function ($app) {
                return new ProductRepository(
                    new Product()
                );
            }
        );
    }
}
