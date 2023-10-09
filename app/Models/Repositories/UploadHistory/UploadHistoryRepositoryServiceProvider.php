<?php
/**
 * ServiceProvider : UploadHistoryRepositoryServiceProvider.
 *
 * This file used to register UploadHistoryRepositoryService
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Models\Repositories\UploadHistory;

use App\Models\Entities\UploadHistory;
use Illuminate\Support\ServiceProvider;

class UploadHistoryRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Registers the UploadHistoryInterface with Laravels IoC Container.
     */
    public function register()
    {
        // Bind the returned class to the namespace 'App\Models\Repositories\UploadHistory\UploadHistoryInterface
        $this->app->bind(
            'App\Models\Repositories\UploadHistory\UploadHistoryInterface',
            function ($app) {
                return new UploadHistoryRepository(
                    new UploadHistory()
                );
            }
        );
    }
}
