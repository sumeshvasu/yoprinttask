<?php
/**
 * Repository : UserRepository.
 *
 * This file used to handling all user related activities, which all in UserInterface
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Models\Repositories\User;

use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserInterface
{
    // Our Eloquent models,
    protected $userModel;

    /**
     * Setting our class to the injected model.
     *
     * @return UserRepository
     */
    public function __construct(
        Model $user
    ) {
        $this->userModel = $user;
    }
}
