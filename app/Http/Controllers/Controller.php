<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AbstractService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var Authenticatable|User|null  */
    protected $user;
    protected int $userId;

    protected string $serviceInterface = '';

    protected ?AbstractService $service;

    public function __construct(?Authenticatable $user = null)
    {
        $this->user = $user;
        if ($this->serviceInterface) {
            $this->service = app()->make($this->serviceInterface);
        }
    }

    protected function checkPermission(string $operation): void
    {
        if (!$this->user->can($operation)) {
            dd($operation);
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
