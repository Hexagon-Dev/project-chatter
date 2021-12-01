<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    protected function checkPermission(string $operation): void
    {
        if ($this->user->cant($operation)) {
            throw new HttpException(Response::HTTP_FORBIDDEN);
        }
    }

    protected function checkRole(string $role): void
    {
        if (!$this->user->hasRole($role)) {
            throw new HttpException(Response::HTTP_FORBIDDEN);
        }
    }
}
