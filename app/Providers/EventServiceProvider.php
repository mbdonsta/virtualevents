<?php

namespace App\Providers;

use App\Models\EventPoster;
use App\Models\EventRoomBanner;
use App\Models\ExhibitionStand;
use App\Models\ExhibitionStandItem;
use App\Observers\EventPosterObserver;
use App\Observers\EventRoomBannerObserver;
use App\Observers\ExhibitionStandItemObserver;
use App\Observers\ExhibitionStandObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */

    protected $observers = [
        EventRoomBanner::class => [EventRoomBannerObserver::class],
        ExhibitionStand::class => [ExhibitionStandObserver::class],
        ExhibitionStandItem::class => [ExhibitionStandItemObserver::class],
        EventPoster::class => [EventPosterObserver::class]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
