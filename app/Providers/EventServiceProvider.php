<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use App\Listeners\MergeCartListener;
use App\Events\OrderPaidEvent;
use App\Listeners\SendOrderPaidEmail;

class EventServiceProviders extends ServiceProvider
{
    protected $listen = [
    Login::class => [
        MergeCartListener::class,
    ],
    OrderPaidEvent::class => [
        SendOrderPaidEmail::class,
    ],
];

    public function boot(): void
    {
        
    }
}