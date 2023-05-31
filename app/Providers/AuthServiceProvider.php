<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Event;
use App\Models\EventEmail;
use App\Models\EventPoster;
use App\Models\EventProgram;
use App\Models\EventRoom;
use App\Models\EventUser;
use App\Models\ExhibitionGroup;
use App\Models\ExhibitionStand;
use App\Models\ExhibitionStandItem;
use App\Policies\EventEmailPolicy;
use App\Policies\EventPolicy;
use App\Policies\EventPosterPolicy;
use App\Policies\EventProgramPolicy;
use App\Policies\EventRoomPolicy;
use App\Policies\EventUserPolicy;
use App\Policies\ExhibitionGroupPolicy;
use App\Policies\ExhibitionStandItemPolicy;
use App\Policies\ExhibitionStandPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        EventRoom::class => EventRoomPolicy::class,
        EventPoster::class => EventPosterPolicy::class,
        EventUser::class => EventUserPolicy::class,
        EventEmail::class => EventEmailPolicy::class,
        EventProgram::class => EventProgramPolicy::class,
        ExhibitionGroup::class => ExhibitionGroupPolicy::class,
        ExhibitionStand::class => ExhibitionStandPolicy::class,
        ExhibitionStandItem::class => ExhibitionStandItemPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $abilities) {
            if ($user->isAdmin()) {
                return true;
            }
        });
    }
}
