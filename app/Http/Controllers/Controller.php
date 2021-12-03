<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AbstractService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var Authenticatable|User|null  */
    protected $user;
    protected int $userId;

    protected string $serviceInterface = '';

    protected ?AbstractService $service;

    /**
     * @throws BindingResolutionException
     */
    public function __construct(?Authenticatable $user = null)
    {
        $this->user = $user;
        if ($this->serviceInterface) {
            $this->service = app()->make($this->serviceInterface);
        }
    }

    /**
     * @throws AuthorizationException
     */
    protected function checkPermission(string $operation): void
    {
        if ($this->user->cant($operation)) {
            throw new AuthorizationException('You don\'t have access to ' . $operation);
        }
    }
}
