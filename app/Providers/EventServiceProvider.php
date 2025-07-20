<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Observers\CategoryObserver;
use App\Observers\NotificationObserver;
use App\Observers\OrderDetailObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // Order::observe(OrderObserver::class);
        Notification::observe(NotificationObserver::class);
        // OrderDetail::observe(OrderDetailObserver::class);
        Category::observe(CategoryObserver::class);
        Product::observe(ProductObserver::class);

        Order::observe(OrderObserver::class);
        OrderDetail::observe(OrderDetailObserver::class);
    }
}
