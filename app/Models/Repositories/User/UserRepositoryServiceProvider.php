<?php
/**
 * ServiceProvider : UserRepositoryServiceProvider.
 *
 * This file used to register UserRepositoryService
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Models\Repositories\User;

use App\Models\Entities\User;
use Illuminate\Support\ServiceProvider;

class UserRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Registers the UserInterface with Laravels IoC Container.
     */
    public function register()
    {
        // Bind the returned class to the namespace 'App\Models\Repositories\User\UserInterface
        $this->app->bind(
            'App\Models\Repositories\User\UserInterface',
            function ($app) {
                return new UserRepository(
                    new User()
                );
            }
        );
    }
}
