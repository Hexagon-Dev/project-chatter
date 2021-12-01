<?php

namespace App\Providers;

use App\Contracts\Services\MessageServiceInterface;
use App\Services\MessageService;
use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(MessageServiceInterface::class, MessageService::class);
    }
}
