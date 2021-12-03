<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UserService extends AbstractService
{
    /** @var Authenticatable|User|null  */
    protected $user;
    protected $userId;

    public function __construct(?Authenticatable $user = null)
    {
        $this->user = $user;
        if ($user !== null) {
            $this->userId = $this->user->getAttribute('id');
        }
    }
}
